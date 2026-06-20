<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;    

class BulkDeleteCategoryRequest extends FormRequest
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
            'category_ids' => 'required|string'
        ];
    }

    public function getCategoryIds(): array
    {
        return array_filter(explode(',', $this->category_ids));
    }
}
