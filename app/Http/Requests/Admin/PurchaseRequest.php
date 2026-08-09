<?php

namespace App\Http\Requests\Admin;

use App\Models\Purchase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $routeParam = $this->route('purchase');
        $purchaseId = $routeParam instanceof Purchase ? $routeParam->id : $routeParam;

        // The purchase as it currently exists in the DB (null on create).
        $existing = $purchaseId ? Purchase::find($purchaseId) : null;

        // Items can only be added/changed while the purchase is still
        // pending — once received (stock moved) or cancelled, they're locked.
        $itemsLocked = $existing ? $existing->items_locked : false;

        return [
            'invoice_no'     => 'required|string|max:255|unique:purchases,invoice_no,' . $purchaseId,
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_date'  => 'required|date',

            'discount'       => 'nullable|numeric|min:0',
            'tax'            => 'nullable|numeric|min:0',
            'paid_amount'    => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:unpaid,partial,paid',
            'status'         => ['nullable', Rule::in($this->allowedStatuses($existing))],
            'notes'          => 'nullable|string',

            'items'              => $itemsLocked ? 'nullable|array' : 'required|array|min:1',
            'items.*.product_id' => 'required_with:items|distinct|exists:products,id',
            'items.*.quantity'   => 'required_with:items|integer|min:1',
            'items.*.unit_cost'  => 'required_with:items|numeric|min:0',
            'items.*.discount'   => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'               => 'Add at least one product to the purchase.',
            'items.*.product_id.required_with' => 'Select a product for every item row.',
            'items.*.product_id.distinct'  => 'Each product can only appear once per purchase — adjust the quantity instead of adding it twice.',
            'status.in'                    => 'That status change isn\'t allowed. A received purchase can only be cancelled, not reopened.',
        ];
    }

    /**
     * Which status values are valid to submit, given the purchase's
     * current state:
     * - pending   → can go to pending, received, or cancelled
     * - received  → can only stay received or move to cancelled
     * - cancelled → locked, stays cancelled
     * - new (create) → any of the three
     */
    protected function allowedStatuses(?Purchase $existing): array
    {
        return match ($existing?->status) {
            'received'  => ['received', 'cancelled'],
            'cancelled' => ['cancelled'],
            default     => ['pending', 'received', 'cancelled'],
        };
    }
}