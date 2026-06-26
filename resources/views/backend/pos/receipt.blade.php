@extends('backend.layouts.layout')
@section('title', 'Receipt')
@section('content')

<style>
    .receipt-wrapper {
        max-width: 340px;
        margin: 20px auto;
        background: #fff;
        box-shadow: 0 0 12px rgba(0,0,0,0.12);
        border-radius: 6px;
        overflow: hidden;
    }
    .receipt-actions {
        max-width: 340px;
        margin: 0 auto 30px;
        display: flex;
        gap: 10px;
    }
    .receipt-actions .btn { flex: 1; }

    #receipt-print {
        width: 76mm;
        padding: 8px 10px 14px;
        margin: 0 auto;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #000;
        background: #fff;
    }
    #receipt-print .store-name {
        text-align: center;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 2px;
    }
    #receipt-print .store-meta {
        text-align: center;
        font-size: 11px;
        line-height: 1.4;
        margin-bottom: 6px;
    }
    #receipt-print .divider {
        border-top: 1px dashed #000;
        margin: 6px 0;
    }
    #receipt-print .meta-row {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        margin-bottom: 2px;
        gap: 6px;
    }
    #receipt-print .meta-row span:first-child { flex-shrink: 0; }
    #receipt-print .meta-row span:last-child { text-align: right; }

    /* ===== Items — flexbox rows instead of <table>, far more reliable on thermal widths ===== */
    #receipt-print .items-header {
        display: flex;
        border-bottom: 1px dashed #000;
        padding-bottom: 3px;
        margin-top: 4px;
        font-weight: 700;
        font-size: 11px;
    }
    #receipt-print .items-header .col-name  { flex: 1 1 auto; }
    #receipt-print .items-header .col-qty   { flex: 0 0 24px; text-align: right; }
    #receipt-print .items-header .col-price { flex: 0 0 50px; text-align: right; }
    #receipt-print .items-header .col-total { flex: 0 0 55px; text-align: right; }

    #receipt-print .item-row {
        display: flex;
        font-size: 11px;
        padding: 4px 0 2px;
        align-items: flex-start;
    }
    #receipt-print .item-row .col-name  { flex: 1 1 auto; padding-right: 4px; min-width: 0; }
    #receipt-print .item-row .col-qty   { flex: 0 0 24px; text-align: right; }
    #receipt-print .item-row .col-price { flex: 0 0 50px; text-align: right; }
    #receipt-print .item-row .col-total { flex: 0 0 55px; text-align: right; }

    #receipt-print .item-name {
        font-weight: 700;
        word-break: break-word;
        line-height: 1.3;
    }
    #receipt-print .item-sub {
        font-size: 10px;
        color: #333;
        margin-top: 1px;
    }
    #receipt-print .item-discount-row {
        display: flex;
        justify-content: flex-end;
        gap: 6px;
        font-size: 10px;
        color: #333;
        padding-bottom: 3px;
    }

    #receipt-print .totals-row {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        padding: 2px 0;
        gap: 6px;
    }
    #receipt-print .grand-total {
        font-size: 15px;
        font-weight: 700;
        border-top: 1px dashed #000;
        border-bottom: 1px dashed #000;
        padding: 5px 0;
        margin: 4px 0;
    }
    #receipt-print .footer-note {
        text-align: center;
        font-size: 11px;
        margin-top: 8px;
        line-height: 1.5;
    }
    #receipt-print .barcode-area {
        text-align: center;
        margin-top: 10px;
        min-height: 50px; /* reserves space so layout doesn't jump if barcode is slow to render */
    }
    #receipt-print .barcode-area svg {
        max-width: 100%;
    }
    #receipt-print .barcode-fallback {
        font-size: 10px;
        color: #999;
        display: none;
    }
    #receipt-print .invoice-no-text {
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-top: 2px;
    }
    #receipt-print .badge-status {
        display: inline-block;
        font-size: 10px;
        padding: 1px 6px;
        border: 1px solid #000;
        border-radius: 3px;
    }

    @media print {
        @page { size: 80mm auto; margin: 0; }
        body * { visibility: hidden; }
        #receipt-print, #receipt-print * { visibility: visible; }
        #receipt-print {
            position: absolute;
            top: 0;
            left: 0;
            width: 80mm;
            padding: 4mm 3mm;
        }
        .no-print { display: none !important; }
    }
</style>

