@extends('backend.layouts.layout')
@section('title', 'Edit Purchase')
@section('content')

@php
    $itemsLocked = $purchase->items_locked; // true only once cancelled

    $statusLabels = [
        'pending'   => 'Pending',
        'received'  => 'Received',
        'cancelled' => 'Cancelled',
    ];

    $allowedStatuses = match ($purchase->status) {
        'received'  => ['received', 'cancelled'],
        'cancelled' => ['cancelled'],
        default     => ['pending', 'received', 'cancelled'],
    };
@endphp

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Purchase — {{ $purchase->invoice_no }}</h4>
            </div>
        </div>

        <form method="POST" action="{{ route('purchase.update', $purchase->id) }}" id="purchase-form">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="invoice_no">Invoice No*</label>
                                <input type="text" required name="invoice_no" id="invoice_no"
                                    class="form-control" value="{{ old('invoice_no', $purchase->invoice_no) }}">
                                @error('invoice_no') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="supplier_id">Supplier*</label>
                                <select name="supplier_id" id="supplier_id" required class="form-control">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="purchase_date">Purchase Date*</label>
                                <input type="date" required name="purchase_date" id="purchase_date"
                                    class="form-control"
                                    value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}">
                                @error('purchase_date') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="status">Purchase Status*</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach ($allowedStatuses as $value)
                                        <option value="{{ $value }}" {{ old('status', $purchase->status) == $value ? 'selected' : '' }}>
                                            {{ $statusLabels[$value] }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($purchase->status === 'pending')
                                    <small class="text-muted">Marking "Received" adds this stock to your products.</small>
                                @elseif ($purchase->status === 'received')
                                    <small class="text-muted">Stock is already in — editing items here will adjust it accordingly. Setting to "Cancelled" reverses it.</small>
                                @else
                                    <small class="text-muted">This purchase is cancelled and can no longer be changed.</small>
                                @endif
                                @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="paid_amount">Paid Amount</label>
                                <input type="number" step="0.01" name="paid_amount" id="paid_amount"
                                    class="form-control" value="{{ old('paid_amount', $purchase->paid_amount) }}">
                                @error('paid_amount') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="payment_status">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-control">
                                    <option value="unpaid" {{ old('payment_status', $purchase->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="partial" {{ old('payment_status', $purchase->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ old('payment_status', $purchase->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">Purchase Items*</label>
                                @if (! $itemsLocked)
                                    <button type="button" id="add-item-row" class="btn btn-sm btn-primary">+ Add Item</button>
                                @endif
                            </div>

                            @if ($itemsLocked)
                                <div class="alert alert-light border small mb-3">
                                    This purchase is cancelled, so its items can no longer be changed.
                                </div>
                            @elseif ($purchase->status === 'received')
                                <div class="alert alert-light border small mb-3">
                                    This stock has already been added to your products. You can still correct
                                    quantities or prices — if a product's stock has since dropped below what this
                                    purchase originally added (because some was sold), saving will be blocked with
                                    an explanation instead of silently getting the numbers wrong.
                                </div>
                            @endif

                            @error('items') <div class="alert alert-danger small mb-2">{{ $message }}</div> @enderror
                            <div id="duplicate-warning" class="text-danger mb-2 small" style="display:none;">
                                A product is selected more than once — please combine it into a single row instead.
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="items-table">
                                    <thead>
                                        <tr>
                                            <th style="min-width:220px;">Product</th>
                                            @if (! $itemsLocked)
                                                <th style="width:100px;">Current Stock</th>
                                            @endif
                                            <th style="width:100px;">Qty</th>
                                            <th style="width:140px;">Unit Cost</th>
                                            <th style="width:140px;">Line Total</th>
                                            @if (! $itemsLocked)
                                                <th style="width:60px;"></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="items-body">
                                        @if ($itemsLocked)
                                            @foreach ($purchase->items as $item)
                                                <tr>
                                                    <td>{{ $item->product->name ?? 'Deleted product' }} ({{ $item->product->sku ?? '—' }})</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->unit_cost, 2) }}</td>
                                                    <td>{{ number_format($item->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12 offset-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label" for="discount">Overall Discount</label>
                                    <input type="number" step="0.01" name="discount" id="discount"
                                        class="form-control" value="{{ old('discount', $purchase->discount) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="tax">Tax</label>
                                    <input type="number" step="0.01" name="tax" id="tax"
                                        class="form-control" value="{{ old('tax', $purchase->tax) }}">
                                </div>
                            </div>

                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end"><span id="display-subtotal">0.00</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td class="text-end"><strong id="display-total">0.00</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $purchase->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12">
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary" id="submit-btn">Update Purchase</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@php
    $existingItemsData = $purchase->items->map(function ($item) {
        return [
            'product_id' => $item->product_id,
            'quantity'   => $item->quantity,
            'unit_cost'  => $item->unit_cost,
        ];
    })->values();
@endphp

<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemsLocked = @json($itemsLocked);
    const lockedSubtotal = @json((float) $purchase->subtotal);

    const discountInputEl = document.getElementById('discount');
    const taxInputEl = document.getElementById('tax');

    if (itemsLocked) {
        function recalcLockedTotals() {
            const overallDiscount = parseFloat(discountInputEl.value) || 0;
            const tax = parseFloat(taxInputEl.value) || 0;
            const total = lockedSubtotal - overallDiscount + tax;

            document.getElementById('display-subtotal').textContent = lockedSubtotal.toFixed(2);
            document.getElementById('display-total').textContent = total.toFixed(2);
        }

        discountInputEl.addEventListener('input', recalcLockedTotals);
        taxInputEl.addEventListener('input', recalcLockedTotals);
        recalcLockedTotals();
        return;
    }

    // ===== Editable mode (pending or received) =====
    const products = @json($products);
    const existingItems = @json($existingItemsData);

    const itemsBody = document.getElementById('items-body');
    const addBtn = document.getElementById('add-item-row');
    const duplicateWarning = document.getElementById('duplicate-warning');
    const submitBtn = document.getElementById('submit-btn');
    let rowIndex = 0;

    function productOptions(selectedId = '') {
        let opts = '<option value="">Select Product</option>';
        products.forEach(p => {
            const sel = (String(p.id) === String(selectedId)) ? 'selected' : '';
            opts += `<option value="${p.id}" data-cost="${p.cost_price}" data-stock="${p.stock}" ${sel}>${p.name} (${p.sku})</option>`;
        });
        return opts;
    }

    function addRow(data = {}) {
        const i = rowIndex++;
        const row = document.createElement('tr');
        row.dataset.index = i;
        row.innerHTML = `
            <td>
                <select name="items[${i}][product_id]" class="form-control product-select" required>
                    ${productOptions(data.product_id || '')}
                </select>
            </td>
            <td class="text-muted stock-display">—</td>
            <td><input type="number" min="1" name="items[${i}][quantity]" class="form-control qty-input" value="${data.quantity || 1}" required></td>
            <td><input type="number" step="0.01" min="0" name="items[${i}][unit_cost]" class="form-control cost-input" value="${data.unit_cost || 0}" required></td>
            <td><span class="line-total">0.00</span></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row">&times;</button></td>
        `;
        itemsBody.appendChild(row);
        bindRow(row);
        recalcRow(row);

        // Show current stock immediately for pre-filled rows too.
        const opt = row.querySelector('.product-select').selectedOptions[0];
        if (opt && opt.value) {
            row.querySelector('.stock-display').textContent = opt.getAttribute('data-stock') ?? '—';
        }
    }

    function bindRow(row) {
        const productSelect = row.querySelector('.product-select');
        const qtyInput = row.querySelector('.qty-input');
        const costInput = row.querySelector('.cost-input');
        const stockDisplay = row.querySelector('.stock-display');
        const removeBtn = row.querySelector('.remove-row');

        productSelect.addEventListener('change', function () {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const cost = selectedOption.getAttribute('data-cost');
            const stock = selectedOption.getAttribute('data-stock');
            if (cost) costInput.value = cost;
            stockDisplay.textContent = stock ?? '—';
            recalcRow(row);
            checkDuplicateProducts();
        });

        [qtyInput, costInput].forEach(input => {
            input.addEventListener('input', () => recalcRow(row));
        });

        removeBtn.addEventListener('click', function () {
            row.remove();
            recalcTotals();
            checkDuplicateProducts();
        });
    }

    function recalcRow(row) {
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
        const lineTotal = qty * cost;
        row.querySelector('.line-total').textContent = lineTotal.toFixed(2);
        recalcTotals();
    }

    function recalcTotals() {
        let subtotal = 0;
        document.querySelectorAll('.line-total').forEach(el => {
            subtotal += parseFloat(el.textContent) || 0;
        });

        const overallDiscount = parseFloat(discountInputEl.value) || 0;
        const tax = parseFloat(taxInputEl.value) || 0;
        const total = subtotal - overallDiscount + tax;

        document.getElementById('display-subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('display-total').textContent = total.toFixed(2);
    }

    function checkDuplicateProducts() {
        const selected = Array.from(document.querySelectorAll('.product-select'))
            .map(s => s.value)
            .filter(v => v !== '');
        const hasDuplicates = new Set(selected).size !== selected.length;

        duplicateWarning.style.display = hasDuplicates ? 'block' : 'none';
        submitBtn.disabled = hasDuplicates;
    }

    discountInputEl.addEventListener('input', recalcTotals);
    taxInputEl.addEventListener('input', recalcTotals);

    addBtn.addEventListener('click', () => addRow());

    if (existingItems.length > 0) {
        existingItems.forEach(item => addRow(item));
    } else {
        addRow();
    }
});
</script>
@endsection