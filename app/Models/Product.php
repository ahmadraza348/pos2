<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'description',
        'cost_price',
        'selling_price',
        'stock',
        'minimum_stock',
        'category_id',
        'brand_id',
        'unit_id',
        'image',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'cost_price'     => 'decimal:2',
        'selling_price'  => 'decimal:2',
        'stock'          => 'integer',
        'minimum_stock'  => 'integer',
        'status'         => 'boolean',
        'is_featured'    => 'boolean',
    ];

    /* =========================
       RELATIONSHIPS
    ==========================*/

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /* =========================
       SCOPES
    ==========================*/

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'minimum_stock');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    /* =========================
       ACCESSORS
    ==========================*/

    public function getProfitMarginAttribute(): float
    {
        if ((float) $this->cost_price <= 0) {
            return 0;
        }

        return round((($this->selling_price - $this->cost_price) / $this->cost_price) * 100, 2);
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->minimum_stock;
    }

    /* =========================
       SCOUT SEARCH
    ==========================*/

    public function toSearchableArray(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'sku'     => $this->sku,
            'barcode' => $this->barcode,
        ];
    }
}