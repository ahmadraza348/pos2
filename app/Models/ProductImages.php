<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'image',
        'is_featured',
        'is_back',
        'sort_order'
    ];
}
