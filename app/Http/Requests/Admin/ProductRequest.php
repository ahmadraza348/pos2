<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function rules(): array
{

        $param = $this->route('product');
        $id = ($param instanceof Product) ? $param->id : $param; 

    return [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products,slug,' . $id,
        'sku' => 'required|string|max:255|unique:products,sku,' . $id,
        'sale_price' => 'required|numeric|max:99999',
        'previous_price' => 'nullable|numeric|max:99999',
        'purchase_price' => 'nullable|numeric|max:99999',
        'barcode' => 'required|string|max:255',
        'stock' => 'required|integer|max:99999',
        'tags' => 'nullable|string',
        'product_variation_type' => 'nullable|string',
        'label' => 'nullable|string',
        'short_description' => 'nullable',
        'long_description' => 'nullable',
        'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
        'brand_id' => 'nullable|integer',
        'is_featured' => 'nullable',
        'attribute_id' => 'nullable|integer',
        'meta_title' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'meta_description' => 'nullable|string',
    ];
}

}
