<?php

namespace App\Http\Requests\Admin;

use App\Models\Expense;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $expense = $this->route('expense');
        $id = ($expense instanceof Expense) ? $expense->id : $expense;

        return [
            'expense_category_id' => 'required|exists:expense_categories,id',
            'expense_date'        => 'required|date',
            'amount'              => 'required|numeric|min:0.01',
            'payment_method'      => 'required|in:cash,card,bank_transfer',
            'payment_reference'   => 'nullable|string|max:255',
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'attachment'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ];
    }
}