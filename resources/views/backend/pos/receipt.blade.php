@extends('backend.layouts.layout')
@section('title', 'Receipt')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="card" style="max-width:400px; margin:auto;">
            <div class="card-body" id="receipt-area">
                <h4 class="text-center">Invoice: {{ $sale->invoice_no }}</h4>
                <p>Date: {{ $sale->created_at->format('d M Y, h:i A') }}</p>
                <p>Customer: {{ $sale->customer->name ?? 'Walk-in Customer' }}</p>
                <hr>
                <table class="table">
                    <thead><tr><th>Item</th><th>Qty</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach ($sale->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <p>Subtotal: {{ number_format($sale->subtotal, 2) }}</p>
                <p>Discount: {{ number_format($sale->discount, 2) }}</p>
                <p>Tax: {{ number_format($sale->tax, 2) }}</p>
                <h5>Grand Total: {{ number_format($sale->grand_total, 2) }}</h5>
                <p>Paid: {{ number_format($sale->paid_amount, 2) }} ({{ ucfirst($sale->payment_method) }})</p>
                <p>Due: {{ number_format($sale->due_amount, 2) }}</p>
            </div>
            <button onclick="window.print()" class="btn btn-primary m-3">Print</button>
        </div>
    </div>
</div>
@endsection