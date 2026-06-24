<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PosCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'        => 'nullable|exists:customers,id',
            'discount'           => 'nullable|numeric|min:0',
            'tax'                => 'nullable|numeric|min:0',
            'paid_amount'        => 'required|numeric|min:0',
            'payment_method'     => 'required|in:cash,card,bank_transfer',
            'payment_reference'  => 'nullable|string|max:255',
            'notes'              => 'nullable|string',

            'items'                 => 'required|array|min:1',
            'items.*.product_id'    => 'required|exists:products,id',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.discount'      => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Cart is empty.',
        ];
    }
}