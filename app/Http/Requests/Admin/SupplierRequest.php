<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
        return [
           'name' => 'required|string|max:255',
        'email' => 'required|email|unique:suppliers,email,' . $this->supplier?->id,
        'phone' => 'required|string|max:20',
        'company_name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'status' => 'required|boolean',
        'opening_balance' => 'required|numeric|min:0',
        ];
    }
}
