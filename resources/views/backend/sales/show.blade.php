{{-- backend/sales/show.blade.php --}}
@extends('backend.layouts.layout')
@section('title', 'Sale Details')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Sale: {{ $sale->invoice_no }}</h4></div>
            <div class="page-btn d-flex gap-2">
                <a href="{{ route('pos.receipt', $sale->id) }}" target="_blank" class="btn btn-outline-secondary">Print Receipt</a>
                @if ($sale->status === 'completed' && $sale->returns->isEmpty())
                    <form action="{{ route('sales.void', $sale->id) }}" method="POST" onsubmit="return confirm('Void this sale and restore stock?');">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-danger">Void Sale</button>
                    </form>
                @endif
                @if ($sale->status === 'completed')
                    <a href="{{ route('returns.create') }}" class="btn btn-warning">Process Return</a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <p>Date: {{ $sale->created_at->format('d M Y, h:i A') }}</p>
                <p>Customer: {{ $sale->customer->name ?? 'Walk-in Customer' }}</p>
                <p>Created by: {{ $sale->creator->name ?? 'N/A' }}</p>

                <table class="table">
                    <thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Discount</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach ($sale->items as $item)
                            <tr>
                                <td>{{ $item->product_name }} <small class="text-muted">({{ $item->product_sku }})</small></td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rs. {{ number_format($item->selling_price, 2) }}</td>
                                <td>Rs. {{ number_format($item->discount, 2) }}</td>
                                <td>Rs. {{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p>Subtotal: Rs. {{ number_format($sale->subtotal, 2) }}</p>
                <p>Discount: Rs. {{ number_format($sale->discount, 2) }}</p>
                <p>Tax: Rs. {{ number_format($sale->tax, 2) }}</p>
                <h5>Grand Total: Rs. {{ number_format($sale->grand_total, 2) }}</h5>
                <p>Paid: Rs. {{ number_format($sale->paid_amount, 2) }} via {{ ucfirst(str_replace('_',' ',$sale->payment_method)) }}</p>
                <p>Due: Rs. {{ number_format($sale->due_amount, 2) }}</p>

                @if ($sale->returns->isNotEmpty())
                    <hr><h6>Returns against this sale</h6>
                    <ul>
                        @foreach ($sale->returns as $ret)
                            <li>{{ $ret->return_no }} — Rs. {{ number_format($ret->refund_amount, 2) }} (<a href="{{ route('returns.show', $ret->id) }}">view</a>)</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection