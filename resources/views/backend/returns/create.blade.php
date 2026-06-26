{{-- backend/returns/create.blade.php --}}
@extends('backend.layouts.layout')
@section('title', 'New Return')
@section('content')
<script>
    window.RETURN_CONFIG = {
        searchSaleUrl: "{{ route('returns.search-sale') }}",
        csrfToken: "{{ csrf_token() }}",
    };
</script>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Process a Return</h4></div></div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">Search by Invoice Number</label>
                        <div class="input-group">
                            <input type="text" id="invoice-search" class="form-control" placeholder="e.g. INV-20260625-0001">
                            <button class="btn btn-primary" id="search-invoice-btn" type="button">Search</button>
                        </div>
                        <div class="text-danger mt-1" id="search-error"></div>
                    </div>
                </div>

                <div id="sale-details" style="display:none;">
                    <p>Customer: <strong id="sale-customer"></strong></p>
                    <form id="return-form" method="POST" action="{{ route('returns.store') }}">
                        @csrf
                        <input type="hidden" name="sale_id" id="sale_id">

                        <div class="table-responsive">
                            <table class="table" id="returnable-items-table">
                                <thead>
                                    <tr><th>Product</th><th>Sold</th><th>Already Returned</th><th>Returnable</th><th>Return Qty</th></tr>
                                </thead>
                                <tbody id="returnable-items-body"></tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-4">
                                <label class="form-label">Refund Method*</label>
                                <select name="refund_method" class="form-control" required>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="store_credit">Store Credit</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Restock Returned Items?</label>
                                <select name="restock" class="form-control">
                                    <option value="1">Yes — add back to stock</option>
                                    <option value="0">No — item damaged/unsellable</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Reason</label>
                                <input type="text" name="reason" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Process Return</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cfg = window.RETURN_CONFIG;

    document.getElementById('search-invoice-btn').addEventListener('click', function () {
        const invoice = document.getElementById('invoice-search').value.trim();
        document.getElementById('search-error').textContent = '';
        if (!invoice) return;

        fetch(`${cfg.searchSaleUrl}?invoice_no=${encodeURIComponent(invoice)}`)
            .then(r => r.json())
            .then(res => {
                if (!res.success) {
                    document.getElementById('search-error').textContent = res.message;
                    document.getElementById('sale-details').style.display = 'none';
                    return;
                }
                renderSale(res.data);
            });
    });

    function renderSale(data) {
        document.getElementById('sale_id').value = data.sale.id;
        document.getElementById('sale-customer').textContent = data.sale.customer ? data.sale.customer.name : 'Walk-in Customer';

        const body = document.getElementById('returnable-items-body');
        body.innerHTML = '';

        data.items.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.product_name} <br><small class="text-muted">${item.product_sku}</small>
                    <input type="hidden" name="items[${index}][sale_item_id]" value="${item.sale_item_id}"></td>
                <td>${item.sold_qty}</td>
                <td>${item.already_returned}</td>
                <td>${item.returnable_qty}</td>
                <td><input type="number" name="items[${index}][quantity]" class="form-control"
                    min="0" max="${item.returnable_qty}" value="0" ${item.returnable_qty === 0 ? 'disabled' : ''}></td>
            `;
            body.appendChild(tr);
        });

        document.getElementById('sale-details').style.display = 'block';
    }

    document.getElementById('return-form').addEventListener('submit', function (e) {
        const qtyInputs = this.querySelectorAll('input[name*="[quantity]"]');
        let hasAny = false;
        qtyInputs.forEach(input => { if (parseInt(input.value) > 0) hasAny = true; });
        if (!hasAny) {
            e.preventDefault();
            alert('Enter a return quantity for at least one item.');
        }
    });
});
</script>
@endsection