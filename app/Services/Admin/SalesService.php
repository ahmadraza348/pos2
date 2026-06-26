<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\ProAttributeValue;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class SalesService
{


 public function getAll(array $filters = [])
    {
        return Sale::query()
            ->with('customer')
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['payment_status'] ?? null, fn ($q, $v) => $q->where('payment_status', $v))
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when($filters['search'] ?? null, fn ($q, $v) => $q->where('invoice_no', 'like', "%{$v}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();
    }

    public function find(int $id): Sale
    {
        return Sale::with('items', 'customer', 'creator', 'returns')->findOrFail($id);
    }

    public function void(int $id): Sale
    {
        return DB::transaction(function () use ($id) {
            $sale = Sale::where('status', 'completed')->with('items')->findOrFail($id);

            if ($sale->returns()->exists()) {
                throw ValidationException::withMessages([
                    'sale' => 'This sale already has returns recorded and cannot be voided directly.',
                ]);
            }

            foreach ($sale->items as $item) {
                Product::lockForUpdate()->find($item->product_id)?->increment('stock', $item->quantity);
            }

            $sale->update(['status' => 'cancelled']);

            return $sale;
        });
    }
















    public function getsales()
    {
        return Order::with('items')->get();
    }

    public function updateOrderStatus(Order $order)
    {
        $order->order_status = request('order_status');
        $order->order_comment = request('order_comment');
        $order->save();
    }

    public function cancelOrder(Order $order)
    {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->color_id || $item->attribute_id) {                    
                    $variant = ProAttributeValue::where('product_id', $item->product_id)
                        ->where('color_id', $item->color_id)                      
                        ->where('attribute_value_id', $item->attribute_id) 
                        ->first();
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                    }
                 }              
                else {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }
            $order->update([
                'order_status' => 'cancelled',
                'payment_status' => ($order->payment_status == 'paid') ? 'refunded' : $order->payment_status
            ]);
        });
    }
}