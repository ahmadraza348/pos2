<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

// Replace rules() entirely with this:
public function rules(): array
{
    $product = $this->route('product');
    $id = ($product instanceof Product) ? $product->id : $product;

    return [
        'name'           => 'required|string|max:255',
        'sku'            => 'required|string|max:255|unique:products,sku,' . $id,
        'barcode'        => 'nullable|string|max:255|unique:products,barcode,' . $id,
        'description'    => 'nullable|string',

        'cost_price'     => 'required|numeric|min:0',
        'selling_price'  => 'required|numeric|min:0',
        'profit_margin'  => 'nullable|numeric|min:0|max:1000',
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

    public function messages(): array
    {
        return [
            'selling_price.prohibited' => 'Selling price is calculated automatically.',
            'cost_price.prohibited'    => 'Cost price is set via purchases, not the product form.',
            'stock.prohibited'         => 'Stock is managed via purchases, not the product form.',
        ];
    }
}