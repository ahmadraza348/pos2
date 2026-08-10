<?php

namespace App\Services\Admin;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class PurchaseService
{
    /* =========================
       FETCH METHODS
    ==========================*/

    public function getAll()
    {
        return Purchase::with('supplier')->latest()->get();
    }

    public function getCreateData(): array
    {
        return [
            'suppliers' => Supplier::where('status', 1)->get(),
            'products'  => Product::where('status', 1)
                ->get(['id', 'name', 'sku', 'cost_price', 'profit_margin', 'selling_price', 'stock']),
        ];
    }

    public function getEditData(string $id): array
    {
        $purchase = Purchase::with('items.product')->findOrFail($id);

        return [
            'purchase'  => $purchase,
            'suppliers' => Supplier::where('status', 1)->get(),
            'products'  => Product::where('status', 1)
                ->get(['id', 'name', 'sku', 'cost_price', 'profit_margin', 'selling_price', 'stock']),
        ];
    }

    public function getTrashed()
    {
        return Purchase::onlyTrashed()->with('supplier')->get();
    }

    /* =========================
       STORE
    ==========================*/

    public function store(array $data): Purchase
    {
        return DB::transaction(function () use ($data) {

            [$subtotal, $itemsData] = $this->prepareItems($data['items']);

            $discount = $data['discount'] ?? 0;
            $tax = $data['tax'] ?? 0;
            $total = $subtotal - $discount + $tax;
            $paid = $data['paid_amount'] ?? 0;

            $purchase = Purchase::create([
                'invoice_no'     => $data['invoice_no'],
                'supplier_id'    => $data['supplier_id'],
                'purchase_date'  => $data['purchase_date'],
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'tax'            => $tax,
                'total_amount'   => $total,
                'paid_amount'    => $paid,
                'due_amount'     => max($total - $paid, 0),
                'payment_status' => $data['payment_status'] ?? $this->resolvePaymentStatus($total, $paid),
                'status'         => $data['status'] ?? 'received',
                'notes'          => $data['notes'] ?? null,
                'created_by'     => Auth::guard('admin')->id(),
            ]);

            foreach ($itemsData as $item) {
                $item['purchase_id'] = $purchase->id;
                PurchaseItem::create($item);

                // Stock only moves in when the purchase is actually received.
                if ($purchase->status === 'received') {
                    $this->adjustStock($item['product_id'], $item['quantity'], $item['unit_cost']);
                }
            }

            return $purchase;
        });
    }

    /* =========================
       UPDATE
    ==========================*/

    /**
     * A purchase can be edited at any time UNLESS it's cancelled (fully
     * closed). If it was already "received" (stock already moved), we
     * reverse its old items and reapply the new ones — but only after
     * confirming every product involved still has enough stock on hand
     * to safely reverse. If any product has already had some of that
     * stock sold, the whole update is rejected with a clear explanation
     * instead of silently under-reversing.
     */
    public function update(array $data, string $id): Purchase
    {
        return DB::transaction(function () use ($data, $id) {

            $purchase = Purchase::with('items')->findOrFail($id);

            if ($purchase->status === 'cancelled') {
                throw ValidationException::withMessages([
                    'status' => 'This purchase is cancelled and can no longer be edited.',
                ]);
            }

            $wasReceived = $purchase->status === 'received';
            $newStatus = $data['status'] ?? $purchase->status;

            if ($wasReceived) {
                $this->assertReversalIsSafe($purchase->items);

                foreach ($purchase->items as $oldItem) {
                    $this->reverseStock($oldItem->product_id, $oldItem->quantity);
                }
            }

            $purchase->items()->delete();

            [$subtotal, $itemsData] = $this->prepareItems($data['items']);

            foreach ($itemsData as $item) {
                $item['purchase_id'] = $purchase->id;
                PurchaseItem::create($item);
            }

            if ($newStatus === 'received') {
                foreach ($itemsData as $item) {
                    $this->adjustStock($item['product_id'], $item['quantity'], $item['unit_cost']);
                }
            }

            $discount = $data['discount'] ?? 0;
            $tax = $data['tax'] ?? 0;
            $total = $subtotal - $discount + $tax;
            $paid = $data['paid_amount'] ?? 0;

            $purchase->update([
                'invoice_no'     => $data['invoice_no'],
                'supplier_id'    => $data['supplier_id'],
                'purchase_date'  => $data['purchase_date'],
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'tax'            => $tax,
                'total_amount'   => $total,
                'paid_amount'    => $paid,
                'due_amount'     => max($total - $paid, 0),
                'payment_status' => $data['payment_status'] ?? $this->resolvePaymentStatus($total, $paid),
                'status'         => $newStatus,
                'notes'          => $data['notes'] ?? null,
            ]);

            return $purchase;
        });
    }

