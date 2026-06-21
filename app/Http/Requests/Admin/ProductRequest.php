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
        $id = ($product instanceof Product) ? $product->id : $product;

        return [
            'name'           => 'required|string|max:255',
            'sku'            => 'required|string|max:255|unique:products,sku,' . $id,
            'barcode'        => 'nullable|string|max:255|unique:products,barcode,' . $id,
            'description'    => 'nullable|string',

            'cost_price'     => 'required|numeric|min:0|max:99999999.99',
            'selling_price'  => 'required|numeric|min:0|max:99999999.99|gte:cost_price',

            'stock'          => 'required|integer|min:0',
            'minimum_stock'  => 'nullable|integer|min:0',

            'category_id'    => 'nullable|exists:categories,id',
            'brand_id'       => 'nullable|exists:brands,id',
            'unit_id'        => 'nullable|exists:units,id',

            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'nullable|boolean',
            'is_featured'    => 'nullable|boolean',
        ];
    }
}