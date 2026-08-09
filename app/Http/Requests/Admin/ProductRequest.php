<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');
        $id = $product instanceof Product ? $product->id : $product;
        $isUpdate = (bool) $product;

        $rules = [
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|max:255|unique:products,sku,' . $id,
            'barcode'       => 'nullable|string|max:255|unique:products,barcode,' . $id,
            'description'   => 'nullable|string',

            // profit_margin is always a business decision the owner can change any time.
            'profit_margin' => 'required|numeric|min:0|max:1000',
            'minimum_stock' => 'nullable|integer|min:0',

            'category_id'   => 'nullable|exists:categories,id',
            'brand_id'      => 'nullable|exists:brands,id',
            'unit_id'       => 'nullable|exists:units,id',

            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'        => 'required|boolean',

            // Deliberately no 'stock' rule at all — stock is only ever
            // changed by PurchaseService (and later, Sales/Returns).
            // New products always start at 0.
        ];

        if (! $isUpdate) {
            // cost_price is only asked for on creation, as an initial
            // estimate so the product has a usable selling price before
            // its first purchase. From then on, every received purchase
            // overwrites it with the real, latest purchase cost.
            $rules['cost_price'] = 'required|numeric|min:0.01';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'cost_price.min'    => 'Purchase price must be greater than 0.',
            'profit_margin.max' => 'That profit margin looks too high — please double check it.',
        ];
    }
}