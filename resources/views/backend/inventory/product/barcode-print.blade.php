@extends('backend.layouts.layout')
@section('title', 'Barcode Print')
@section('content')

{{-- ===================== ADDITIONAL STYLES ===================== --}}
<style>
    /* ── Modern Barcode Print Styles ── */
    .barcode-grid {
        display: grid;
        gap: 12px;
        padding: 4px;
    }
    .barcode-label {
        border: 1.5px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 8px 8px;
        text-align: center;
        background: #fff;
        break-inside: avoid;
        page-break-inside: avoid;
        transition: all 0.2s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        min-height: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .barcode-label:hover {
        border-color: #ff9f43;
        box-shadow: 0 2px 12px rgba(255, 159, 67, 0.12);
    }
    .barcode-label-name {
        font-weight: 600;
        font-size: 11px;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        color: #1a2634;
    }
    .barcode-label svg {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 2px auto;
    }
    .barcode-label-code {
        font-size: 10px;
        color: #6c7a8a;
        margin-top: 2px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    .barcode-label-price {
        font-size: 13px;
        font-weight: 700;
        margin-top: 2px;
        color: #ff9f43;
    }
    .barcode-label .barcode-error {
        font-size: 11px;
        color: #dc3545;
        padding: 4px 8px;
        background: #fef0f0;
        border-radius: 4px;
    }

    /* ── Product Row ── */
    .product-row {
        border: 1px solid #eef1f5;
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 8px;
        transition: all 0.25s ease;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: default;
    }
    .product-row:hover {
        border-color: #d0d7de;
        background: #fafbfc;
    }
    .product-row.selected-row {
        border-color: #28c76f !important;
        background: rgba(40, 199, 111, 0.06);
        box-shadow: 0 0 0 2px rgba(40, 199, 111, 0.08);
    }
    .product-row .product-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #6c7a8a;
        font-size: 16px;
        flex-shrink: 0;
        overflow: hidden;
    }
    .product-row .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-row .product-info {
        flex: 1;
        min-width: 0;
    }
    .product-row .product-info .product-name {
        font-weight: 600;
        color: #1a2634;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .product-row .product-info .product-meta {
        font-size: 12px;
        color: #6c7a8a;
    }
    .product-row .product-info .product-price {
        font-size: 13px;
        font-weight: 600;
        color: #ff9f43;
    }
    .product-row .copies-wrap {
        flex-shrink: 0;
        width: 75px;
    }
    .product-row .copies-wrap label {
        font-size: 10px;
        font-weight: 600;
        color: #6c7a8a;
        margin-bottom: 1px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .product-row .copies-wrap input {
        width: 100%;
        padding: 4px 6px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .product-row .copies-wrap input:focus {
        border-color: #ff9f43;
        box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        background: #fff;
    }
    .product-row .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        flex-shrink: 0;
        margin-top: 0;
        border-radius: 4px;
        border: 2px solid #d0d7de;
        transition: all 0.2s ease;
    }
    .product-row .form-check-input:checked {
        background-color: #28c76f;
        border-color: #28c76f;
    }

    /* ── Settings Card ── */
    .settings-card .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #1a2634;
    }
    .settings-card .form-select,
    .settings-card .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 8px 12px;
        font-size: 14px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .settings-card .form-select:focus,
    .settings-card .form-control:focus {
        border-color: #ff9f43;
        box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.08);
        background: #fff;
    }
    .settings-card .form-switch .form-check-input {
        width: 40px;
        height: 20px;
        border-radius: 20px;
        border: 2px solid #d0d7de;
        background: #eef1f5;
        transition: all 0.25s ease;
    }
    .settings-card .form-switch .form-check-input:checked {
        background-color: #ff9f43;
        border-color: #ff9f43;
    }
    .settings-card .form-switch .form-check-label {
        font-weight: 500;
        font-size: 14px;
        color: #1a2634;
    }

    /* ── Summary Bar ── */
    .summary-bar {
        background: #fff;
        border-radius: 12px;
        padding: 14px 20px;
        border: 1px solid #eef1f5;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .summary-bar .stats {
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
    }
    .summary-bar .stats .stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: #4a5568;
    }
    .summary-bar .stats .stat-item .badge {
        font-size: 14px;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .summary-bar .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .summary-bar .actions .btn {
        border-radius: 8px;
        padding: 6px 16px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.25s ease;
    }
    .summary-bar .actions .btn-outline-secondary {
        border-color: #e2e8f0;
        color: #4a5568;
    }
    .summary-bar .actions .btn-outline-secondary:hover {
        background: #f8fafc;
        border-color: #d0d7de;
    }
    .summary-bar .actions .btn-success {
        background: #28c76f;
        border-color: #28c76f;
        color: #fff;
    }
    .summary-bar .actions .btn-success:hover {
        background: #20b85f;
        border-color: #20b85f;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(40, 199, 111, 0.25);
    }
    .summary-bar .actions .btn-success:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ── Print Styles ── */
    @media print {
        body * {
            visibility: hidden !important;
        }
        #print-grid, #print-grid * {
            visibility: visible !important;
        }
        #print-grid {
            display: grid !important;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 6mm;
            gap: 6mm;
            background: #fff;
        }
        #print-grid .barcode-label {
            border: 1px solid #ccc !important;
            box-shadow: none !important;
            padding: 6px !important;
            border-radius: 4px !important;
        }
        .no-print {
            display: none !important;
        }
    }

    /* ── Search & Filter ── */
    .search-filter-bar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .search-filter-bar .form-control,
    .search-filter-bar .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        font-size: 14px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .search-filter-bar .form-control:focus,
    .search-filter-bar .form-select:focus {
        border-color: #ff9f43;
        box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.08);
        background: #fff;
    }
    .search-filter-bar .form-control {
        flex: 1;
        min-width: 150px;
    }
    .search-filter-bar .form-select {
        min-width: 140px;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9aa6b2;
    }
    .empty-state i {
        font-size: 48px;
        display: block;
        margin-bottom: 12px;
        color: #dce3ea;
    }
    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .product-row {
            flex-wrap: wrap;
            padding: 10px;
        }
        .product-row .product-info {
            min-width: 100%;
            order: 3;
        }
        .product-row .copies-wrap {
            width: 60px;
        }
        .summary-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .summary-bar .actions {
            justify-content: center;
        }
        .search-filter-bar .form-control {
            min-width: 100%;
        }
        .search-filter-bar .form-select {
            min-width: 100%;
        }
    }
    @media (max-width: 576px) {
        .barcode-label {
            padding: 6px 4px;
        }
        .barcode-label-name {
            font-size: 9px;
        }
        .barcode-label-code {
            font-size: 8px;
        }
        .barcode-label-price {
            font-size: 10px;
        }
        .product-row .product-info .product-name {
            font-size: 13px;
        }
        .settings-card .row > div {
            margin-bottom: 10px;
        }
    }
