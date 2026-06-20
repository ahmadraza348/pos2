<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        $admin = auth('admin')->user();

        return $admin
            ? $admin->can('create', Category::class)
            : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
          return [
            'name' => 'required|string|max:255',
     'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->ignore($this->category->id),
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',


        ];
    }
}
