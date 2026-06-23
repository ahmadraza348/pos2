<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'phone' => 'nullable|string|max:20|unique:customers,phone,' . $this->customer?->id,
            'email' => 'nullable|email|max:255|unique:customers,email,' . $this->customer?->id,
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'opening_balance' => 'nullable|numeric|min:0',
            'balance_type' => 'nullable|in:receivable,payable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'notes' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }
}
