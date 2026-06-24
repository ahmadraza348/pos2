<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HoldOrderRequest extends FormRequest
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
            'customer_id'       => 'nullable|exists:customers,id',
            'discount'          => 'nullable|numeric|min:0',
            'tax'               => 'nullable|numeric|min:0',
            'paid_amount'       => 'nullable|numeric|min:0',
            'payment_method'    => 'nullable|in:cash,card,bank_transfer',
            'notes'             => 'nullable|string',

            'items'                 => 'required|array|min:1',
            'items.*.product_id'    => 'required|exists:products,id',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.discount'      => 'nullable|numeric|min:0',
        ];
    }
}
