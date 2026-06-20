<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name', 'slug', 'color_code','status'];

    public function products(){
        return $this->belongsToMany(Product::class, 'pro_attribute_values', 'color_id', 'product_id')
            ->withPivot(['attribute_value_id', 'itemcode', 'stock', 'price'])
            ->withTimestamps();
    }
}