<div class="page-wrapper">
    <div class="content">

        <div class="receipt-actions no-print">
            <button onclick="window.print()" class="btn btn-primary" id="print-btn">
                <img src="{{ asset('backend/assets/img/icons/printer.svg') }}" alt="" style="width:16px;filter:brightness(0) invert(1);" class="me-1">
                Print Receipt
            </button>
            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-outline-secondary">Back to Sale</a>
        </div>

        <div class="receipt-wrapper">
            <div id="receipt-print">

                <div class="store-name">{{ config('pos.store_name', 'RAZA MALL') }}</div>
                <div class="store-meta">
                    {{ config('pos.store_address', 'Main Bazaar, Gojra, Punjab') }}<br>
                    Ph: {{ config('pos.store_phone', '0300-0000000') }}
                </div>

                <div class="divider"></div>

                <div class="meta-row"><span>Invoice #:</span><strong>{{ $sale->invoice_no }}</strong></div>
                <div class="meta-row"><span>Date:</span><span>{{ $sale->created_at->format('d-M-Y h:i A') }}</span></div>
                <div class="meta-row"><span>Cashier:</span><span>{{ $sale->creator->name ?? 'N/A' }}</span></div>
                <div class="meta-row"><span>Customer:</span><span>{{ $sale->customer->name ?? 'Walk-in Customer' }}</span></div>
                @if ($sale->customer?->phone)
                    <div class="meta-row"><span>Phone:</span><span>{{ $sale->customer->phone }}</span></div>
                @endif
                <div class="meta-row"><span>Status:</span><span class="badge-status">{{ ucfirst($sale->status) }}</span></div>

                <div class="divider"></div>

                {{-- ===================== ITEMS — flexbox grid, not <table> ===================== --}}
                <div class="items-header">
                    <div class="col-name">Item</div>
                    <div class="col-qty">Qty</div>
                    <div class="col-price">Price</div>
                    <div class="col-total">Total</div>
                </div>

                @foreach ($sale->items as $item)
                    <div class="item-row">
                        <div class="col-name">
                            <div class="item-name">{{ $item->product_name }}</div>
                            <div class="item-sub">{{ $item->product_sku }}</div>
                        </div>
                        <div class="col-qty">{{ $item->quantity }}</div>
                        <div class="col-price">{{ number_format($item->selling_price, 2) }}</div>
                        <div class="col-total">{{ number_format($item->total, 2) }}</div>
                    </div>
                    @if ($item->discount > 0)
                        <div class="item-discount-row">
                            <span>Item discount: -{{ number_format($item->discount, 2) }}</span>
                        </div>
                    @endif
                @endforeach

                <div class="divider"></div>

                <div class="totals-row"><span>Items:</span><span>{{ $sale->items->sum('quantity') }}</span></div>
                <div class="totals-row"><span>Subtotal:</span><span>Rs. {{ number_format($sale->subtotal, 2) }}</span></div>
                @if ($sale->discount > 0)
                    <div class="totals-row"><span>Discount:</span><span>- Rs. {{ number_format($sale->discount, 2) }}</span></div>
                @endif
                @if ($sale->tax > 0)
                    <div class="totals-row"><span>Tax:</span><span>Rs. {{ number_format($sale->tax, 2) }}</span></div>
                @endif

                <div class="grand-total totals-row">
                    <span>GRAND TOTAL:</span>
                    <span>Rs. {{ number_format($sale->grand_total, 2) }}</span>
                </div>

                <div class="totals-row">
                    <span>Paid ({{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}):</span>
                    <span>Rs. {{ number_format($sale->paid_amount, 2) }}</span>
                </div>

                @if ($sale->payment_reference)
                    <div class="totals-row"><span>Ref No:</span><span>{{ $sale->payment_reference }}</span></div>
                @endif

                @if ($sale->change > 0)
                    <div class="totals-row"><span>Change Returned:</span><span>Rs. {{ number_format($sale->change, 2) }}</span></div>
                @elseif ($sale->due_amount > 0)
                    <div class="totals-row"><strong>Balance Due:</strong><strong>Rs. {{ number_format($sale->due_amount, 2) }}</strong></div>
                @endif

                <div class="divider"></div>

                {{-- ===================== BARCODE ===================== --}}
                <div class="barcode-area" id="barcode-area">
                    <svg id="invoice-barcode"></svg>
                    <div class="barcode-fallback" id="barcode-fallback">[ {{ $sale->invoice_no }} ]</div>
                </div>
                <div class="invoice-no-text">{{ $sale->invoice_no }}</div>

                <div class="footer-note">
                    Thank you for shopping with us!<br>
                    Goods once sold can be returned/exchanged<br>
                    within 7 days with this receipt.<br>
                    <strong>Scan barcode above for returns.</strong>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/JsBarcode/3.11.5/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let barcodeRendered = false;

        function renderBarcode() {
            if (typeof JsBarcode === 'undefined') return false;
            try {
                JsBarcode("#invoice-barcode", "{{ $sale->invoice_no }}", {
                    format: "CODE128",
                    width: 1.6,
                    height: 40,
                    displayValue: false,
                    margin: 0,
                });
                barcodeRendered = true;
                return true;
            } catch (e) {
                return false;
            }
        }

        // Try immediately; if the CDN script hasn't finished loading yet, retry briefly.
        if (!renderBarcode()) {
            let attempts = 0;
            const retry = setInterval(() => {
                attempts++;
                if (renderBarcode() || attempts > 10) {
                    clearInterval(retry);
                    if (!barcodeRendered) {
                        // CDN failed entirely (e.g. no internet) — show text fallback
                        // so the invoice number is still visible and the layout doesn't show a blank gap.
                        document.getElementById('barcode-fallback').style.display = 'block';
                    }
                }
            }, 200);
        }

        // Guard against printing before the barcode has actually rendered.
        document.getElementById('print-btn').addEventListener('click', function (e) {
            if (!barcodeRendered && typeof JsBarcode !== 'undefined') {
                e.preventDefault();
                setTimeout(() => window.print(), 300);
            }
        });
    });
</script>
@endsection