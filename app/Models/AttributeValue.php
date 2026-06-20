<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
       'attribute_id',
        'name',
        'slug',
        'status',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'pro_attribute_values', 'attribute_value_id', 'product_id')->distinct();
    }
    

    
}