    /* =========================
       DELETE / RESTORE
    ==========================*/

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $purchase = Purchase::with('items')->findOrFail($id);

            if ($purchase->status === 'received') {
                $this->assertReversalIsSafe($purchase->items);

                foreach ($purchase->items as $item) {
                    $this->reverseStock($item->product_id, $item->quantity);
                }
            }

            $purchase->delete();
        });
    }

    public function restore(string $id): void
    {
        Purchase::withTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete(string $id): void
    {
        Purchase::withTrashed()->findOrFail($id)->forceDelete();
    }

    /* =========================
       HELPERS
    ==========================*/

    protected function prepareItems(array $items): array
    {
        $subtotal = 0;
        $prepared = [];

        foreach ($items as $item) {
            $lineTotal = $item['quantity'] * $item['unit_cost'];
            $subtotal += $lineTotal;

            $prepared[] = [
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_cost'  => $item['unit_cost'],
                'total'      => $lineTotal,
            ];
        }

        return [$subtotal, $prepared];
    }

    /**
     * Blocks an edit/delete/cancel if reversing any item would need to
     * remove more stock than the product currently has — meaning some of
     * it has already been sold. Checked BEFORE anything is changed, so
     * the whole operation either fully succeeds or doesn't touch the
     * database at all.
     */
    protected function assertReversalIsSafe(Collection $items): void
    {
        foreach ($items as $item) {
            $product = Product::find($item->product_id);

            if (! $product) {
                continue; // product was deleted separately — nothing to check against
            }

            if ($product->stock < $item->quantity) {
                throw ValidationException::withMessages([
                    'items' => "Can't save changes — \"{$product->name}\" only has {$product->stock} left in "
                        . "stock, but this purchase originally added {$item->quantity}. Some of it has already "
                        . "been sold, so this purchase can't be edited or cancelled anymore. Record a separate "
                        . "purchase or stock adjustment instead.",
                ]);
            }
        }
    }

    /**
     * Adds stock and blends the new purchase cost into the product's
     * existing cost using a weighted average — so buying more of a
     * product at a different price nudges the cost, rather than the
     * latest purchase silently overwriting what earlier stock cost.
     *
     * Example: 4 in stock at Rs. 100, +4 more at Rs. 120
     *        → (4×100 + 4×120) / 8 = Rs. 110 average cost.
     *
     * Product::boot() then recalculates selling_price from this new
     * cost + the existing profit_margin automatically.
     */
    protected function adjustStock(int $productId, int $quantity, float $unitCost): void
    {
        $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();

        $oldStock = $product->stock;
        $oldCost = (float) $product->cost_price;
        $newStock = $oldStock + $quantity;

        $avgCost = $newStock > 0
            ? (($oldStock * $oldCost) + ($quantity * $unitCost)) / $newStock
            : $unitCost;

        $product->update([
            'stock'      => $newStock,
            'cost_price' => round($avgCost, 2),
        ]);
    }

    /**
     * Removes stock that a (now edited/cancelled) purchase had added.
     * cost_price is intentionally left as-is — a weighted average can't
     * be precisely "un-blended" without keeping full purchase history,
     * which is more bookkeeping than a small store needs. Call sites
     * always check assertReversalIsSafe() first, so this never needs to
     * silently clamp in practice.
     */
    protected function reverseStock(int $productId, int $quantity): void
    {
        $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();
        $product->decrement('stock', min($quantity, $product->stock));
    }

    protected function resolvePaymentStatus(float $total, float $paid): string
    {
        if ($paid <= 0) return 'unpaid';
        if ($paid >= $total) return 'paid';
        return 'partial';
    }
}