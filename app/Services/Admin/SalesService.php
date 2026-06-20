<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\ProAttributeValue;
use Illuminate\Support\Facades\DB;

class SalesService
{
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