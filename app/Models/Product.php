<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;



class Product extends Model
{
    use HasFactory, SoftDeletes,  Searchable;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'product_variation_type',
        'status',
        'sale_price',
        'previous_price',
        'purchase_price',
        'barcode',
        'stock',
        'tags',
        'label',
        'is_featured',
        'short_description',
        'long_description',
        'video',
        'brand_id',
        'attribute_id'
    ];

    // for detail page to show colors and sizes
    public function proAttributeValuesRecords()
    {
        return $this->hasMany(ProAttributeValue::class, 'product_id');
    }

    public function gallery_images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    // for filtering products on shop page
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'pro_attribute_values')
            ->withPivot(['attribute_value_id', 'color_id', 'itemcode', 'stock', 'price'])
            ->withTimestamps();
    }
    public function colors(){
        return $this->belongsToMany(Color::class, 'pro_attribute_values', 'product_id', 'color_id')
            ->withPivot(['attribute_value_id', 'itemcode', 'stock', 'price'])
            ->withTimestamps();
    }
      public function categories()
    {
        return $this->belongsToMany(Category::class, 'relational_categories', 'product_id', 'category_id')
            ->withTimestamps();
    }

    // if we delete product then all its meta tags will also be deleted
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {
            $product->categories()->detach();
        });
    }
    public function categoryCount()
    {
        return $this->categories()->count();
    }

    // Laravel Scout Searchable implementation
    public function toSearchableArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'tags' => $this->tags,
        ];
    }

    public function scopeActive($query)
{
    return $query->where('status', 1);
}

}
