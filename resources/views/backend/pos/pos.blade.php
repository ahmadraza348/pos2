@extends('backend.layouts.layout')
@section('title', 'Point of Sale')
@section('content')

{{-- ============================================================
     CONFIG BLOCK — the ONLY place Blade syntax touches JS.
     Everything below this is pure vanilla JS. This is the fix for
     the syntax errors that were breaking checkout before.
============================================================ --}}
<script>
    window.POS_CONFIG = {
        routes: {
            searchProducts:   "{{ route('pos.search-products') }}",
            searchBarcode:    "{{ route('pos.search-barcode') }}",
            searchCustomers:  "{{ route('pos.search-customers') }}",
            storeCustomer:    "{{ route('pos.store-customer') }}",
            calculateTotals:  "{{ route('pos.calculate-totals') }}",
            checkout:         "{{ route('pos.checkout') }}",
            hold:             "{{ route('pos.hold') }}",
            heldOrders:       "{{ route('pos.held-orders') }}",
            resumeHeldOrder:  "{{ url('admin/pos/held-orders') }}", // + /{id}/resume
            deleteHeldOrder:  "{{ url('admin/pos/held-orders') }}", // + /{id}
            recentSales:      "{{ route('pos.recent-sales') }}",
        },
        csrfToken: "{{ csrf_token() }}",
        defaultImage: "{{ asset('backend/assets/img/noimage.png') }}",
    };
</script>

