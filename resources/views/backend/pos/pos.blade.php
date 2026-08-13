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
            resumeHeldOrder:  "{{ url('admin/pos/held-orders') }}",
            deleteHeldOrder:  "{{ url('admin/pos/held-orders') }}",
            recentSales:      "{{ route('pos.recent-sales') }}",
        },
        csrfToken: "{{ csrf_token() }}",
        defaultImage: "{{ asset('backend/assets/img/noimage.png') }}",
    };
</script>

{{-- ============================================================
     REDESIGNED POS STYLES — modern, clean, professional
============================================================ --}}
<style>
    /* ── Loader ── */
    #pos-loader {
        position: fixed;
        inset: 0;
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    #pos-loader .spinner-border {
        width: 3.5rem;
        height: 3.5rem;
        border-width: 0.3rem;
    }

    /* ── Product Grid ── */
    .productset {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #eef1f5;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 16px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
    }
    .productset:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(255, 159, 67, 0.15);
        border-color: #ff9f43;
    }
    .productset .productsetimg {
        position: relative;
        overflow: hidden;
        background: #fafbfc;
        padding: 8px;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .productset .productsetimg img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }
    .productset:hover .productsetimg img {
        transform: scale(1.05);
    }
    .productset .productsetimg .stock-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(40, 199, 111, 0.9);
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
    }
    .productset .productsetimg .stock-badge.low {
        background: rgba(234, 84, 85, 0.9);
    }
    .productset.out-of-stock {
        opacity: 0.55;
        cursor: not-allowed;
    }
    .productset.out-of-stock::after {
        content: 'Out of Stock';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-25deg);
        background: #dc3545;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        padding: 6px 24px;
        border-radius: 4px;
        letter-spacing: 1px;
        box-shadow: 0 4px 16px rgba(220,53,69,0.3);
        z-index: 5;
        pointer-events: none;
    }
    .productset .productsetcontent {
        padding: 12px 14px 14px;
        text-align: center;
        border-top: 1px solid #f0f2f5;
    }
    .productset .productsetcontent .product-sku {
        font-size: 11px;
        color: #9aa6b2;
        font-weight: 500;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    .productset .productsetcontent .product-name {
        font-size: 14px;
        font-weight: 600;
        color: #1a2634;
        margin: 4px 0 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }
    .productset .productsetcontent .product-price {
        font-size: 16px;
        font-weight: 700;
        color: #ff9f43;
    }

    /* ── Category Tabs ── */
    #category-tabs .product-details {
        background: #fff;
        border: 1px solid #eef1f5;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        cursor: pointer;
        min-width: 100px;
        text-align: center;
    }
    #category-tabs .product-details img {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 8px;
        margin: 0 auto 6px;
        display: block;
    }
    #category-tabs .product-details h6 {
        font-size: 12px;
        font-weight: 600;
        color: #4a5568;
        margin: 0;
        white-space: nowrap;
    }
    #category-tabs .active .product-details {
        border-color: #ff9f43;
        background: #fff8f0;
        box-shadow: 0 4px 16px rgba(255, 159, 67, 0.15);
    }
    #category-tabs .active .product-details h6 {
        color: #ff9f43;
    }

    /* ── Search & Barcode ── */
    .pos-search-wrapper {
        background: #fff;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        border: 1px solid #eef1f5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .pos-search-wrapper .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    .pos-search-wrapper .form-control:focus {
        border-color: #ff9f43;
        box-shadow: 0 0 0 4px rgba(255, 159, 67, 0.1);
        background: #fff;
    }
    .pos-search-wrapper .btn-scanner {
        border-radius: 10px;
        background: #ff9f43;
        border: none;
        color: #fff;
        padding: 10px 18px;
        transition: all 0.3s ease;
    }
    .pos-search-wrapper .btn-scanner:hover {
        background: #e8892a;
        transform: scale(1.02);
    }

    /* ── Cart Panel ── */
    .cart-panel {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #eef1f5;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .cart-panel .cart-header {
        padding: 16px 20px;
        background: #fafbfc;
        border-bottom: 1px solid #eef1f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cart-panel .cart-header .order-id {
        font-weight: 700;
        color: #1a2634;
        font-size: 16px;
    }
    .cart-panel .cart-header .order-id small {
        font-weight: 400;
        color: #9aa6b2;
        font-size: 13px;
    }
    .cart-panel .cart-header .cart-actions {
        display: flex;
        gap: 8px;
    }
    .cart-panel .cart-header .cart-actions button {
        background: none;
        border: none;
        padding: 6px 10px;
        border-radius: 8px;
        transition: all 0.2s ease;
        color: #9aa6b2;
    }
    .cart-panel .cart-header .cart-actions button:hover {
        background: #fef0f0;
        color: #dc3545;
    }

    /* ── Cart Items ── */
    .cart-items-container {
        max-height: 320px;
        overflow-y: auto;
        padding: 0 16px;
    }
    .cart-items-container::-webkit-scrollbar {
        width: 4px;
    }
    .cart-items-container::-webkit-scrollbar-track {
        background: #f0f2f5;
        border-radius: 10px;
    }
    .cart-items-container::-webkit-scrollbar-thumb {
        background: #ff9f43;
        border-radius: 10px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f2f5;
        gap: 12px;
    }
    .cart-item:last-child {
        border-bottom: none;
    }
    .cart-item .item-info {
        flex: 1;
        min-width: 0;
    }
    .cart-item .item-info .item-name {
        font-weight: 600;
        color: #1a2634;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-item .item-info .item-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 2px;
        font-size: 12px;
        color: #9aa6b2;
    }
    .cart-item .item-qty {
        display: flex;
        align-items: center;
        gap: 4px;
        background: #f8fafc;
        border-radius: 8px;
        padding: 2px;
        border: 1px solid #e2e8f0;
    }
    .cart-item .item-qty button {
        background: none;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        color: #4a5568;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .cart-item .item-qty button:hover {
        background: #ff9f43;
        color: #fff;
    }
    .cart-item .item-qty input {
        width: 32px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 14px;
        color: #1a2634;
        padding: 0;
    }
    .cart-item .item-qty input:focus {
        outline: none;
    }
    .cart-item .item-price {
        font-weight: 700;
        color: #1a2634;
        font-size: 15px;
        min-width: 70px;
        text-align: right;
    }
    .cart-item .item-remove {
        background: none;
        border: none;
        color: #d1d5db;
        padding: 4px 6px;
        border-radius: 6px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .cart-item .item-remove:hover {
        color: #dc3545;
        background: #fef0f0;
    }

    /* ── Totals ── */
    .totals-section {
        padding: 16px 20px;
        background: #fafbfc;
        border-top: 1px solid #eef1f5;
    }
    .totals-section .total-row {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        font-size: 14px;
        color: #4a5568;
    }
    .totals-section .total-row.grand-total {
        font-size: 18px;
        font-weight: 700;
        color: #1a2634;
        padding-top: 10px;
        border-top: 2px solid #e2e8f0;
        margin-top: 6px;
    }
    .totals-section .total-row.grand-total .total-label {
        color: #ff9f43;
    }

    /* ── Payment Methods ── */
    .payment-methods {
        display: flex;
        gap: 8px;
        padding: 12px 20px;
        background: #fff;
        border-top: 1px solid #eef1f5;
        flex-wrap: wrap;
    }
    .payment-methods .pm-btn {
        flex: 1;
        min-width: 70px;
        padding: 8px 12px;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        background: #fff;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
        color: #4a5568;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .payment-methods .pm-btn:hover {
        border-color: #ff9f43;
        background: #fff8f0;
    }
    .payment-methods .pm-btn.active {
        border-color: #ff9f43;
        background: #ff9f43;
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 159, 67, 0.25);
    }
    .payment-methods .pm-btn img {
        width: 18px;
        height: 18px;
        filter: grayscale(0.5);
    }
    .payment-methods .pm-btn.active img {
        filter: brightness(0) invert(1);
    }

    /* ── Checkout Bar ── */
    .checkout-bar {
        padding: 12px 20px 16px;
        background: #1a2634;
        border-radius: 0 0 16px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .checkout-bar:hover {
        background: #2d3a4a;
    }
    .checkout-bar .checkout-label {
        color: rgba(255,255,255,0.6);
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    .checkout-bar .checkout-amount {
        color: #fff;
        font-size: 22px;
        font-weight: 700;
    }

    /* ── Payment Inputs ── */
    .payment-inputs {
        padding: 12px 20px;
        background: #fff;
        border-top: 1px solid #eef1f5;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .payment-inputs .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 8px 12px;
        font-size: 14px;
        background: #f8fafc;
        transition: all 0.3s ease;
    }
    .payment-inputs .form-control:focus {
        border-color: #ff9f43;
        box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        background: #fff;
    }
    .payment-inputs .form-control[readonly] {
        background: #f0f2f5;
        cursor: default;
    }

    /* ── Action Buttons ── */
    .pos-actions {
        display: flex;
        gap: 6px;
        padding: 10px 20px 16px;
        background: #fff;
        border-top: 1px solid #eef1f5;
        flex-wrap: wrap;
        border-radius: 0 0 16px 16px;
    }
    .pos-actions .btn-pos-action {
        flex: 1;
        min-width: 60px;
        padding: 8px 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 12px;
        font-weight: 600;
        color: #4a5568;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }
    .pos-actions .btn-pos-action:hover {
        border-color: #ff9f43;
        background: #fff8f0;
        color: #ff9f43;
    }
    .pos-actions .btn-pos-action img {
        width: 16px;
        height: 16px;
    }

    /* ── Calculator ── */
    #calc-expression {
        min-height: 16px;
        text-align: right;
        color: #9aa6b2;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
        padding: 0 2px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #calc-display {
        background: #fafbfc;
        border: 1px solid #eef1f5;
        border-radius: 10px;
        padding: 14px 16px;
        text-align: right;
        font-size: 30px;
        font-weight: 700;
        color: #1a2634;
        margin: 4px 0 14px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .calc-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    .calc-btn {
        padding: 14px 0;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 18px;
        font-weight: 600;
        color: #1a2634;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .calc-btn:hover {
        border-color: #ff9f43;
        background: #fff8f0;
    }
    .calc-btn:active {
        transform: scale(0.95);
    }
    .calc-btn-fn {
        background: #f8fafc;
        color: #4a5568;
    }
    .calc-btn-op {
        background: #fff8f0;
        color: #ff9f43;
    }
    .calc-btn-op.active-op {
        background: #ff9f43;
        color: #fff;
        border-color: #ff9f43;
    }
    .calc-btn-eq {
        background: #ff9f43;
        color: #fff;
        border-color: #ff9f43;
    }
    .calc-btn-eq:hover {
        background: #f79433;
        color: #fff;
    }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .productset .productsetimg { height: 120px; }
        .payment-inputs { grid-template-columns: 1fr; }
        .checkout-bar .checkout-amount { font-size: 18px; }
    }
    @media (max-width: 575px) {
        .productset .productsetimg { height: 100px; }
        .pos-search-wrapper { padding: 12px 16px; }
        .cart-panel .cart-header { flex-wrap: wrap; gap: 8px; }
        .payment-methods .pm-btn { min-width: 50px; font-size: 11px; padding: 6px 8px; }
        .pos-actions .btn-pos-action { min-width: 45px; font-size: 10px; padding: 6px 8px; }
        .calc-btn { padding: 12px 0; font-size: 16px; }
        #calc-display { font-size: 24px; padding: 12px 14px; }
    }

    /* ── Misc ── */
    .empty-cart-message {
        text-align: center;
        padding: 40px 16px;
        color: #b0bcc8;
    }
    .empty-cart-message i {
        font-size: 48px;
        margin-bottom: 12px;
        display: block;
        color: #dce3ea;
    }
    .empty-cart-message p {
        font-size: 14px;
        margin: 0;
    }

    .balance-success { color: #28c76f !important; font-weight: 600; }
    .balance-danger { color: #dc3545 !important; font-weight: 600; }
</style>

<div id="pos-loader">
    <div class="spinner-border text-warning" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div class="main-wrappers">
    <div class="page-wrapper">
        <div class="content">
            <div class="row g-3">

                {{-- ========== LEFT COLUMN: Products ========== --}}
                <div class="col-lg-8 col-sm-12">

                    {{-- Search & Barcode --}}
                    <div class="pos-search-wrapper">
                        <div class="row g-2">
                            <div class="col-md-7">
                                <input type="text" id="product-search" class="form-control"
                                    placeholder="🔍 Search product by name or SKU...">
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" id="barcode-input" class="form-control"
                                        placeholder="📷 Scan or type barcode" autocomplete="off">
                                    <button class="btn btn-scanner" type="button" id="barcode-submit-btn">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect x="7" y="7" width="10" height="10"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Category Tabs --}}
                    <ul class="tabs owl-carousel owl-theme owl-product border-0 mb-3" id="category-tabs">
                        <li class="active" data-category-id="">
                            <div class="product-details">
                                <i class="fa fa-th" style="font-size:24px;color:#ff9f43;"></i>
                                <h6>All</h6>
                            </div>
                        </li>
                        @foreach ($categories as $category)
                            <li data-category-id="{{ $category->id }}">
                                <div class="product-details">
                                    <img src="{{ $category->image ? asset('storage/'.$category->image) : asset('backend/assets/img/noimage.png') }}"
                                         alt="{{ $category->name }}" />
                                    <h6>{{ Str::limit($category->name, 12) }}</h6>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Product Grid --}}
                    <div class="row" id="product-grid"></div>
                </div>

                {{-- ========== RIGHT COLUMN: Cart ========== --}}
                <div class="col-lg-4 col-sm-12">
                    <div class="cart-panel">

                        {{-- Header --}}
                        <div class="cart-header">
                            <div class="order-id">
                                🧾 Order
                                <small>#<span id="temp-txn-id">{{ rand(10000, 99999) }}</span></small>
                            </div>
                            <div class="cart-actions">
                                <button id="clear-cart-btn" title="Clear cart">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Customer --}}
                        <div style="padding:12px 20px;border-bottom:1px solid #eef1f5;">
                            <div class="row g-2">
                                <div class="col-6">
                                    <select class="form-control" id="customer-select" style="font-size:13px;border-radius:8px;border:1px solid #e2e8f0;padding:6px 10px;">
                                        <option value="">👤 Walk-in</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex gap-1">
                                        <input type="text" id="customer-search-input" class="form-control" placeholder="Search customer..." style="font-size:13px;border-radius:8px;border:1px solid #e2e8f0;padding:6px 10px;">
                                        <button class="btn btn-sm" style="background:#ff9f43;color:#fff;border-radius:8px;padding:4px 10px;" data-bs-toggle="modal" data-bs-target="#create">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Cart Items --}}
                        <div style="padding:8px 0 0;">
                            <div class="d-flex justify-content-between px-3 py-1" style="font-size:12px;color:#9aa6b2;font-weight:600;">
                                <span>Item</span>
                                <span>Qty</span>
                                <span>Price</span>
                                <span></span>
                            </div>
                            <div class="cart-items-container" id="cart-container">
                                <div id="empty-cart-msg" class="empty-cart-message">
                                    <i class="fa fa-shopping-bag"></i>
                                    <p>Your cart is empty</p>
                                </div>
                                <ul class="list-unstyled m-0" id="cart-list"></ul>
                            </div>
                        </div>

                        {{-- Totals --}}
                        <div class="totals-section" id="totals-area">
                            <div class="total-row"><span>Subtotal</span><span id="display-subtotal">Rs. 0.00</span></div>
                            <div class="total-row"><span>Discount</span><span id="display-discount">Rs. 0.00</span></div>
                            <div class="total-row"><span>Tax</span><span id="display-tax">Rs. 0.00</span></div>
                            <div class="total-row grand-total">
                                <span class="total-label">Total</span>
                                <span id="display-total">Rs. 0.00</span>
                            </div>
                        </div>

                        {{-- Discount & Tax Inputs --}}
                        <div style="padding:8px 20px;background:#fafbfc;border-top:1px solid #eef1f5;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div>
                                <label style="font-size:11px;font-weight:600;color:#9aa6b2;display:block;margin-bottom:2px;">Discount (Rs.)</label>
                                <input type="number" id="overall-discount" class="form-control" value="0" min="0" step="0.01" style="padding:6px 10px;border-radius:8px;border:1px solid #e2e8f0;font-size:13px;">
                            </div>
                            <div>
                                <label style="font-size:11px;font-weight:600;color:#9aa6b2;display:block;margin-bottom:2px;">Tax (Rs.)</label>
                                <input type="number" id="overall-tax" class="form-control" value="0" min="0" step="0.01" style="padding:6px 10px;border-radius:8px;border:1px solid #e2e8f0;font-size:13px;">
                            </div>
                        </div>

                        {{-- Payment Methods --}}
                        <div class="payment-methods">
                            <button class="pm-btn active" data-method="cash">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
                                Cash
                            </button>
                            <button class="pm-btn" data-method="card">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M2 10h20"/></svg>
                                Card
                            </button>
                            <button class="pm-btn" data-method="bank_transfer">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                Bank
                            </button>
                        </div>

                        {{-- Payment Inputs --}}
                        <div class="payment-inputs" id="payment-reference-row" style="display:none;">
                            <div class="col-12">
                                <label style="font-size:11px;font-weight:600;color:#9aa6b2;display:block;margin-bottom:2px;">Reference</label>
                                <input type="text" id="payment-reference" class="form-control" placeholder="Optional reference">
                            </div>
                        </div>
                        <div class="payment-inputs" style="border-top:none;padding-top:0;">
                            <div>
                                <label style="font-size:11px;font-weight:600;color:#9aa6b2;display:block;margin-bottom:2px;">Paid Amount</label>
                                <input type="number" id="paid-amount" class="form-control" value="0" min="0" step="0.01">
                            </div>
                            <div>
                                <label style="font-size:11px;font-weight:600;color:#9aa6b2;display:block;margin-bottom:2px;">Balance</label>
                                <input type="text" id="change-due" class="form-control" value="Rs. 0.00" readonly>
                            </div>
                        </div>

                        {{-- Checkout Bar --}}
                        <div class="checkout-bar" id="checkout-btn">
                            <span class="checkout-label">💳 Checkout</span>
                            <span class="checkout-amount" id="checkout-total" data-raw="0">Rs. 0.00</span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pos-actions">
                            <button class="btn-pos-action" id="hold-order-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="12"/><line x1="12" y1="12" x2="16" y2="12"/></svg>
                                Hold
                            </button>
                            <button class="btn-pos-action" id="quotation-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Quote
                            </button>
                            <button class="btn-pos-action" id="void-order-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Void
                            </button>
                            <button class="btn-pos-action" id="payment-focus-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Pay
                            </button>
                            <button class="btn-pos-action" data-bs-toggle="modal" data-bs-target="#recents">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                History
                            </button>
                            <button class="btn-pos-action" id="calculator-btn" data-bs-toggle="modal" data-bs-target="#calculator-modal">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="14" x2="8" y2="14"/><line x1="12" y1="14" x2="12" y2="14"/><line x1="16" y1="14" x2="16" y2="14"/><line x1="8" y1="18" x2="8" y2="18"/><line x1="12" y1="18" x2="12" y2="18"/><line x1="16" y1="18" x2="16" y2="18"/></svg>
                                Calc
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ===================== MODALS (unchanged) ===================== --}}

