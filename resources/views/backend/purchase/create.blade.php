@extends('backend.layouts.layout')
@section('title', 'Add Purchase')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Purchase</h4>
            </div>
        </div>

        <form method="POST" action="{{ route('purchase.store') }}" id="purchase-form">
            @csrf
            <div class="row">

                <!-- Purchase Info -->
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="invoice_no">Invoice No*</label>
                                <input type="text" required name="invoice_no" id="invoice_no"
                                    class="form-control" value="{{ old('invoice_no') }}">
                                @error('invoice_no') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="supplier_id">Supplier*</label>
                                <select name="supplier_id" id="supplier_id" required class="form-control">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="purchase_date">Purchase Date*</label>
                                <input type="date" required name="purchase_date" id="purchase_date"
                                    class="form-control" value="{{ old('purchase_date', date('Y-m-d')) }}">
                                @error('purchase_date') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status / Payment -->
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="status">Purchase Status*</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="received" {{ old('status', 'received') == 'received' ? 'selected' : '' }}>Received</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <small class="text-muted">Stock only increases when marked "Received".</small>
                                @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="paid_amount">Paid Amount</label>
                                <input type="number" step="0.01" name="paid_amount" id="paid_amount"
                                    class="form-control" value="{{ old('paid_amount', 0) }}">
                                @error('paid_amount') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="payment_status">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-control">
                                    <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                <small class="text-muted">Leave default and it will be auto-calculated from paid amount.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">Purchase Items*</label>
                                <button type="button" id="add-item-row" class="btn btn-sm btn-primary">+ Add Item</button>
                            </div>

                            @error('items') <div class="text-danger mb-2">{{ $message }}</div> @enderror

                            <div class="table-responsive">
                                <table class="table" id="items-table">
                                    <thead>
                                        <tr>
                                            <th style="min-width:220px;">Product</th>
                                            <th style="width:100px;">Qty</th>
                                            <th style="width:140px;">Unit Cost</th>
                                            <th style="width:140px;">Discount</th>
                                            <th style="width:140px;">Line Total</th>
                                            <th style="width:60px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-body">
                                        <!-- rows injected by JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="col-lg-6 col-sm-12 offset-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label" for="discount">Overall Discount</label>
                                    <input type="number" step="0.01" name="discount" id="discount"
                                        class="form-control" value="{{ old('discount', 0) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="tax">Tax</label>
                                    <input type="number" step="0.01" name="tax" id="tax"
                                        class="form-control" value="{{ old('tax', 0) }}">
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
                            <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12">
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Save Purchase</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const products = @json($products);
    const itemsBody = document.getElementById('items-body');
    const addBtn = document.getElementById('add-item-row');
    let rowIndex = 0;

    function productOptions(selectedId = '') {
        let opts = '<option value="">Select Product</option>';
        products.forEach(p => {
            const sel = (String(p.id) === String(selectedId)) ? 'selected' : '';
            opts += `<option value="${p.id}" data-cost="${p.cost_price}" ${sel}>${p.name} (${p.sku})</option>`;
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
            <td><input type="number" min="1" name="items[${i}][quantity]" class="form-control qty-input" value="${data.quantity || 1}" required></td>
            <td><input type="number" step="0.01" min="0" name="items[${i}][unit_cost]" class="form-control cost-input" value="${data.unit_cost || 0}" required></td>
            <td><input type="number" step="0.01" min="0" name="items[${i}][discount]" class="form-control discount-input" value="${data.discount || 0}"></td>
            <td><span class="line-total">0.00</span></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row">&times;</button></td>
        `;
        itemsBody.appendChild(row);
        bindRow(row);
        recalcRow(row);
    }

    function bindRow(row) {
        const productSelect = row.querySelector('.product-select');
        const qtyInput = row.querySelector('.qty-input');
        const costInput = row.querySelector('.cost-input');
        const discountInput = row.querySelector('.discount-input');
        const removeBtn = row.querySelector('.remove-row');

        productSelect.addEventListener('change', function () {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const cost = selectedOption.getAttribute('data-cost');
            if (cost) costInput.value = cost;
            recalcRow(row);
        });

        [qtyInput, costInput, discountInput].forEach(input => {
            input.addEventListener('input', () => recalcRow(row));
        });

        removeBtn.addEventListener('click', function () {
            row.remove();
            recalcTotals();
        });
    }

    function recalcRow(row) {
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
        const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
        const lineTotal = (qty * cost) - discount;
        row.querySelector('.line-total').textContent = lineTotal.toFixed(2);
        recalcTotals();
    }

    function recalcTotals() {
        let subtotal = 0;
        document.querySelectorAll('.line-total').forEach(el => {
            subtotal += parseFloat(el.textContent) || 0;
        });

        const overallDiscount = parseFloat(document.getElementById('discount').value) || 0;
        const tax = parseFloat(document.getElementById('tax').value) || 0;
        const total = subtotal - overallDiscount + tax;

        document.getElementById('display-subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('display-total').textContent = total.toFixed(2);
    }

    document.getElementById('discount').addEventListener('input', recalcTotals);
    document.getElementById('tax').addEventListener('input', recalcTotals);

    addBtn.addEventListener('click', () => addRow());

    // Start with one empty row
    addRow();
});
</script>
@endsection