<style>
    #pos-loader {
        position: fixed; inset: 0; background: rgba(255,255,255,0.55);
        display: none; align-items: center; justify-content: center; z-index: 2000;
    }
    #pos-loader .spinner-border { width: 3rem; height: 3rem; }
    .productset.out-of-stock { opacity: 0.45; pointer-events: none; position: relative; }
    .productset.out-of-stock::after {
        content: 'Out of stock'; position: absolute; top: 8px; right: 8px;
        background: #dc3545; color: #fff; font-size: 11px; padding: 2px 6px; border-radius: 4px;
    }
    .paymentmethod.active { border: 2px solid #fd7e14; border-radius: 6px; }
    #change-due.text-success { color: #198754 !important; font-weight: 600; }
    #change-due.text-danger { color: #dc3545 !important; font-weight: 600; }
</style>

<div id="pos-loader">
    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
</div>

<div class="main-wrappers">
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-8 col-sm-12 tabs_wrapper">

                 <div class="tabs_container">
                        <div class="row mb-3">
                            <div class="col-lg-7 col-sm-12 mb-2">
                                <input type="text" id="product-search" class="form-control"
                                    placeholder="Search product by name or SKU...">
                            </div>
                            <div class="col-lg-5 col-sm-12">
                                <div class="input-group">
                                    <input type="text" id="barcode-input" class="form-control"
                                        placeholder="Scan or type barcode" autocomplete="off">
                                    <button class="btn btn-outline-secondary btn-scanner" type="button" id="barcode-submit-btn">
                                        <img src="{{ asset('backend/assets/img/icons/scanner1.svg') }}" alt="scan" width="18">
                                    </button>
                                </div>
                            </div>
                        </div>

                       
                    </div>

                    <ul class="tabs owl-carousel owl-theme owl-product border-0" id="category-tabs">
                        <li class="active" data-category-id="">
                            <div class="product-details">
                                <img src="{{ asset('backend/assets/img/noimage.png') }}" alt="All" />
                                <h6>All</h6>
                            </div>
                        </li>
                        @foreach ($categories as $category)
                            <li data-category-id="{{ $category->id }}">
                                <div class="product-details">
                                    <img src="{{ $category->image ? asset('storage/'.$category->image) : asset('backend/assets/img/noimage.png') }}"
                                         alt="{{ $category->name }}" />
                                    <h6>{{ $category->name }}</h6>
                                </div>
                            </li>
                        @endforeach

                        
                    </ul>
 <div class="tab_content active">
                            <div class="row" id="product-grid"></div>
                        </div>
                   
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div class="order-list">
                        <div class="orderid">
                            <h4>Order List</h4>
                            <h5>Reference: <span id="temp-txn-id">#{{ rand(10000, 99999) }}</span></h5>
                        </div>
                        <div class="actionproducts">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" id="clear-cart-btn" class="deletebg confirm-text">
                                        <img src="{{ asset('backend/assets/img/icons/delete-2.svg') }}" alt="img" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card card-order">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a href="javascript:void(0);" class="btn btn-adds" data-bs-toggle="modal"
                                        data-bs-target="#create"><i class="fa fa-plus me-2"></i>Add Customer</a>
                                </div>
                                <div class="col-lg-12">
                                    <div class="select-split">
                                        <div class="select-group w-100">
                                            <select class="select" id="customer-select">
                                                <option value="">Walk-in Customer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="select-split">
                                        <div class="select-group w-100">
                                            <input type="text" id="customer-search-input" class="form-control"
                                                placeholder="Search customer by name or phone...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="split-card"></div>
                        <div class="card-body pt-0">
                            <div class="totalitem">
                                <h4 id="total-items-label">Total items : 0</h4>
                                <a href="javascript:void(0);" id="clear-all-link">Clear all</a>
                            </div>
                            <div class="product-table">
                                <ul class="product-lists d-block" id="cart-list"></ul>
                                <p id="empty-cart-msg" class="text-center text-muted py-3">Cart is empty</p>
                            </div>
                        </div>
                        <div class="split-card"></div>
                        <div class="card-body pt-0 pb-2">
                            <div class="setvalue" id="totals-area">
                                <ul>
                                    <li><h5>Subtotal</h5><h6 id="display-subtotal">Rs. 0.00</h6></li>
                                    <li><h5>Discount</h5><h6 id="display-discount">Rs. 0.00</h6></li>
                                    <li><h5>Tax</h5><h6 id="display-tax">Rs. 0.00</h6></li>
                                    <li class="total-value"><h5>Total</h5><h6 id="display-total">Rs. 0.00</h6></li>
                                </ul>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label">Discount (Rs.)</label>
                                    <input type="number" id="overall-discount" class="form-control" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Tax (Rs.)</label>
                                    <input type="number" id="overall-tax" class="form-control" value="0" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="setvaluecash">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="paymentmethod active" data-method="cash">
                                            <img src="{{ asset('backend/assets/img/icons/cash.svg') }}" alt="img" class="me-2" />Cash</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="paymentmethod" data-method="card">
                                            <img src="{{ asset('backend/assets/img/icons/debitcard.svg') }}" alt="img" class="me-2" />Card</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="paymentmethod" data-method="bank_transfer">
                                            <img src="{{ asset('backend/assets/img/icons/scan.svg') }}" alt="img" class="me-2" />Bank</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="row mb-2" id="payment-reference-row" style="display:none;">
                                <div class="col-12">
                                    <label class="form-label">Transaction Reference</label>
                                    <input type="text" id="payment-reference" class="form-control" placeholder="Optional reference no.">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="form-label">Paid Amount (Rs.)</label>
                                    <input type="number" id="paid-amount" class="form-control" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Balance</label>
                                    <input type="text" id="change-due" class="form-control" value="Rs. 0.00" readonly>
                                </div>
                            </div>

                            <div class="btn-totallabel" id="checkout-btn" style="cursor:pointer;">
                                <h5>Checkout</h5>
                                <h6 id="checkout-total" data-raw="0">Rs. 0.00</h6>
                            </div>

                            <div class="btn-pos">
                                <ul>
                                    <li><a href="javascript:void(0);" id="hold-order-btn" class="btn">
                                        <img src="{{ asset('backend/assets/img/icons/pause1.svg') }}" alt="img" class="me-1" />Hold</a></li>
                                    <li><a href="javascript:void(0);" id="quotation-btn" class="btn">
                                        <img src="{{ asset('backend/assets/img/icons/edit-6.svg') }}" alt="img" class="me-1" />Quotation</a></li>
                                    <li><a href="javascript:void(0);" id="void-order-btn" class="btn">
                                        <img src="{{ asset('backend/assets/img/icons/trash12.svg') }}" alt="img" class="me-1" />Void</a></li>
                                    <li><a href="javascript:void(0);" id="payment-focus-btn" class="btn">
                                        <img src="{{ asset('backend/assets/img/icons/wallet1.svg') }}" alt="img" class="me-1" />Payment</a></li>
                                    <li><a href="javascript:void(0);" class="btn" data-bs-toggle="modal" data-bs-target="#recents">
                                        <img src="{{ asset('backend/assets/img/icons/transcation.svg') }}" alt="img" class="me-1" />Transaction</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== MODALS ===================== --}}

