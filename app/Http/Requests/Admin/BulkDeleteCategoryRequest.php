<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
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
