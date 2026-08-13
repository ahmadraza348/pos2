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

        // Items can only be edited while a purchase is still "pending".
        // Once it's "received" its items have already moved real stock and
        // been blended into the product's cost, so they're locked (view
        // only) — the sole remaining action is cancelling it. "cancelled"
        // is locked too, being fully closed.
        $itemsLocked = $existing ? $existing->items_locked : false;

        return [
            'invoice_no'     => 'required|string|max:255|unique:purchases,invoice_no,' . $purchaseId,
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_date'  => 'required|date',

            // Invoice-level only — this affects what you owe the supplier,
            // not the per-unit cost recorded against each product.
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
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'                   => 'Add at least one product to the purchase.',
            'items.*.product_id.required_with' => 'Select a product for every item row.',
            'items.*.product_id.distinct'      => 'Each product can only appear once per purchase — adjust the quantity instead of adding it twice.',
            'status.in'                        => 'That status change isn\'t allowed.',
        ];
    }

    /**
     * - pending           → pending, received, or cancelled
     * - received          → received or cancelled (can't "un-receive" back to pending)
     * - cancelled         → cancelled only (fully closed)
     * - new (create form) → any of the three
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