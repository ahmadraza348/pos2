<?php

namespace App\Services\Admin;

use App\Models\Attribute;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProAttributeValue;
use Illuminate\Support\Facades\DB;

class ProAttributeService
{
    public function getAttributesData(int $product_id): array
    {
        $product = Product::findOrFail($product_id);

        $data = [
            'colors' => Color::where('status', 1)->get(),
            'product' => $product,
        ];

        if ($product->product_variation_type === 'color_attribute_varient') {
            $data['attribute_data'] = Attribute::with('attributevalue')
                ->find($product->attribute_id);
        }

        return $data;
    }

    public function fetchAttributes(int $product_id)
    {
        return ProAttributeValue::with(['color', 'attribute_value'])
            ->where('product_id', $product_id)
            ->latest()
            ->get();
    }

    public function storeAttributeData(array $data): ProAttributeValue
    {
        return DB::transaction(function () use ($data) {
            return ProAttributeValue::create($data);
        });
    }

    public function updateAttributeData(array $data, int $id): ProAttributeValue
    {
        return DB::transaction(function () use ($data, $id) {

            $attribute = ProAttributeValue::findOrFail($id);
            $attribute->update($data);

            return $attribute;
        });
    }

    public function deleteAttribute(int $id): bool
    {
        $attribute = ProAttributeValue::findOrFail($id);
        return $attribute->delete();
    }
}