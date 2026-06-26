<?php

namespace App\Http\Requests\Admin;

use App\Models\ExpenseCategory;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $category = $this->route('expense_category');
        $id = ($category instanceof ExpenseCategory) ? $category->id : $category;

        return [
            'name'        => 'required|string|max:255|unique:expense_categories,name,' . $id,
            'description' => 'nullable|string',
            'status'      => 'nullable|boolean',
        ];
    }
}