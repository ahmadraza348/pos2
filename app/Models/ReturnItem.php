<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $fillable = [
        'return_id', 'sale_item_id', 'product_id', 'product_name',
        'product_sku', 'unit_price', 'quantity_returned', 'total',
    ];

    protected $casts = [
        'unit_price'        => 'decimal:2',
        'quantity_returned' => 'integer',
        'total'             => 'decimal:2',
    ];

    public function saleReturn() { return $this->belongsTo(SaleReturn::class, 'return_id'); }
    public function saleItem() { return $this->belongsTo(SaleItem::class); }
    public function product() { return $this->belongsTo(Product::class); }
}