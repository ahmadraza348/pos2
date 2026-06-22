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
            'products'  => Product::where('status', 1)->get(['id', 'name', 'sku', 'cost_price']),
        ];
    }

    public function getEditData(string $id): array
    {
        $purchase = Purchase::with('items.product')->findOrFail($id);

        return [
            'purchase'  => $purchase,
            'suppliers' => Supplier::where('status', 1)->get(),
            'products'  => Product::where('status', 1)->get(['id', 'name', 'sku', 'cost_price']),
        ];
    }

    public function getTrashed()
    {
        return Purchase::onlyTrashed()->with('supplier')->get();
    }

    /* =========================
       STORE / UPDATE
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

                // Stock only moves in when the purchase is actually received
                if ($purchase->status === 'received') {
                    $this->adjustStock($item['product_id'], $item['quantity'], $item['unit_cost']);
                }
            }

            return $purchase;
        });
    }

    public function update(array $data, string $id): Purchase
    {
        return DB::transaction(function () use ($data, $id) {

            $purchase = Purchase::with('items')->findOrFail($id);
            $wasReceived = $purchase->status === 'received';

            // Reverse old stock impact before applying new one
            if ($wasReceived) {
                foreach ($purchase->items as $oldItem) {
                    $this->reverseStock($oldItem->product_id, $oldItem->quantity);
                }
            }

            $purchase->items()->delete();

            [$subtotal, $itemsData] = $this->prepareItems($data['items']);

            $discount = $data['discount'] ?? 0;
            $tax = $data['tax'] ?? 0;
            $total = $subtotal - $discount + $tax;
            $paid = $data['paid_amount'] ?? 0;
            $newStatus = $data['status'] ?? $purchase->status;

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

            foreach ($itemsData as $item) {
                $item['purchase_id'] = $purchase->id;
                PurchaseItem::create($item);

                if ($newStatus === 'received') {
                    $this->adjustStock($item['product_id'], $item['quantity'], $item['unit_cost']);
                }
            }

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

protected function adjustStock(
    int $productId,
    int $quantity,
    float $unitCost
): void {

    $product = Product::findOrFail($productId);

    $product->stock += $quantity;

    $product->cost_price = $unitCost;

    $product->save(); // booted() auto recalculates selling price
}

    protected function reverseStock(int $productId, int $quantity): void
    {
        $product = Product::findOrFail($productId);
        $product->decrement('stock', min($quantity, $product->stock));
    }

    protected function resolvePaymentStatus(float $total, float $paid): string
    {
        if ($paid <= 0) return 'unpaid';
        if ($paid >= $total) return 'paid';
        return 'partial';
    }
}