<div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Customer</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="quick-customer-form">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label>Customer Name*</label>
                                <input type="text" id="qc-name" class="form-control" required></div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label>Email</label>
                                <input type="text" id="qc-email" class="form-control"></div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label>Phone</label>
                                <input type="text" id="qc-phone" class="form-control"></div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label>City</label>
                                <input type="text" id="qc-city" class="form-control"></div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group"><label>Address</label>
                                <input type="text" id="qc-address" class="form-control"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <button type="submit" class="btn btn-submit me-2">Save Customer</button>
                        <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Void Order</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="delete-order">
                    <img src="{{ asset('backend/assets/img/icons/close-circle1.svg') }}" alt="img" />
                </div>
                <div class="para-set text-center"><p>The current cart will be cleared. This cannot be undone.</p></div>
                <div class="col-lg-12 text-center">
                    <a class="btn btn-danger me-2" id="confirm-clear-cart">Yes, clear cart</a>
                    <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="recents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transactions</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#salespane" type="button">Sales History</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#heldpane" type="button">Held Orders</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#paymentpane" type="button">Payment</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#returnpane" type="button">Return</button></li>
                </ul>
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="salespane">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead><tr><th>Date</th><th>Invoice</th><th>Customer</th><th>Total</th></tr></thead>
                                <tbody id="recent-sales-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="heldpane">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead><tr><th>Date</th><th>Invoice</th><th>Customer</th><th>Total</th><th class="text-end">Action</th></tr></thead>
                                <tbody id="held-orders-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="paymentpane">
                        <p class="text-muted text-center py-4">Recording payments toward customer dues is planned for a future update — keeping this release focused on accurate sales and inventory.</p>
                    </div>
                    <div class="tab-pane fade" id="returnpane">
                        <p class="text-muted text-center py-4">Returns/refunds workflow is planned for a future update — keeping this release focused on accurate sales and inventory.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== SCRIPT (pure JS — no Blade syntax below) ===================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const cfg = window.POS_CONFIG;
    let cart = [];
    let selectedCustomerId = '';
    let selectedPaymentMethod = 'cash';
    let activeCategoryId = '';

    const productGrid = document.getElementById('product-grid');
    const cartList = document.getElementById('cart-list');
    const emptyCartMsg = document.getElementById('empty-cart-msg');
    const totalItemsLabel = document.getElementById('total-items-label');
    const checkoutBtn = document.getElementById('checkout-btn');

    function showLoader() { document.getElementById('pos-loader').style.display = 'flex'; }
    function hideLoader() { document.getElementById('pos-loader').style.display = 'none'; }

    function notify(message, type) {
        if (typeof toastr !== 'undefined') {
            type === 'error' ? toastr.error(message) : toastr.success(message);
        } else {
            alert(message);
        }
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str == null ? '' : str;
        return div.innerHTML;
    }

    function formatCurrency(amount) {
        const num = parseFloat(amount) || 0;
        return 'Rs. ' + num.toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function apiFetch(url, options = {}) {
        // showLoader();
        return fetch(url, options)
            .then(async (res) => {
                const data = await res.json().catch(() => ({ success: false, message: 'Invalid server response' }));
                return data;
            })
            // .finally(hideLoader);
    }

    /* =========================================================
       PRODUCTS
    ==========================================================*/
    function loadProducts(term = '') {
        const params = new URLSearchParams();
        if (term) params.append('term', term);
        if (activeCategoryId) params.append('category_id', activeCategoryId);

        apiFetch(`${cfg.routes.searchProducts}?${params.toString()}`).then(res => {
            if (!res.success) { notify(res.message || 'Could not load products', 'error'); return; }
            renderProductGrid(res.data);
        });
    }

    function renderProductGrid(products) {
        productGrid.innerHTML = '';

        if (!products || products.length === 0) {
            productGrid.innerHTML = '<div class="col-12 text-center text-muted py-4">No products found</div>';
            return;
        }

        products.forEach(p => {
            const outOfStock = parseInt(p.stock) <= 0;
            const col = document.createElement('div');
            col.className = 'col-lg-3 col-sm-6 d-flex';
            col.innerHTML = `
                <div class="productset flex-fill ${outOfStock ? 'out-of-stock' : ''}"
                     data-id="${p.id}" data-name="${escapeHtml(p.name)}" data-sku="${escapeHtml(p.sku)}"
                     data-price="${p.selling_price}" data-stock="${p.stock}"
                     style="${outOfStock ? '' : 'cursor:pointer;'}">
                    <div class="productsetimg">
                        <img src="${p.image_url}" alt="${escapeHtml(p.name)}" onerror="this.src='${cfg.defaultImage}'">
                        <h6>${outOfStock ? 'Out of stock' : 'Qty: ' + parseInt(p.stock)}</h6>
                        <div class="check-product"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="productsetcontent">
                        <h5>${escapeHtml(p.sku)}</h5>
                        <h4>${escapeHtml(p.name)}</h4>
                        <h6>${formatCurrency(p.selling_price)}</h6>
                    </div>
                </div>`;
            productGrid.appendChild(col);
        });

        document.querySelectorAll('.productset').forEach(el => {
            el.addEventListener('click', function () {
                if (this.classList.contains('out-of-stock')) return;
                addToCart({
                    product_id: parseInt(this.dataset.id),
                    name: this.dataset.name,
                    sku: this.dataset.sku,
                    price: parseFloat(this.dataset.price),
                    stock: parseFloat(this.dataset.stock),
                });
            });
        });
    }

    document.querySelectorAll('#category-tabs li').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('#category-tabs li').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeCategoryId = this.dataset.categoryId || '';
            loadProducts(document.getElementById('product-search').value);
        });
    });

    let searchDebounce;
    document.getElementById('product-search').addEventListener('input', function () {
        clearTimeout(searchDebounce);
        const term = this.value;
        searchDebounce = setTimeout(() => loadProducts(term), 350);
    });

    /* =========================================================
       BARCODE — dedicated always-visible input, works with USB scanners
       (which type digits then send Enter automatically)
    ==========================================================*/
    function handleBarcodeSubmit() {
        const input = document.getElementById('barcode-input');
        const barcode = input.value.trim();
        if (!barcode) return;

        apiFetch(`${cfg.routes.searchBarcode}?barcode=${encodeURIComponent(barcode)}`).then(res => {
            input.value = '';
            input.focus();

            if (!res.success) { notify(res.message || 'Product not found', 'error'); return; }

            const p = res.data;
            if (parseInt(p.stock) <= 0) { notify(`${p.name} is out of stock`, 'error'); return; }

            addToCart({
                product_id: p.id,
                name: p.name,
                sku: p.sku,
                price: parseFloat(p.selling_price),
                stock: parseFloat(p.stock),
            });
        });
    }

    document.getElementById('barcode-input').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); handleBarcodeSubmit(); }
    });
    document.getElementById('barcode-submit-btn').addEventListener('click', handleBarcodeSubmit);

    /* =========================================================
       CART
    ==========================================================*/
    function addToCart(product) {
        const existing = cart.find(c => c.product_id === product.product_id);
        if (existing) {
            if (existing.qty + 1 > product.stock) {
                notify(`Only ${product.stock} in stock for ${product.name}`, 'error');
                return;
            }
            existing.qty += 1;
        } else {
            cart.push({ ...product, qty: 1, discount: 0 });
        }
        renderCart();
    }

    function renderCart() {
        cartList.innerHTML = '';
        emptyCartMsg.style.display = cart.length === 0 ? 'block' : 'none';

        cart.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div class="productimg">
                    <div class="productcontet ">
                    <div class="productlinkset d-flex ">
                         <h4>${escapeHtml(item.name)}</h4>
                        </div>
                        <div class="increment-decrement">
                            <div class="input-groups">
                                <input type="button" value="-" class="button-minus dec button" data-index="${index}">
                                <input type="text" value="${item.qty}" class="quantity-field" readonly>
                                <input type="button" value="+" class="button-plus inc button" data-index="${index}">
                            </div>
                        </div>
                    </div>
                </div>
               <div class="d-flex justify-content-between align-center">
                <li>${formatCurrency(item.price * item.qty - item.discount)}</li>
                <li>
                    <a class="confirm-text remove-item" href="javascript:void(0);" data-index="${index}">
                        <img src="{{ asset('backend/assets/img/icons/delete-2.svg') }}" alt="img" />
                    </a>
                </li>
               </div>
               <hr>

            `;
            cartList.appendChild(li);
        });

        totalItemsLabel.textContent = `Total items : ${cart.reduce((s, i) => s + i.qty, 0)}`;

        document.querySelectorAll('.button-plus').forEach(btn =>
            btn.addEventListener('click', () => changeQty(parseInt(btn.dataset.index), 1)));
        document.querySelectorAll('.button-minus').forEach(btn =>
            btn.addEventListener('click', () => changeQty(parseInt(btn.dataset.index), -1)));
        document.querySelectorAll('.remove-item').forEach(btn =>
            btn.addEventListener('click', () => { cart.splice(parseInt(btn.dataset.index), 1); renderCart(); }));

        refreshTotals();
    }

    function changeQty(index, delta) {
        const item = cart[index];
        const newQty = item.qty + delta;
        if (newQty < 1) return;
        if (newQty > item.stock) { notify(`Only ${item.stock} in stock for ${item.name}`, 'error'); return; }
        item.qty = newQty;
        renderCart();
    }

    function clearCart() { cart = []; renderCart(); }

    document.getElementById('clear-all-link').addEventListener('click', clearCart);
    document.getElementById('void-order-btn').addEventListener('click', function () {
        if (cart.length === 0) { notify('Cart is already empty', 'error'); return; }
        new bootstrap.Modal(document.getElementById('delete')).show();
    });
    document.getElementById('clear-cart-btn').addEventListener('click', function (e) {
        e.preventDefault();
        if (cart.length === 0) return;
        new bootstrap.Modal(document.getElementById('delete')).show();
    });
    document.getElementById('confirm-clear-cart').addEventListener('click', function () {
        clearCart();
        bootstrap.Modal.getInstance(document.getElementById('delete')).hide();
    });

    document.getElementById('quotation-btn').addEventListener('click', function () {
        notify('Quotations are coming in a future update.', 'error');
    });
    document.getElementById('payment-focus-btn').addEventListener('click', function () {
        document.getElementById('paid-amount').focus();
        document.getElementById('paid-amount').scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    /* =========================================================
       TOTALS — server-verified, no client-side trust for the final figure
    ==========================================================*/
    function refreshTotals() {
        const overallDiscount = parseFloat(document.getElementById('overall-discount').value) || 0;
        const tax = parseFloat(document.getElementById('overall-tax').value) || 0;

        if (cart.length === 0) {
            updateTotalsDisplay(0, overallDiscount, tax, 0);
            return;
        }

        apiFetch(cfg.routes.calculateTotals, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': cfg.csrfToken },
            body: JSON.stringify({
                items: cart.map(c => ({ product_id: c.product_id, quantity: c.qty, discount: c.discount })),
                discount: overallDiscount,
                tax: tax,
            }),
        }).then(res => {
            if (!res.success) { notify(res.message, 'error'); return; }
            updateTotalsDisplay(res.subtotal, overallDiscount, tax, res.grand_total);
        });
    }

    function updateTotalsDisplay(subtotal, discount, tax, grandTotal) {
        document.getElementById('display-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('display-discount').textContent = formatCurrency(discount);
        document.getElementById('display-tax').textContent = formatCurrency(tax);
        document.getElementById('display-total').textContent = formatCurrency(grandTotal);

        const checkoutTotalEl = document.getElementById('checkout-total');
        checkoutTotalEl.textContent = formatCurrency(grandTotal);
        checkoutTotalEl.dataset.raw = grandTotal;

        document.getElementById('paid-amount').value = grandTotal.toFixed(2);
        updateBalanceDisplay();
    }

    function updateBalanceDisplay() {
        const total = parseFloat(document.getElementById('checkout-total').dataset.raw) || 0;
        const paid = parseFloat(document.getElementById('paid-amount').value) || 0;
        const diff = paid - total;
        const el = document.getElementById('change-due');

        if (diff >= 0) {
            el.value = 'Change: ' + formatCurrency(diff);
            el.classList.remove('text-danger'); el.classList.add('text-success');
        } else {
            el.value = 'Due: ' + formatCurrency(Math.abs(diff));
            el.classList.remove('text-success'); el.classList.add('text-danger');
        }
    }

    document.getElementById('overall-discount').addEventListener('input', refreshTotals);
    document.getElementById('overall-tax').addEventListener('input', refreshTotals);
    document.getElementById('paid-amount').addEventListener('input', updateBalanceDisplay);

    /* =========================================================
       CUSTOMER
    ==========================================================*/
    let customerDebounce;
    document.getElementById('customer-search-input').addEventListener('input', function () {
        clearTimeout(customerDebounce);
        const term = this.value;
        customerDebounce = setTimeout(() => {
            if (!term) return;
            apiFetch(`${cfg.routes.searchCustomers}?term=${encodeURIComponent(term)}`).then(res => {
                if (!res.success) return;
                const select = document.getElementById('customer-select');
                select.innerHTML = '<option value="">Walk-in Customer</option>';
                res.data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = `${c.name} (${c.phone || 'N/A'})`;
                    select.appendChild(opt);
                });
            });
        }, 350);
    });

    document.getElementById('customer-select').addEventListener('change', function () {
        selectedCustomerId = this.value;
    });

    document.getElementById('quick-customer-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const name = document.getElementById('qc-name').value.trim();
        if (!name) { notify('Customer name is required', 'error'); return; }

        apiFetch(cfg.routes.storeCustomer, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': cfg.csrfToken },
            body: JSON.stringify({
                name: name,
                email: document.getElementById('qc-email').value,
                phone: document.getElementById('qc-phone').value,
                city: document.getElementById('qc-city').value,
                address: document.getElementById('qc-address').value,
            }),
        }).then(res => {
            if (!res.success) { notify(res.message || 'Could not save customer', 'error'); return; }

            const select = document.getElementById('customer-select');
            const opt = document.createElement('option');
            opt.value = res.data.id;
            opt.textContent = `${res.data.name} (${res.data.phone || 'N/A'})`;
            opt.selected = true;
            select.appendChild(opt);
            selectedCustomerId = res.data.id;

            notify('Customer added and selected.', 'success');
            bootstrap.Modal.getInstance(document.getElementById('create')).hide();
            this.reset();
        });
    });

    /* =========================================================
       PAYMENT METHOD
    ==========================================================*/
    document.querySelectorAll('.paymentmethod').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('.paymentmethod').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            selectedPaymentMethod = this.dataset.method;

            document.getElementById('payment-reference-row').style.display =
                (selectedPaymentMethod === 'cash') ? 'none' : 'block';
        });
    });

    /* =========================================================
       HOLD ORDER
    ==========================================================*/
    document.getElementById('hold-order-btn').addEventListener('click', function () {
        if (cart.length === 0) { notify('Cart is empty', 'error'); return; }

        apiFetch(cfg.routes.hold, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': cfg.csrfToken },
            body: JSON.stringify({
                customer_id: selectedCustomerId || null,
                payment_method: selectedPaymentMethod,
                discount: parseFloat(document.getElementById('overall-discount').value) || 0,
                tax: parseFloat(document.getElementById('overall-tax').value) || 0,
                items: cart.map(c => ({ product_id: c.product_id, quantity: c.qty, discount: c.discount })),
            }),
        }).then(res => {
            if (!res.success) { notify(res.message, 'error'); return; }
            notify(res.message, 'success');
            clearCart();
        });
    });

    /* =========================================================
       HELD ORDERS LIST (loads when Transactions modal opens)
    ==========================================================*/
    function loadHeldOrders() {
        apiFetch(cfg.routes.heldOrders).then(res => {
            const body = document.getElementById('held-orders-body');
            body.innerHTML = '';
            if (!res.success || res.data.length === 0) {
                body.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No held orders</td></tr>';
                return;
            }
            res.data.forEach(order => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${new Date(order.created_at).toLocaleString()}</td>
                    <td>${order.invoice_no}</td>
                    <td>${order.customer ? escapeHtml(order.customer.name) : 'Walk-in'}</td>
                    <td>${formatCurrency(order.grand_total)}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-success resume-held" data-id="${order.id}">Resume</button>
                        <button class="btn btn-sm btn-danger delete-held" data-id="${order.id}">Delete</button>
                    </td>`;
                body.appendChild(tr);
            });

            document.querySelectorAll('.resume-held').forEach(btn =>
                btn.addEventListener('click', () => resumeHeldOrder(btn.dataset.id)));
            document.querySelectorAll('.delete-held').forEach(btn =>
                btn.addEventListener('click', () => deleteHeldOrder(btn.dataset.id)));
        });
    }

    function resumeHeldOrder(id) {
        apiFetch(`${cfg.routes.resumeHeldOrder}/${id}/resume`).then(res => {
            if (!res.success) { notify(res.message || 'Could not resume order', 'error'); return; }

            cart = res.data.items.map(i => ({
                product_id: i.product_id, name: i.name, sku: i.sku,
                price: i.price, stock: i.stock, qty: i.qty, discount: i.discount,
            }));
            selectedCustomerId = res.data.customer_id || '';
            renderCart();

            bootstrap.Modal.getInstance(document.getElementById('recents')).hide();
            notify('Order resumed into cart.', 'success');
        });
    }

    function deleteHeldOrder(id) {
        if (!confirm('Delete this held order permanently?')) return;
        apiFetch(`${cfg.routes.deleteHeldOrder}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': cfg.csrfToken },
        }).then(res => {
            notify(res.message || 'Deleted', res.success ? 'success' : 'error');
            loadHeldOrders();
        });
    }

    function loadRecentSales() {
        apiFetch(cfg.routes.recentSales).then(res => {
            const body = document.getElementById('recent-sales-body');
            body.innerHTML = '';
            if (!res.success || res.data.length === 0) {
                body.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No sales yet</td></tr>';
                return;
            }
            res.data.forEach(sale => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${new Date(sale.created_at).toLocaleString()}</td>
                    <td>${sale.invoice_no}</td>
                    <td>${sale.customer ? escapeHtml(sale.customer.name) : 'Walk-in'}</td>
                    <td>${formatCurrency(sale.grand_total)}</td>`;
                body.appendChild(tr);
            });
        });
    }

    document.getElementById('recents').addEventListener('show.bs.modal', function () {
        loadRecentSales();
        loadHeldOrders();
    });

    /* =========================================================
       CHECKOUT
    ==========================================================*/
    checkoutBtn.addEventListener('click', function () {
        if (cart.length === 0) { notify('Cart is empty', 'error'); return; }
        if (checkoutBtn.dataset.submitting === '1') return;

        const paidAmount = parseFloat(document.getElementById('paid-amount').value) || 0;
        const overallDiscount = parseFloat(document.getElementById('overall-discount').value) || 0;
        const tax = parseFloat(document.getElementById('overall-tax').value) || 0;
        const reference = document.getElementById('payment-reference').value;

        checkoutBtn.dataset.submitting = '1';
        checkoutBtn.style.opacity = '0.6';

        apiFetch(cfg.routes.checkout, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': cfg.csrfToken },
            body: JSON.stringify({
                customer_id: selectedCustomerId || null,
                payment_method: selectedPaymentMethod,
                payment_reference: reference || null,
                paid_amount: paidAmount,
                discount: overallDiscount,
                tax: tax,
                items: cart.map(c => ({ product_id: c.product_id, quantity: c.qty, discount: c.discount })),
            }),
        }).then(res => {
            checkoutBtn.dataset.submitting = '0';
            checkoutBtn.style.opacity = '1';

            if (!res.success) { notify(res.message, 'error'); return; }

            notify(`Sale completed: ${res.invoice_no}`, 'success');
            clearCart();
            document.getElementById('overall-discount').value = 0;
            document.getElementById('overall-tax').value = 0;
            document.getElementById('payment-reference').value = '';
            loadProducts(); // refresh stock counts shown on cards
            window.open(res.receipt_url, '_blank');
        }).catch(() => {
            checkoutBtn.dataset.submitting = '0';
            checkoutBtn.style.opacity = '1';
            notify('Network error. Please try again.', 'error');
        });
    });

    /* =========================================================
       INIT
    ==========================================================*/
    loadProducts();
    renderCart();
    document.getElementById('barcode-input').focus();
});
</script>
@endsection