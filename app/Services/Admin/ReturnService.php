<?php

namespace App\Services\Admin;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleReturn;
use App\Models\ReturnItem;
use App\Models\Product;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReturnService
{
    public function findSaleForReturn(string $invoiceNo): array
    {
        $sale = Sale::where('invoice_no', $invoiceNo)
            ->where('status', 'completed')
            ->with('items', 'customer')
            ->first();

        if (!$sale) {
            throw ValidationException::withMessages([
                'invoice_no' => 'No completed sale found with this invoice number.',
            ]);
        }

        $items = $sale->items->map(function (SaleItem $item) {
            $alreadyReturned = ReturnItem::where('sale_item_id', $item->id)->sum('quantity_returned');
            return [
                'sale_item_id'     => $item->id,
                'product_name'     => $item->product_name,
                'product_sku'      => $item->product_sku,
                'sold_qty'         => $item->quantity,
                'already_returned' => (int) $alreadyReturned,
                'returnable_qty'   => max($item->quantity - $alreadyReturned, 0),
            ];
        })->values();

        return ['sale' => $sale, 'items' => $items];
    }

    public function create(array $data): SaleReturn
    {
        return DB::transaction(function () use ($data) {

            $sale = Sale::where('status', 'completed')->findOrFail($data['sale_id']);
            $restock = (bool) ($data['restock'] ?? true);
            $refundTotal = 0;
            $resolvedItems = [];

            foreach ($data['items'] as $row) {
                $qty = (int) ($row['quantity'] ?? 0);
                if ($qty <= 0) continue; // skip rows the cashier left at 0

                $saleItem = SaleItem::where('sale_id', $sale->id)->findOrFail($row['sale_item_id']);

                $alreadyReturned = ReturnItem::where('sale_item_id', $saleItem->id)->sum('quantity_returned');
                $returnable = $saleItem->quantity - $alreadyReturned;

                if ($qty > $returnable) {
                    throw ValidationException::withMessages([
                        'items' => "Cannot return {$qty} of \"{$saleItem->product_name}\" — only {$returnable} remaining returnable.",
                    ]);
                }

                $lineTotal = $saleItem->selling_price * $qty;
                $refundTotal += $lineTotal;

                $resolvedItems[] = ['sale_item' => $saleItem, 'quantity' => $qty, 'total' => $lineTotal];
            }

            if (empty($resolvedItems)) {
                throw ValidationException::withMessages(['items' => 'No valid items to return.']);
            }

            $saleReturn = SaleReturn::create([
                'return_no'     => $this->generateReturnNumber(),
                'sale_id'       => $sale->id,
                'customer_id'   => $sale->customer_id,
                'refund_amount' => $refundTotal,
                'refund_method' => $data['refund_method'],
                'restocked'     => $restock,
                'reason'        => $data['reason'] ?? null,
                'created_by'    => $this->resolveCreatedBy(),
            ]);

            foreach ($resolvedItems as $item) {
                $saleItem = $item['sale_item'];

                ReturnItem::create([
                    'return_id'         => $saleReturn->id,
                    'sale_item_id'      => $saleItem->id,
                    'product_id'        => $saleItem->product_id,
                    'product_name'      => $saleItem->product_name,
                    'product_sku'       => $saleItem->product_sku,
                    'unit_price'        => $saleItem->selling_price,
                    'quantity_returned' => $item['quantity'],
                    'total'             => $item['total'],
                ]);

                if ($restock) {
                    Product::lockForUpdate()->find($saleItem->product_id)?->increment('stock', $item['quantity']);
                }
            }

            $this->syncSaleStatusIfFullyReturned($sale);

            return $saleReturn->load('items');
        });
    }

    protected function syncSaleStatusIfFullyReturned(Sale $sale): void
    {
        $totalSold = $sale->items()->sum('quantity');
        $totalReturned = ReturnItem::whereIn('sale_item_id', $sale->items()->pluck('id'))->sum('quantity_returned');

        if ($totalSold > 0 && $totalReturned >= $totalSold) {
            $sale->update(['status' => 'refunded']);
        }
    }

    public function getAll()
    {
        return SaleReturn::with('sale', 'customer')->latest()->get();
    }

    public function find(int $id): SaleReturn
    {
        return SaleReturn::with('items', 'sale', 'customer', 'creator')->findOrFail($id);
    }

    protected function generateReturnNumber(): string
    {
        $date = now()->format('Ymd');
        do {
            $count = SaleReturn::withTrashed()->whereDate('created_at', now())->count() + 1;
            $candidate = "RET-{$date}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
            $exists = SaleReturn::withTrashed()->where('return_no', $candidate)->exists();
        } while ($exists);

        return $candidate;
    }

    protected function resolveCreatedBy(): ?int
    {
        $id = Auth::guard('admin')->id();
        return $id && Admin::where('id', $id)->exists() ? $id : null;
    }
}