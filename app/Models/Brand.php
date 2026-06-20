<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // The attributes that are mass assignable
    protected $fillable = ['name', 'slug', 'website', 'image', 'description', 'status'];

    /**
     * Define the relationship with the categories (many-to-many).
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'relational_categories', 'brand_id', 'category_id')
                    ->withTimestamps();
    }
    public function products(){
        return $this->hasMany(Product::class , 'brand_id');
    }
    public static function boot()
    {
        parent::boot();
    
        static::deleting(function ($brand) {
            $brand->categories()->detach();
        });
    }


}