<div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid #eef1f5;padding:16px 24px;">
                <h5 class="modal-title" style="font-weight:700;">Add Customer</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border:none;background:none;font-size:24px;color:#9aa6b2;">×</button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <form id="quick-customer-form">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label style="font-weight:600;font-size:13px;">Customer Name *</label>
                                <input type="text" id="qc-name" class="form-control" required style="border-radius:8px;border:1px solid #e2e8f0;padding:8px 12px;"></div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label style="font-weight:600;font-size:13px;">Email</label>
                                <input type="text" id="qc-email" class="form-control" style="border-radius:8px;border:1px solid #e2e8f0;padding:8px 12px;"></div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label style="font-weight:600;font-size:13px;">Phone</label>
                                <input type="text" id="qc-phone" class="form-control" style="border-radius:8px;border:1px solid #e2e8f0;padding:8px 12px;"></div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group"><label style="font-weight:600;font-size:13px;">City</label>
                                <input type="text" id="qc-city" class="form-control" style="border-radius:8px;border:1px solid #e2e8f0;padding:8px 12px;"></div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group"><label style="font-weight:600;font-size:13px;">Address</label>
                                <input type="text" id="qc-address" class="form-control" style="border-radius:8px;border:1px solid #e2e8f0;padding:8px 12px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <button type="submit" class="btn" style="background:#ff9f43;color:#fff;font-weight:600;padding:10px 32px;border-radius:8px;border:none;">Save Customer</button>
                        <a class="btn" data-bs-dismiss="modal" style="background:#eef1f5;color:#4a5568;font-weight:600;padding:10px 32px;border-radius:8px;border:none;margin-left:8px;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid #eef1f5;padding:16px 24px;">
                <h5 class="modal-title" style="font-weight:700;">Void Order</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border:none;background:none;font-size:24px;color:#9aa6b2;">×</button>
            </div>
            <div class="modal-body" style="padding:24px;text-align:center;">
                <div style="font-size:48px;margin-bottom:12px;">⚠️</div>
                <p style="font-size:16px;color:#4a5568;margin-bottom:4px;">The current cart will be cleared.</p>
                <p style="font-size:14px;color:#9aa6b2;">This action cannot be undone.</p>
                <div class="mt-4">
                    <button class="btn" id="confirm-clear-cart" style="background:#dc3545;color:#fff;font-weight:600;padding:10px 32px;border-radius:8px;border:none;margin-right:8px;">Yes, clear cart</button>
                    <button class="btn" data-bs-dismiss="modal" style="background:#eef1f5;color:#4a5568;font-weight:600;padding:10px 32px;border-radius:8px;border:none;">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="calculator-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:320px;">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid #eef1f5;padding:16px 20px;">
                <h5 class="modal-title" style="font-weight:700;">Calculator</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border:none;background:none;font-size:24px;color:#9aa6b2;">×</button>
            </div>
            <div class="modal-body" style="padding:14px 20px 20px;">
                {{-- This calculator is fully independent of the cart/checkout math below —
                     it never reads from or writes to any POS total. --}}
                <div id="calc-expression">&nbsp;</div>
                <div id="calc-display">0</div>
                <div class="calc-grid">
                    <button type="button" class="calc-btn calc-btn-fn" data-calc="clear">C</button>
                    <button type="button" class="calc-btn calc-btn-fn" data-calc="backspace">⌫</button>
                    <button type="button" class="calc-btn calc-btn-fn" data-calc="percent">%</button>
                    <button type="button" class="calc-btn calc-btn-op" data-calc="op" data-op="/">÷</button>

                    <button type="button" class="calc-btn" data-calc="digit" data-digit="7">7</button>
                    <button type="button" class="calc-btn" data-calc="digit" data-digit="8">8</button>
                    <button type="button" class="calc-btn" data-calc="digit" data-digit="9">9</button>
                    <button type="button" class="calc-btn calc-btn-op" data-calc="op" data-op="*">×</button>

                    <button type="button" class="calc-btn" data-calc="digit" data-digit="4">4</button>
                    <button type="button" class="calc-btn" data-calc="digit" data-digit="5">5</button>
                    <button type="button" class="calc-btn" data-calc="digit" data-digit="6">6</button>
                    <button type="button" class="calc-btn calc-btn-op" data-calc="op" data-op="-">−</button>

                    <button type="button" class="calc-btn" data-calc="digit" data-digit="1">1</button>
                    <button type="button" class="calc-btn" data-calc="digit" data-digit="2">2</button>
                    <button type="button" class="calc-btn" data-calc="digit" data-digit="3">3</button>
                    <button type="button" class="calc-btn calc-btn-op" data-calc="op" data-op="+">+</button>

                    <button type="button" class="calc-btn" data-calc="sign">±</button>
                    <button type="button" class="calc-btn" data-calc="digit" data-digit="0">0</button>
                    <button type="button" class="calc-btn" data-calc="decimal">.</button>
                    <button type="button" class="calc-btn calc-btn-eq" data-calc="equals">=</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="recents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid #eef1f5;padding:16px 24px;">
                <h5 class="modal-title" style="font-weight:700;">Transactions</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border:none;background:none;font-size:24px;color:#9aa6b2;">×</button>
            </div>
            <div class="modal-body" style="padding:20px 24px;">
                <ul class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #eef1f5;gap:4px;">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#salespane" type="button" style="border:none;padding:8px 16px;border-radius:8px;font-weight:600;color:#4a5568;">Sales</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#heldpane" type="button" style="border:none;padding:8px 16px;border-radius:8px;font-weight:600;color:#4a5568;">Held</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#paymentpane" type="button" style="border:none;padding:8px 16px;border-radius:8px;font-weight:600;color:#4a5568;">Payment</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#returnpane" type="button" style="border:none;padding:8px 16px;border-radius:8px;font-weight:600;color:#4a5568;">Return</button></li>
                </ul>
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="salespane">
                        <div class="table-responsive">
                            <table class="table" style="font-size:14px;">
                                <thead style="background:#f8fafc;"><tr><th>Date</th><th>Invoice</th><th>Customer</th><th>Total</th></tr></thead>
                                <tbody id="recent-sales-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="heldpane">
                        <div class="table-responsive">
                            <table class="table" style="font-size:14px;">
                                <thead style="background:#f8fafc;"><tr><th>Date</th><th>Invoice</th><th>Customer</th><th>Total</th><th class="text-end">Action</th></tr></thead>
                                <tbody id="held-orders-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="paymentpane">
                        <p class="text-muted text-center py-4">Recording customer payments is coming soon.</p>
                    </div>
                    <div class="tab-pane fade" id="returnpane">
                        <p class="text-muted text-center py-4">Returns/refunds workflow is coming soon.</p>
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
        return fetch(url, options)
            .then(async (res) => {
                const data = await res.json().catch(() => ({ success: false, message: 'Invalid server response' }));
                return data;
            });
    }

    /* ── Products ── */
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
            productGrid.innerHTML = '<div class="col-12 text-center text-muted py-5">No products found</div>';
            return;
        }

        products.forEach(p => {
            const outOfStock = parseInt(p.stock) <= 0;
            const stockBadge = outOfStock ? 'Out of Stock' : (parseInt(p.stock) < 5 ? `Only ${p.stock} left` : `Qty: ${p.stock}`);
            const isLow = parseInt(p.stock) > 0 && parseInt(p.stock) < 5;

            const col = document.createElement('div');
            col.className = 'col-lg-3 col-md-4 col-sm-6';
            col.innerHTML = `
                <div class="productset ${outOfStock ? 'out-of-stock' : ''}"
                     data-id="${p.id}" data-name="${escapeHtml(p.name)}" data-sku="${escapeHtml(p.sku)}"
                     data-price="${p.selling_price}" data-stock="${p.stock}">
                    <div class="productsetimg">
                        <img src="${p.image_url}" alt="${escapeHtml(p.name)}" onerror="this.src='${cfg.defaultImage}'">
                        <span class="stock-badge ${isLow ? 'low' : ''}">${stockBadge}</span>
                    </div>
                    <div class="productsetcontent">
                        <div class="product-sku">${escapeHtml(p.sku)}</div>
                        <div class="product-name">${escapeHtml(p.name)}</div>
                        <div class="product-price">${formatCurrency(p.selling_price)}</div>
                    </div>
                </div>`;
            productGrid.appendChild(col);
        });

        document.querySelectorAll('.productset:not(.out-of-stock)').forEach(el => {
            el.addEventListener('click', function () {
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

    /* ── Categories ── */
    document.querySelectorAll('#category-tabs li').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('#category-tabs li').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeCategoryId = this.dataset.categoryId || '';
            loadProducts(document.getElementById('product-search').value);
        });
    });

    /* ── Search ── */
    let searchDebounce;
    document.getElementById('product-search').addEventListener('input', function () {
        clearTimeout(searchDebounce);
        const term = this.value;
        searchDebounce = setTimeout(() => loadProducts(term), 350);
    });

    /* ── Barcode ── */
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
                product_id: p.id, name: p.name, sku: p.sku,
                price: parseFloat(p.selling_price), stock: parseFloat(p.stock),
            });
        });
    }

    document.getElementById('barcode-input').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); handleBarcodeSubmit(); }
    });
    document.getElementById('barcode-submit-btn').addEventListener('click', handleBarcodeSubmit);

    /* ── Cart ── */
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
        const hasItems = cart.length > 0;
        emptyCartMsg.style.display = hasItems ? 'none' : 'block';

        cart.forEach((item, index) => {
            const li = document.createElement('li');
            li.className = 'cart-item';
            li.innerHTML = `
                <div class="item-info">
                    <div class="item-name">${escapeHtml(item.name)}</div>
                    <div class="item-meta">
                        <span>${escapeHtml(item.sku)}</span>
                        <span>•</span>
                        <span>${formatCurrency(item.price)}</span>
                    </div>
                </div>
                <div class="item-qty">
                    <button class="dec-btn" data-index="${index}">−</button>
                    <input type="text" value="${item.qty}" readonly>
                    <button class="inc-btn" data-index="${index}">+</button>
                </div>
                <div class="item-price">${formatCurrency(item.price * item.qty)}</div>
                <button class="item-remove" data-index="${index}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            `;
            cartList.appendChild(li);
        });

        document.querySelectorAll('.inc-btn').forEach(btn =>
            btn.addEventListener('click', () => changeQty(parseInt(btn.dataset.index), 1)));
        document.querySelectorAll('.dec-btn').forEach(btn =>
            btn.addEventListener('click', () => changeQty(parseInt(btn.dataset.index), -1)));
        document.querySelectorAll('.item-remove').forEach(btn =>
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

    document.getElementById('clear-cart-btn').addEventListener('click', function (e) {
        e.preventDefault();
        if (cart.length === 0) return;
        new bootstrap.Modal(document.getElementById('delete')).show();
    });
    document.getElementById('void-order-btn').addEventListener('click', function () {
        if (cart.length === 0) { notify('Cart is already empty', 'error'); return; }
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

    /* ── Totals ── */
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
            el.className = 'form-control balance-success';
        } else {
            el.value = 'Due: ' + formatCurrency(Math.abs(diff));
            el.className = 'form-control balance-danger';
        }
    }

    document.getElementById('overall-discount').addEventListener('input', refreshTotals);
    document.getElementById('overall-tax').addEventListener('input', refreshTotals);
    document.getElementById('paid-amount').addEventListener('input', updateBalanceDisplay);

    /* ── Customer ── */
    let customerDebounce;
    document.getElementById('customer-search-input').addEventListener('input', function () {
        clearTimeout(customerDebounce);
        const term = this.value;
        customerDebounce = setTimeout(() => {
            if (!term) return;
            apiFetch(`${cfg.routes.searchCustomers}?term=${encodeURIComponent(term)}`).then(res => {
                if (!res.success) return;
                const select = document.getElementById('customer-select');
                select.innerHTML = '<option value="">👤 Walk-in</option>';
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

    /* ── Payment Method ── */
    document.querySelectorAll('.pm-btn').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('.pm-btn').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            selectedPaymentMethod = this.dataset.method;

            document.getElementById('payment-reference-row').style.display =
                (selectedPaymentMethod === 'cash') ? 'none' : 'block';
        });
    });

    /* ── Hold Order ── */
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

    /* ── Held Orders ── */
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
                        <button class="btn btn-sm btn-success resume-held" data-id="${order.id}" style="border-radius:6px;padding:4px 12px;background:#28c76f;color:#fff;border:none;font-weight:600;">Resume</button>
                        <button class="btn btn-sm btn-danger delete-held" data-id="${order.id}" style="border-radius:6px;padding:4px 12px;background:#dc3545;color:#fff;border:none;font-weight:600;">Delete</button>
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

    /* ── Checkout ── */
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
            loadProducts();
            if (res.receipt_url) window.open(res.receipt_url, '_blank');
        }).catch(() => {
            checkoutBtn.dataset.submitting = '0';
            checkoutBtn.style.opacity = '1';
            notify('Network error. Please try again.', 'error');
        });
    });

    /* ── Calculator (independent of the cart/checkout math) ──
       This never reads from or writes to `cart`, discounts, tax, payment,
       or checkout totals. It's a self-contained arithmetic tool only. */
    (function initCalculator() {
        const calcModalEl = document.getElementById('calculator-modal');
        const calcDisplayEl = document.getElementById('calc-display');
        const calcExpressionEl = document.getElementById('calc-expression');
        const calcGrid = calcModalEl ? calcModalEl.querySelector('.calc-grid') : null;
        if (!calcModalEl || !calcDisplayEl || !calcExpressionEl || !calcGrid) return;

        const MAX_DIGITS = 15;
        const opSymbols = { '+': '+', '-': '−', '*': '×', '/': '÷' };

        let display = '0';
        let previousValue = null;
        let pendingOperator = null;
        let waitingForOperand = false;
        let justEvaluated = false;
        let lastOperand = null;
        let lastOperator = null;

        function compute(a, b, operator) {
            switch (operator) {
                case '+': return a + b;
                case '-': return a - b;
                case '*': return a * b;
                case '/': return b === 0 ? null : a / b; // division-by-zero guard
                default: return b;
            }
        }

        // Rounds away floating-point noise (e.g. 0.1 + 0.2) and returns a
        // plain numeric string, never scientific notation at this stage.
        function trimNumber(num) {
            if (!isFinite(num)) return '0';
            return String(Math.round(num * 1e10) / 1e10);
        }

        function formatCalcNumber(value) {
            if (typeof value === 'string' && (value === 'Error' || value.endsWith('.'))) return value;
            const num = parseFloat(value);
            if (!isFinite(num)) return String(value);
            if (Math.abs(num) >= 1e15 || (Math.abs(num) < 1e-9 && num !== 0)) {
                return num.toExponential(6);
            }
            const str = num.toString();
            return str.length > MAX_DIGITS ? num.toPrecision(10) : str;
        }

        function updateDisplay() {
            calcDisplayEl.textContent = formatCalcNumber(display);
            calcExpressionEl.textContent = (previousValue !== null && pendingOperator)
                ? `${formatCalcNumber(String(previousValue))} ${opSymbols[pendingOperator]}`
                : '\u00A0';

            calcGrid.querySelectorAll('.calc-btn-op').forEach(btn => {
                btn.classList.toggle('active-op', !!pendingOperator && waitingForOperand && btn.dataset.op === pendingOperator);
            });
        }

        function resetChain() {
            previousValue = null;
            pendingOperator = null;
            lastOperand = null;
            lastOperator = null;
        }

        function inputDigit(digit) {
            if (justEvaluated) {
                display = digit;
                resetChain();
                justEvaluated = false;
            } else if (waitingForOperand) {
                display = digit;
                waitingForOperand = false;
            } else {
                display = (display === '0') ? digit : display + digit;
            }
            if (display.replace('-', '').replace('.', '').length > MAX_DIGITS) return;
            updateDisplay();
        }

        function inputDecimal() {
            if (justEvaluated) {
                display = '0.';
                resetChain();
                justEvaluated = false;
            } else if (waitingForOperand) {
                display = '0.';
                waitingForOperand = false;
            } else if (display.indexOf('.') === -1) {
                display += '.';
            }
            updateDisplay();
        }

        function toggleSign() {
            if (display === '0' || display === 'Error') return;
            display = display.startsWith('-') ? display.slice(1) : '-' + display;
            updateDisplay();
        }

        function inputPercent() {
            if (display === 'Error') return;
            const current = parseFloat(display) || 0;
            const result = (previousValue !== null && pendingOperator)
                ? (previousValue * current) / 100
                : current / 100;
            display = trimNumber(result);
            waitingForOperand = false;
            updateDisplay();
        }

        function backspace() {
            if (justEvaluated || display === 'Error') { clearAll(); return; }
            if (waitingForOperand) return;
            display = display.length > 1 ? display.slice(0, -1) : '0';
            if (display === '-') display = '0';
            updateDisplay();
        }

        function clearAll() {
            display = '0';
            resetChain();
            waitingForOperand = false;
            justEvaluated = false;
            updateDisplay();
        }

        function setOperator(operator) {
            if (display === 'Error') return;
            const current = parseFloat(display);

            if (pendingOperator && waitingForOperand) {
                // Pressing another operator right after one just chooses the new one.
                pendingOperator = operator;
                updateDisplay();
                return;
            }

            if (previousValue === null) {
                previousValue = current;
            } else if (pendingOperator) {
                const result = compute(previousValue, current, pendingOperator);
                if (result === null) { showDivisionByZero(); return; }
                display = trimNumber(result);
                previousValue = parseFloat(display);
            }

            pendingOperator = operator;
            waitingForOperand = true;
            justEvaluated = false;
            updateDisplay();
        }

        function equals() {
            if (display === 'Error') return;
            const current = parseFloat(display);

            let a, b, operator;

            if (pendingOperator !== null && !waitingForOperand) {
                a = previousValue; b = current; operator = pendingOperator;
                lastOperand = current; lastOperator = pendingOperator;
            } else if (pendingOperator !== null && waitingForOperand) {
                // Operator pressed but no second operand typed (e.g. "5 + =").
                a = previousValue; b = previousValue; operator = pendingOperator;
                lastOperand = previousValue; lastOperator = pendingOperator;
            } else if (lastOperator !== null) {
                // Repeated "=" — redo the last operation with the same operand.
                a = current; b = lastOperand; operator = lastOperator;
            } else {
                justEvaluated = true;
                updateDisplay();
                return;
            }

            const result = compute(a, b, operator);
            if (result === null) { showDivisionByZero(); return; }

            display = trimNumber(result);
            previousValue = parseFloat(display);
            pendingOperator = null;
            waitingForOperand = false;
            justEvaluated = true;
            updateDisplay();
        }

        function showDivisionByZero() {
            display = 'Error';
            resetChain();
            waitingForOperand = false;
            justEvaluated = true;
            calcDisplayEl.textContent = 'Cannot divide by 0';
            calcExpressionEl.textContent = '\u00A0';
        }

        calcGrid.addEventListener('click', function (e) {
            const btn = e.target.closest('.calc-btn');
            if (!btn) return;

            switch (btn.dataset.calc) {
                case 'digit': inputDigit(btn.dataset.digit); break;
                case 'decimal': inputDecimal(); break;
                case 'sign': toggleSign(); break;
                case 'percent': inputPercent(); break;
                case 'backspace': backspace(); break;
                case 'clear': clearAll(); break;
                case 'op': setOperator(btn.dataset.op); break;
                case 'equals': equals(); break;
            }
        });

        // Fresh state every time it's opened — never carries over between sessions.
        calcModalEl.addEventListener('show.bs.modal', clearAll);

        document.addEventListener('keydown', function (e) {
            if (!calcModalEl.classList.contains('show')) return;

            if (e.key >= '0' && e.key <= '9') { inputDigit(e.key); e.preventDefault(); return; }

            switch (e.key) {
                case '.': inputDecimal(); e.preventDefault(); break;
                case '+': setOperator('+'); e.preventDefault(); break;
                case '-': setOperator('-'); e.preventDefault(); break;
                case '*': setOperator('*'); e.preventDefault(); break;
                case '/': setOperator('/'); e.preventDefault(); break;
                case '%': inputPercent(); e.preventDefault(); break;
                case 'Enter':
                case '=': equals(); e.preventDefault(); break;
                case 'Backspace': backspace(); e.preventDefault(); break;
                case 'Escape': {
                    const instance = bootstrap.Modal.getInstance(calcModalEl);
                    if (instance) instance.hide();
                    e.preventDefault();
                    break;
                }
            }
        });

        updateDisplay();
    })();

    /* ── Init ── */
    loadProducts();
    renderCart();
    document.getElementById('barcode-input').focus();

    // Auto-focus barcode input on any click outside inputs
    document.addEventListener('click', function(e) {
        const tag = e.target.tagName.toLowerCase();
        if (tag !== 'input' && tag !== 'button' && tag !== 'select') {
            document.getElementById('barcode-input').focus();
        }
    });
});
</script>
@endsection