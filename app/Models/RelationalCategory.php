<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationalCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'attribute_id',
        'brand_id',
        'category_id',
        'metaable_id',
        'metaable_type',
    ];
    public function metaable()
    {
        return $this->morphTo();
    }
}
