<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
$brandId = $this->route('brand') ? $this->route('brand')->id : null;
        return [
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:brands,slug,' . $brandId,
            'website'        => 'nullable|url',
            'description'    => 'nullable|string',
            'status'         => 'required|in:0,1',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category'       => 'nullable|array',
            'subcategory'    => 'nullable|array',
            'childcategory'  => 'nullable|array',
            'superchild'     => 'nullable|array',
        ];
    }
}