</style>

<div class="page-wrapper">
    <div class="content">

        {{-- ===================== PAGE HEADER ===================== --}}
        <div class="page-header mb-4">
            <div class="page-title">
                <h4><i class="fa fa-barcode me-2"></i>Barcode Print</h4>
                <p class="text-muted mb-0">Generate and print barcodes for your products with customizable settings.</p>
            </div>
        </div>

        {{-- ===================== BARCODE LIBRARY WARNING ===================== --}}
        <div id="barcode-lib-warning" class="alert alert-danger d-none mb-3">
            <strong>⚠️ Barcode library failed to load.</strong>
            This page needs an internet connection to fetch it the first time (from cdnjs.cloudflare.com or jsDelivr).
            Check your connection, disable any ad blocker for this site, and reload the page.
            If this keeps happening, your network may be blocking those domains.
        </div>

        {{-- ===================== SETTINGS ===================== --}}
        <div class="card settings-card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h5 class="card-title mb-0"><i class="fa fa-sliders-h me-2"></i>Barcode Settings</h5>
                    <div class="d-flex gap-2">
                        <button type="button" id="test-print-btn" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-print me-1"></i>Test Print
                        </button>
                        <button type="button" id="reset-btn" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-undo me-1"></i>Reset
                        </button>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Barcode Field</label>
                        <select id="barcode-field" class="form-select">
                            <option value="sku">SKU</option>
                            <option value="barcode">Barcode Number</option>
                        </select>
                        <small class="text-muted">If a product has no barcode number, its SKU is used instead.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Columns Per Row</label>
                        <select id="columns-per-row" class="form-select">
                            <option value="2">2</option>
                            <option value="3" selected>3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Paper Size</label>
                        <select id="paper-size" class="form-select">
                            <option value="a4" selected>A4 (210 × 297mm)</option>
                            <option value="letter">Letter (8.5 × 11in)</option>
                            <option value="label">Label Sheet (4×6in)</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Barcode Width <small class="text-muted">(1–4)</small></label>
                        <input type="number" id="barcode-width" class="form-control" value="2" min="1" max="4">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Barcode Height <small class="text-muted">(px, 20–120)</small></label>
                        <input type="number" id="barcode-height" class="form-control" value="50" min="20" max="120">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Font Size <small class="text-muted">(px, 8–20)</small></label>
                        <input type="number" id="font-size" class="form-control" value="11" min="8" max="20">
                    </div>

                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show-price" checked>
                            <label class="form-check-label" for="show-price">Show Price</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show-name" checked>
                            <label class="form-check-label" for="show-name">Show Product Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show-sku" checked>
                            <label class="form-check-label" for="show-sku">Show SKU/Barcode</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== SUMMARY BAR ===================== --}}
        <div class="summary-bar mb-3 no-print">
            <div class="stats">
                <div class="stat-item">
                    <span class="badge bg-primary bg-opacity-10 text-primary">
                        <span id="selected-count">0</span> selected
                    </span>
                </div>
                <div class="stat-item">
                    <span class="badge bg-success bg-opacity-10 text-success">
                        <span id="total-count">0</span> labels
                    </span>
                </div>
                <div class="stat-item">
                    <span class="badge bg-warning bg-opacity-10 text-warning">
                        <i class="fa fa-file-pdf me-1"></i> <span id="print-count">0</span> to print
                    </span>
                </div>
            </div>
            <div class="actions">
                <button type="button" id="copy-btn" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-copy me-1"></i>Copy
                </button>
                <button type="button" id="set-all-btn" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-edit me-1"></i>Set All
                </button>
                <button type="button" id="clear-btn" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-times me-1"></i>Clear
                </button>
                <button type="button" id="print-btn" class="btn btn-sm btn-success" disabled>
                    <i class="fa fa-print me-1"></i>Print (<span id="print-count-btn">0</span>)
                </button>
            </div>
        </div>

        {{-- ===================== MAIN CONTENT ===================== --}}
        <div class="row g-3">

            {{-- ========== SELECT PRODUCTS ========== --}}
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-box me-2"></i>Select Products
                                <span class="badge bg-secondary ms-1" id="selected-count-badge">0</span>
                            </h5>
                            <span class="text-muted small">Showing <span id="showing-count">0</span> products</span>
                        </div>

                        {{-- Search & Filter --}}
                        <div class="search-filter-bar mb-3">
                            <input type="text" id="product-search" class="form-control" placeholder="🔍 Search by name or SKU...">
                            <select id="category-filter" class="form-select">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-check d-flex align-items-center" style="margin:0;padding-left:0;">
                                <input class="form-check-input" type="checkbox" id="select-all" style="margin-right:6px;">
                                <label class="form-check-label" for="select-all" style="font-weight:500;font-size:13px;">Select All</label>
                            </div>
                        </div>

                        {{-- Product List --}}
                        <div id="product-list" style="max-height:560px; overflow-y:auto; padding-right:4px;">
                            @forelse ($products as $product)
                                <div class="product-row"
                                     data-id="{{ $product->id }}"
                                     data-name="{{ $product->name }}"
                                     data-sku="{{ $product->sku }}"
                                     data-barcode="{{ $product->barcode ?? $product->sku }}"
                                     data-price="{{ $product->selling_price }}"
                                     data-category="{{ $product->category_id }}">

                                    <input type="checkbox" class="form-check-input product-checkbox">

                                    <div class="product-thumb">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            {{ strtoupper(substr($product->name, 0, 1)) }}
                                        @endif
                                    </div>

                                    <div class="product-info">
                                        <div class="product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                                        <div class="product-meta">
                                            SKU: {{ $product->sku }}
                                            @if ($product->category)
                                                <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ $product->category->name }}</span>
                                            @endif
                                        </div>
                                        <div class="product-price">Rs. {{ number_format($product->selling_price, 2) }}</div>
                                    </div>

                                    <div class="copies-wrap">
                                        <label>Copies</label>
                                        <input type="number" class="copies-input" value="1" min="1" max="999">
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="fa fa-box-open"></i>
                                    <p>No active products found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========== LIVE PREVIEW ========== --}}
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-eye me-2"></i>Live Preview
                            </h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <span id="preview-label-count">0</span> labels
                            </span>
                        </div>

                        <div id="preview-grid" class="barcode-grid" style="max-height:560px; overflow-y:auto; min-height:200px;"></div>

                        <p class="text-muted small text-center mt-3 mb-0" id="preview-empty-hint">
                            <i class="fa fa-hand-pointer me-1"></i>Select a product on the left to see a preview.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===================== PRINT-ONLY AREA ===================== --}}
