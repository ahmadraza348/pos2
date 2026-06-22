<?php

namespace App\Http\Requests\Admin;

use App\Models\Purchase;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $purchase = $this->route('purchase');
        $id = ($purchase instanceof Purchase) ? $purchase->id : $purchase;

        return [
            'invoice_no'     => 'required|string|max:255|unique:purchases,invoice_no,' . $id,
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_date'  => 'required|date',

            'discount'       => 'nullable|numeric|min:0',
            'tax'            => 'nullable|numeric|min:0',
            'paid_amount'    => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:unpaid,partial,paid',
            'status'         => 'nullable|in:pending,received,cancelled',
            'notes'          => 'nullable|string',

            'items'                  => 'required|array|min:1',
            'items.*.product_id'     => 'required|exists:products,id',
            'items.*.quantity'       => 'required|integer|min:1',
            'items.*.unit_cost'      => 'required|numeric|min:0',
            'items.*.discount'       => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'        => 'Add at least one product to the purchase.',
            'items.*.product_id.required' => 'Select a product for every item row.',
        ];
    }
}