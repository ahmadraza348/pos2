<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReturnRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'sale_id'                => 'required|exists:sales,id',
            'refund_method'          => 'required|in:cash,card,bank_transfer,store_credit',
            'restock'                => 'nullable|boolean',
            'reason'                 => 'nullable|string',
            'items'                  => 'required|array|min:1',
            'items.*.sale_item_id'   => 'required|exists:sale_items,id',
            'items.*.quantity'       => 'nullable|integer|min:0',
        ];
    }

    // At least one line must have a quantity > 0 — individual rows can be
    // submitted with 0 without failing the whole form.
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            $hasPositive = collect($items)->contains(fn ($i) => (int) ($i['quantity'] ?? 0) > 0);
            if (!$hasPositive) {
                $validator->errors()->add('items', 'Enter a return quantity for at least one item.');
            }
        });
    }
}