<div id="print-grid" class="barcode-grid d-none"></div>

{{-- ===================== SCRIPTS ===================== --}}
<script>
    // ── Load Barcode Library with fallback ──
    function loadScript(src, onDone) {
        const s = document.createElement('script');
        s.src = src;
        s.onload = () => onDone(true);
        s.onerror = () => onDone(false);
        document.head.appendChild(s);
    }

    window.barcodeLibReady = false;

    function markReady() {
        window.barcodeLibReady = true;
        document.dispatchEvent(new Event('barcode-lib-ready'));
    }

    loadScript('https://cdnjs.cloudflare.com/ajax/libs/JsBarcode/3.11.5/JsBarcode.all.min.js', function (ok) {
        if (ok) return markReady();
        loadScript('https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js', function (ok2) {
            if (ok2) return markReady();
            document.getElementById('barcode-lib-warning').classList.remove('d-none');
            markReady();
        });
    });

    // ── Main Logic ──
    document.addEventListener('DOMContentLoaded', function () {

        const state = {
            selected: new Map(),
            settings: {},
            allProducts: [],
        };

        // ── DOM References ──
        const els = {
            field: document.getElementById('barcode-field'),
            columns: document.getElementById('columns-per-row'),
            paperSize: document.getElementById('paper-size'),
            width: document.getElementById('barcode-width'),
            height: document.getElementById('barcode-height'),
            fontSize: document.getElementById('font-size'),
            showPrice: document.getElementById('show-price'),
            showName: document.getElementById('show-name'),
            showSku: document.getElementById('show-sku'),

            search: document.getElementById('product-search'),
            category: document.getElementById('category-filter'),
            selectAll: document.getElementById('select-all'),
            showingCount: document.getElementById('showing-count'),

            selectedCount: document.getElementById('selected-count'),
            selectedCountBadge: document.getElementById('selected-count-badge'),
            totalCount: document.getElementById('total-count'),
            printCount: document.getElementById('print-count'),
            printCountBtn: document.getElementById('print-count-btn'),

            preview: document.getElementById('preview-grid'),
            previewLabelCount: document.getElementById('preview-label-count'),
            previewEmptyHint: document.getElementById('preview-empty-hint'),
            printArea: document.getElementById('print-grid'),

            printBtn: document.getElementById('print-btn'),
            testPrintBtn: document.getElementById('test-print-btn'),
            resetBtn: document.getElementById('reset-btn'),
            copyBtn: document.getElementById('copy-btn'),
            setAllBtn: document.getElementById('set-all-btn'),
            clearBtn: document.getElementById('clear-btn'),
        };

        // ── Read Settings ──
        function readSettings() {
            state.settings = {
                field: els.field.value,
                columns: parseInt(els.columns.value) || 3,
                paperSize: els.paperSize.value,
                width: Math.min(4, Math.max(1, parseInt(els.width.value) || 2)),
                height: Math.min(120, Math.max(20, parseInt(els.height.value) || 50)),
                fontSize: Math.min(20, Math.max(8, parseInt(els.fontSize.value) || 11)),
                showPrice: els.showPrice.checked,
                showName: els.showName.checked,
                showSku: els.showSku.checked,
            };
        }

        // ── Utilities ──
        function totalBarcodes() {
            let total = 0;
            state.selected.forEach(p => total += (p.copies || 1));
            return total;
        }

        function updateSummary() {
            const total = totalBarcodes();
            const count = state.selected.size;
            els.selectedCount.textContent = count;
            els.selectedCountBadge.textContent = count;
            els.totalCount.textContent = total;
            els.printCount.textContent = total;
            els.printCountBtn.textContent = total;
            els.printBtn.disabled = total === 0;
        }

        function formatCurrency(amount) {
            return 'Rs. ' + Number(amount).toFixed(2);
        }

        // ── Create Barcode Label ──
        function makeLabel(p, isPrint = false) {
            const div = document.createElement('div');
            div.className = 'barcode-label';

            const fontSize = state.settings.fontSize;

            if (state.settings.showName) {
                const nameEl = document.createElement('div');
                nameEl.className = 'barcode-label-name';
                nameEl.textContent = p.name;
                nameEl.style.fontSize = fontSize + 'px';
                div.appendChild(nameEl);
            }

            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            div.appendChild(svg);

            const value = state.settings.field === 'barcode'
                ? (p.barcode || p.sku)
                : p.sku;

            if (typeof JsBarcode === 'undefined') {
                const errEl = document.createElement('div');
                errEl.className = 'barcode-error';
                errEl.textContent = '⚠️ Library not loaded';
                div.appendChild(errEl);
            } else {
                try {
                    JsBarcode(svg, String(value || 'N/A'), {
                        format: 'CODE128',
                        width: state.settings.width,
                        height: state.settings.height,
                        displayValue: false,
                        margin: 0,
                        background: '#ffffff',
                        lineColor: '#1a2634',
                    });
                } catch (e) {
                    console.error('Barcode generation failed for:', value, e);
                    const errEl = document.createElement('div');
                    errEl.className = 'barcode-error';
                    errEl.textContent = 'Could not generate barcode';
                    div.appendChild(errEl);
                }
            }

            if (state.settings.showSku) {
                const codeEl = document.createElement('div');
                codeEl.className = 'barcode-label-code';
                codeEl.textContent = value;
                codeEl.style.fontSize = Math.max(8, fontSize - 2) + 'px';
                div.appendChild(codeEl);
            }

            if (state.settings.showPrice) {
                const priceEl = document.createElement('div');
                priceEl.className = 'barcode-label-price';
                priceEl.textContent = formatCurrency(p.price);
                priceEl.style.fontSize = (fontSize + 2) + 'px';
                div.appendChild(priceEl);
            }

            return div;
        }

        // ── Render Preview ──
        function renderPreview() {
            readSettings();

            els.preview.innerHTML = '';
            els.printArea.innerHTML = '';
            els.preview.style.gridTemplateColumns = `repeat(${state.settings.columns}, 1fr)`;
            els.printArea.style.gridTemplateColumns = `repeat(${state.settings.columns}, 1fr)`;

            let labelCount = 0;
            const selectedArray = Array.from(state.selected.values());

            // Sort by name for consistent display
            selectedArray.sort((a, b) => a.name.localeCompare(b.name));

            selectedArray.forEach(p => {
                const copies = Math.max(1, parseInt(p.copies) || 1);
                for (let i = 0; i < copies; i++) {
                    labelCount++;
                    const label = makeLabel(p);
                    els.preview.appendChild(label);
                    els.printArea.appendChild(label.cloneNode(true));
                }
            });

            els.previewLabelCount.textContent = labelCount;
            els.previewEmptyHint.style.display = labelCount === 0 ? 'block' : 'none';
            updateSummary();
        }

        // ── Toggle Product Selection ──
        function toggleProduct(id, checked) {
            const row = document.querySelector(`.product-row[data-id="${id}"]`);
            if (!row) return;

            if (checked) {
                state.selected.set(id, {
                    id: id,
                    name: row.dataset.name,
                    sku: row.dataset.sku,
                    barcode: row.dataset.barcode,
                    price: parseFloat(row.dataset.price) || 0,
                    copies: parseInt(row.querySelector('.copies-input').value) || 1,
                });
            } else {
                state.selected.delete(id);
            }
            row.classList.toggle('selected-row', checked);
            renderPreview();
        }

        // ── Apply Filters ──
        function applyFilters() {
            const term = els.search.value.trim().toLowerCase();
            const cat = els.category.value;
            let visible = 0;

            document.querySelectorAll('.product-row').forEach(row => {
                const matchesTerm = !term
                    || row.dataset.name.toLowerCase().includes(term)
                    || row.dataset.sku.toLowerCase().includes(term);
                const matchesCat = !cat || row.dataset.category === cat;
                const show = matchesTerm && matchesCat;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            els.showingCount.textContent = visible;

            // Update select all state
            const visibleRows = document.querySelectorAll('.product-row[style*="display: none"]');
            const totalVisible = document.querySelectorAll('.product-row:not([style*="display: none"])').length;
            const checkedVisible = document.querySelectorAll('.product-row:not([style*="display: none"]) .product-checkbox:checked').length;
            els.selectAll.checked = totalVisible > 0 && checkedVisible === totalVisible;
        }

        // ── Event Listeners ──

        // Product checkboxes
        document.querySelectorAll('.product-checkbox').forEach(cb => {
            cb.addEventListener('change', function () {
                const row = this.closest('.product-row');
                if (row.style.display === 'none') return;
                toggleProduct(row.dataset.id, this.checked);
            });
        });

        // Copies input
        document.querySelectorAll('.copies-input').forEach(input => {
            input.addEventListener('change', function () {
                const row = this.closest('.product-row');
                const id = row.dataset.id;
                let val = Math.max(1, parseInt(this.value) || 1);
                val = Math.min(999, val);
                this.value = val;
                if (state.selected.has(id)) {
                    state.selected.get(id).copies = val;
                    renderPreview();
                }
            });
            input.addEventListener('keyup', function () {
                const row = this.closest('.product-row');
                const id = row.dataset.id;
                let val = Math.max(1, parseInt(this.value) || 1);
                val = Math.min(999, val);
                this.value = val;
                if (state.selected.has(id)) {
                    state.selected.get(id).copies = val;
                    renderPreview();
                }
            });
        });

        // Select All
        els.selectAll.addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.product-row').forEach(row => {
                if (row.style.display === 'none') return;
                const cb = row.querySelector('.product-checkbox');
                cb.checked = checked;
                toggleProduct(row.dataset.id, checked);
            });
        });

        // Search & Filter
        els.search.addEventListener('input', applyFilters);
        els.category.addEventListener('change', applyFilters);

        // Settings changes
        [els.field, els.columns, els.paperSize, els.width, els.height, els.fontSize,
         els.showPrice, els.showName, els.showSku]
            .forEach(el => el.addEventListener('input', renderPreview));
        [els.showPrice, els.showName, els.showSku]
            .forEach(el => el.addEventListener('change', renderPreview));

        // ── Actions ──

        // Set All Copies
        els.setAllBtn.addEventListener('click', function () {
            if (state.selected.size === 0) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('No products selected');
                }
                return;
            }
            const n = prompt('Set copies for every selected product to:', '1');
            if (n === null) return;
            const val = Math.max(1, Math.min(999, parseInt(n) || 1));
            state.selected.forEach(p => p.copies = val);
            document.querySelectorAll('.product-row').forEach(row => {
                if (state.selected.has(row.dataset.id)) {
                    row.querySelector('.copies-input').value = val;
                }
            });
            renderPreview();
        });

        // Clear All
        els.clearBtn.addEventListener('click', function () {
            state.selected.clear();
            document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.product-row').forEach(row => row.classList.remove('selected-row'));
            els.selectAll.checked = false;
            renderPreview();
        });

        // Copy Selection
        els.copyBtn.addEventListener('click', function () {
            const lines = [];
            state.selected.forEach(p => {
                const val = state.settings.field === 'barcode' ? (p.barcode || p.sku) : p.sku;
                lines.push(`${p.name} | ${val} | x${p.copies}`);
            });
            const text = lines.length ? lines.join('\n') : 'No products selected.';

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Selection copied to clipboard');
                    }
                }).catch(() => {
                    fallbackCopy(text);
                });
            } else {
                fallbackCopy(text);
            }

            function fallbackCopy(text) {
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Selection copied to clipboard');
                    }
                } catch (e) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Could not copy to clipboard');
                    }
                }
                document.body.removeChild(textarea);
            }
        });

        // Reset
        els.resetBtn.addEventListener('click', function () {
            els.field.value = 'sku';
            els.columns.value = '3';
            els.paperSize.value = 'a4';
            els.width.value = 2;
            els.height.value = 50;
            els.fontSize.value = 11;
            els.showPrice.checked = true;
            els.showName.checked = true;
            els.showSku.checked = true;
            els.clearBtn.click();
            if (typeof toastr !== 'undefined') {
                toastr.info('Settings reset to defaults');
            }
        });

        // ── Print Functions ──

        function applyPrintPageSize() {
            let styleEl = document.getElementById('dynamic-print-size');
            if (!styleEl) {
                styleEl = document.createElement('style');
                styleEl.id = 'dynamic-print-size';
                document.head.appendChild(styleEl);
            }
            const sizeMap = {
                'a4': 'A4',
                'letter': 'letter',
                'label': '4in 6in'
            };
            const size = sizeMap[state.settings.paperSize] || 'A4';
            const margin = state.settings.paperSize === 'label' ? '2mm' : '8mm';
            styleEl.textContent = `@page { size: ${size}; margin: ${margin}; }`;
        }

        // Test Print
        els.testPrintBtn.addEventListener('click', function () {
            readSettings();
            const sample = {
                name: 'Sample Product',
                sku: 'SAMPLE-001',
                barcode: 'SAMPLE-001',
                price: 0
            };

            els.printArea.innerHTML = '';
            els.printArea.style.gridTemplateColumns = '1fr';
            els.printArea.appendChild(makeLabel(sample));

            applyPrintPageSize();
            window.print();
            renderPreview();
        });

        // Print
        els.printBtn.addEventListener('click', function () {
            if (state.selected.size === 0) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('No products selected');
                }
                return;
            }
            renderPreview();
            applyPrintPageSize();
            window.print();
        });

        // ── Keyboard Shortcuts ──
        document.addEventListener('keydown', function (e) {
            // Ctrl+A to select all visible
            if (e.ctrlKey && e.key === 'a') {
                const target = e.target;
                if (target.tagName !== 'INPUT' && target.tagName !== 'SELECT' && target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                    const allChecked = els.selectAll.checked;
                    document.querySelectorAll('.product-row').forEach(row => {
                        if (row.style.display === 'none') return;
                        const cb = row.querySelector('.product-checkbox');
                        cb.checked = !allChecked;
                        toggleProduct(row.dataset.id, !allChecked);
                    });
                    els.selectAll.checked = !allChecked;
                }
            }
            // Ctrl+P to print
            if (e.ctrlKey && e.key === 'p') {
                if (state.selected.size > 0) {
                    e.preventDefault();
                    els.printBtn.click();
                }
            }
        });

        // ── Auto-focus search ──
        els.search.focus();

        // ── Init ──
        applyFilters();

        if (window.barcodeLibReady) {
            renderPreview();
        } else {
            document.addEventListener('barcode-lib-ready', renderPreview, { once: true });
        }

        // Re-render when library loads if it was already ready
        if (typeof JsBarcode !== 'undefined') {
            window.barcodeLibReady = true;
            renderPreview();
        }

    });
</script>

@endsection