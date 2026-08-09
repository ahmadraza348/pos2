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
        'name', 'sku', 'barcode', 'description',
        'cost_price', 'profit_margin', 'selling_price',
        'stock', 'minimum_stock',
        'category_id', 'brand_id', 'unit_id',
        'image', 'status', 'is_featured',
    ];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock'         => 'integer',
        'minimum_stock' => 'integer',
        'status'        => 'boolean',
        'is_featured'   => 'boolean',
    ];

    /**
     * selling_price is ALWAYS derived from cost_price + profit_margin.
     *
     * This is intentionally the ONLY place selling_price is calculated.
     * It is never accepted as direct input from the product form (see
     * ProductRequest — there is no selling_price rule), so it can never
     * drift out of sync with cost/margin, and there's no risk of a form
     * value silently overriding this calculation or vice versa.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $cost   = (float) $product->cost_price;
            $margin = (float) $product->profit_margin;

            $product->selling_price = round($cost * (1 + $margin / 100), 2);
        });
    }

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

    /* =========================
       ACCESSORS
    ==========================*/
    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->minimum_stock;
    }

    /* =========================
       SCOUT
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