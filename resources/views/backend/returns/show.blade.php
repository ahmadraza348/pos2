{{-- backend/returns/show.blade.php --}}
@extends('backend.layouts.layout')
@section('title', 'Return Details')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="card" style="max-width:500px; margin:auto;">
            <div class="card-body">
                <h4 class="text-center">Return: {{ $saleReturn->return_no }}</h4>
                <p>Date: {{ $saleReturn->created_at->format('d M Y, h:i A') }}</p>
                <p>Original Invoice: {{ $saleReturn->sale->invoice_no }}</p>
                <p>Customer: {{ $saleReturn->customer->name ?? 'Walk-in Customer' }}</p>
                <hr>
                <table class="table">
                    <thead><tr><th>Item</th><th>Qty</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach ($saleReturn->items as $item)
                            <tr><td>{{ $item->product_name }}</td><td>{{ $item->quantity_returned }}</td><td>Rs. {{ number_format($item->total, 2) }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <h5>Refund Amount: Rs. {{ number_format($saleReturn->refund_amount, 2) }}</h5>
                <p>Method: {{ ucfirst(str_replace('_',' ', $saleReturn->refund_method)) }}</p>
                <p>Restocked: {{ $saleReturn->restocked ? 'Yes' : 'No' }}</p>
                @if ($saleReturn->reason)<p>Reason: {{ $saleReturn->reason }}</p>@endif
            </div>
            <button onclick="window.print()" class="btn btn-primary m-3">Print</button>
        </div>
    </div>
</div>
@endsection