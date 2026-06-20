<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'slug',
        'status',
    ];
    public function attributevalue(){
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'pro_attribute_values')
                    ->withPivot(['attribute_value_id', 'itemcode', 'stock', 'price'])
                    ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'relational_categories', 'attribute_id', 'category_id')
                    ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
    
        static::deleting(function ($brand) {
            $brand->categories()->detach();
        });
    }

}
