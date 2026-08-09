<?php

namespace App\Services\Admin;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
     * Updating a purchase behaves differently depending on whether it has
     * already affected stock:
     *
     * - PENDING  → items are still fully editable. No stock has moved yet,
     *              so we can safely replace the item list and, if the new
     *              status is "received", apply stock for the first time.
     *
     * - RECEIVED / CANCELLED → items are locked. We never touch them again,
     *              because reversing-and-reapplying against quantities that
     *              may have already been partially sold is exactly the kind
     *              of silent stock corruption this system needs to avoid.
     *              The only stock-affecting action left is cancelling a
     *              received purchase, which reverses its original items
     *              exactly once. Everything else (supplier, dates, payment
     *              info, notes) can still be corrected freely.
     */
    public function update(array $data, string $id): Purchase
    {
        return DB::transaction(function () use ($data, $id) {

            $purchase = Purchase::with('items')->findOrFail($id);
            $wasReceived = $purchase->status === 'received';
            $itemsLocked = $purchase->items_locked;
            $newStatus = $data['status'] ?? $purchase->status;

            if (! $itemsLocked) {
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
            } else {
                // Items are locked — totals stay exactly as originally recorded.
                $subtotal = (float) $purchase->subtotal;

                if ($wasReceived && $newStatus === 'cancelled') {
                    foreach ($purchase->items as $item) {
                        $this->reverseStock($item->product_id, $item->quantity);
                    }
                }
            }

            $discount = $data['discount'] ?? (float) $purchase->discount;
            $tax = $data['tax'] ?? (float) $purchase->tax;
            $total = $subtotal - $discount + $tax;
            $paid = $data['paid_amount'] ?? (float) $purchase->paid_amount;

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
            $lineTotal = ($item['quantity'] * $item['unit_cost']) - ($item['discount'] ?? 0);
            $subtotal += $lineTotal;

            $prepared[] = [
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_cost'  => $item['unit_cost'],
                'discount'   => $item['discount'] ?? 0,
                'total'      => $lineTotal,
            ];
        }

        return [$subtotal, $prepared];
    }

    protected function adjustStock(int $productId, int $quantity, float $unitCost): void
    {
        $product = Product::findOrFail($productId);
        $product->increment('stock', $quantity);

        // Update cost_price to the latest purchase price.
        // Product::boot() auto-recalculates selling_price from this new
        // cost + the existing profit_margin — receiving a purchase at a
        // new cost updates the shelf price automatically.
        $product->update(['cost_price' => $unitCost]);
    }

    protected function reverseStock(int $productId, int $quantity): void
    {
        $product = Product::findOrFail($productId);
        // Clamped so a purchase reversal can never push stock negative —
        // if some of this stock was already sold, the reversal will be
        // partial. selling_price/cost_price are left as-is, since we don't
        // know what the correct prior cost was.
        $product->decrement('stock', min($quantity, $product->stock));
    }

    protected function resolvePaymentStatus(float $total, float $paid): string
    {
        if ($paid <= 0) return 'unpaid';
        if ($paid >= $total) return 'paid';
        return 'partial';
    }
}