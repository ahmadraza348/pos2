<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id','attribute_id','attribute_value_id','itemcode','stock','price','color_id'
    ];

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
