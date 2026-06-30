{{-- backend/held-orders/index.blade.php --}}
@extends('backend.layouts.layout')
@section('title', 'Held Orders')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Held Orders</h4></div></div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Date</th><th>Invoice</th><th>Customer</th><th>Items</th><th>Total</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $order->invoice_no }}</td>
                                    <td>{{ $order->customer->name ?? 'Walk-in' }}</td>
                                    <td>{{ $order->items->count() }}</td>
                                    <td>Rs. {{ number_format($order->grand_total, 2) }}</td>
                                    <td>
                                        <a href="{{ route('held-orders.resume', $order->id) }}" class="btn btn-sm btn-success">Resume</a>
                                        <form action="{{ route('held-orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this held order?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection