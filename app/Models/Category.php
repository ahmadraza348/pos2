<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function getImageNameAttribute($value)
    {

        return public_path($value);
    }

    protected $fillable = ['name','image', 'description', 'status'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'relational_categories', 'category_id', 'product_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'ASC');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
