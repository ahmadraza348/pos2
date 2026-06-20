<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id', 
        'user_name', 
        'user_email', 
        'comment', 
        'rating'
    ];

    // Each review belongs to one product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}