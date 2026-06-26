<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id', 'product_id', 'product_name', 'product_sku',
        'cost_price', 'selling_price', 'quantity', 'discount', 'total',
    ];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'selling_price' => 'decimal:2',
        'quantity'      => 'integer',
        'discount'      => 'decimal:2',
        'total'         => 'decimal:2',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function returnItems()
{
    return $this->hasMany(ReturnItem::class);
}

public function getReturnedQuantityAttribute(): int
{
    return (int) $this->returnItems()->sum('quantity_returned');
}
}