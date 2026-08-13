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
                $createdItem = PurchaseItem::create($item);

                // Stock only moves in when the purchase is actually received.
                if ($purchase->status === 'received') {
                    $this->adjustStock($createdItem, $item['quantity'], $item['unit_cost']);
                }
            }

            return $purchase;
        });
    }

    /* =========================
       UPDATE
    ==========================*/

    /**
     * A purchase's items can only be edited while it's still "pending" —
     * nothing has touched real stock or cost yet, so free editing is safe.
     *
     * Once it's "received", its items have already moved stock and been
     * blended into each product's weighted-average cost. That blend can't
     * be reliably "re-edited" (see reverseReceivedPurchase()), so from
     * here on the purchase is view-only. The only transition left is
     * "cancelled", which reverses its stock/cost in a controlled way. A
     * "cancelled" purchase is fully closed and can't be touched at all.
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

            $newStatus = $data['status'] ?? $purchase->status;

            if ($purchase->status === 'received') {
                if (! in_array($newStatus, ['received', 'cancelled'], true)) {
                    throw ValidationException::withMessages([
                        'status' => 'A received purchase can only stay received or be cancelled — its items are locked.',
                    ]);
                }

                if ($newStatus === 'cancelled') {
                    $this->reverseReceivedPurchase($purchase->items);
                }

                // Items are locked here on purpose — no create/delete of
                // PurchaseItem rows, so subtotal/items stay exactly as they
                // were when the stock/cost was originally applied.
                $subtotal = (float) $purchase->subtotal;
                $discount = $data['discount'] ?? (float) $purchase->discount;
                $tax = $data['tax'] ?? (float) $purchase->tax;
                $total = $subtotal - $discount + $tax;
                $paid = $data['paid_amount'] ?? (float) $purchase->paid_amount;

                $purchase->update([
                    'invoice_no'     => $data['invoice_no'] ?? $purchase->invoice_no,
                    'supplier_id'    => $data['supplier_id'] ?? $purchase->supplier_id,
                    'purchase_date'  => $data['purchase_date'] ?? $purchase->purchase_date,
                    'discount'       => $discount,
                    'tax'            => $tax,
                    'total_amount'   => $total,
                    'paid_amount'    => $paid,
                    'due_amount'     => max($total - $paid, 0),
                    'payment_status' => $data['payment_status'] ?? $this->resolvePaymentStatus($total, $paid),
                    'status'         => $newStatus,
                    'notes'          => $data['notes'] ?? $purchase->notes,
                ]);

                return $purchase;
            }

            // Still pending: items are freely editable, and stock/cost is
            // only applied now if this same update also marks it received.
            $purchase->items()->delete();

            [$subtotal, $itemsData] = $this->prepareItems($data['items']);

            foreach ($itemsData as $item) {
                $item['purchase_id'] = $purchase->id;
                $createdItem = PurchaseItem::create($item);

                if ($newStatus === 'received') {
                    $this->adjustStock($createdItem, $item['quantity'], $item['unit_cost']);
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

    /**
     * A "received" purchase can't be deleted directly — deleting it would
     * need to reverse stock/cost the same way cancelling does, but without
     * going through the update() flow's status check. Requiring "cancel
     * first, then delete" keeps that reversal in exactly one place.
     * "pending" purchases never touched stock, so they delete freely.
     * "cancelled" purchases were already reversed when they were
     * cancelled, so deleting them needs no further stock/cost change.
     */
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $purchase = Purchase::with('items')->findOrFail($id);

            if ($purchase->status === 'received') {
                throw ValidationException::withMessages([
                    'status' => 'This purchase is received — cancel it first to safely reverse its stock and '
                        . 'cost, then delete it.',
                ]);
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
     *
     * The product's stock/cost from just BEFORE this change are snapshotted
     * onto the PurchaseItem itself, so that if this purchase is later
     * cancelled, reverseReceivedPurchase() can restore the product to
     * exactly what it was — rather than just subtracting the quantity and
     * leaving the blended cost stale.
     */
    protected function adjustStock(PurchaseItem $item, int $quantity, float $unitCost): void
    {
        $product = Product::where('id', $item->product_id)->lockForUpdate()->firstOrFail();

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

        $item->update([
            'previous_stock'      => $oldStock,
            'previous_cost_price' => $oldCost,
        ]);
    }

    /**
     * Reverses a received purchase's items — precisely restoring both
     * stock AND cost_price, not just stock. This only works, and is only
     * attempted, when it's still verifiably safe:
     *
     *   1) None of the stock this item added has since been sold (same
     *      check the old assertReversalIsSafe() did), and
     *   2) The product's stock/cost haven't been touched by anything else
     *      since this item was received — otherwise restoring the
     *      snapshot would also silently wipe out that unrelated change.
     *
     * Everything is validated first and applied only after every item
     * passes, so a cancellation either fully succeeds or leaves the
     * database completely untouched.
     */
    protected function reverseReceivedPurchase(Collection $items): void
    {
        $products = [];

        foreach ($items as $item) {
            $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

            if (! $product) {
                continue; // product was deleted separately — nothing to reverse
            }

            if ($product->stock < $item->quantity) {
                throw ValidationException::withMessages([
                    'items' => "Can't cancel — \"{$product->name}\" only has {$product->stock} left in stock, "
                        . "but this purchase originally added {$item->quantity}. Some of it has already been "
                        . "sold, so this purchase can no longer be cancelled. Record a stock adjustment instead.",
                ]);
            }

            // Items received before the previous_stock/previous_cost_price
            // snapshot existed have nothing to precisely restore — fall
            // back to a stock-only reversal for those legacy rows.
            if ($item->previous_stock === null || $item->previous_cost_price === null) {
                $products[] = ['product' => $product, 'item' => $item, 'mode' => 'stock_only'];
                continue;
            }

            $expectedStockBefore = $item->previous_stock + $item->quantity;
            $expectedCostBefore = round(
                (($item->previous_stock * $item->previous_cost_price) + ($item->quantity * $item->unit_cost))
                    / max($expectedStockBefore, 1),
                2
            );

            $stockMatches = (int) $product->stock === (int) $expectedStockBefore;
            $costMatches = abs((float) $product->cost_price - $expectedCostBefore) < 0.01;

            if (! $stockMatches || ! $costMatches) {
                throw ValidationException::withMessages([
                    'items' => "Can't cancel — \"{$product->name}\" has since been changed by another purchase "
                        . "or stock adjustment, so this one can no longer be safely un-done. Record a stock "
                        . "adjustment instead.",
                ]);
            }

            $products[] = ['product' => $product, 'item' => $item, 'mode' => 'restore'];
        }

        foreach ($products as $entry) {
            if ($entry['mode'] === 'stock_only') {
                $entry['product']->decrement('stock', min($entry['item']->quantity, $entry['product']->stock));
                continue;
            }

            $entry['product']->update([
                'stock'      => $entry['item']->previous_stock,
                'cost_price' => $entry['item']->previous_cost_price,
            ]);
        }
    }

    protected function resolvePaymentStatus(float $total, float $paid): string
    {
        if ($paid <= 0) return 'unpaid';
        if ($paid >= $total) return 'paid';
        return 'partial';
    }
}