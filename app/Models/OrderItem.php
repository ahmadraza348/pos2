<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImages;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'line_total',
        'color_id',
        'color_name',
        'attribute_id',
        'attribute_name',
        'attribute_value',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function attribute()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_id');
    }

    // get product images in admin panel sales tab

    public function images(){
        return $this->hasMany(ProductImages::class, 'product_id', 'product_id');
    }
}