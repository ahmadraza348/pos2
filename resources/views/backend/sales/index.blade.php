{{-- backend/sales/index.blade.php --}}
@extends('backend.layouts.layout')
@section('title', 'Sales History')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Sales History</h4></div></div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-lg-2"><input type="text" name="search" class="form-control" placeholder="Invoice no" value="{{ $filters['search'] ?? '' }}"></div>
                    <div class="col-lg-2">
                        <select name="status" class="form-control">
                            <option value="">Any status</option>
                            @foreach (['completed','held','cancelled','refunded'] as $s)
                                <option value="{{ $s }}" {{ ($filters['status'] ?? '') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select name="payment_status" class="form-control">
                            <option value="">Any payment</option>
                            @foreach (['unpaid','partial','paid'] as $s)
                                <option value="{{ $s }}" {{ ($filters['payment_status'] ?? '') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2"><input type="date" name="from" class="form-control" value="{{ $filters['from'] ?? '' }}"></div>
                    <div class="col-lg-2"><input type="date" name="to" class="form-control" value="{{ $filters['to'] ?? '' }}"></div>
                    <div class="col-lg-2"><button type="submit" class="btn btn-primary w-100">Filter</button></div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Date</th><th>Invoice</th><th>Customer</th><th>Total</th><th>Paid</th><th>Payment</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                @php
                                    $statusColors = ['completed'=>'success','held'=>'warning','cancelled'=>'danger','refunded'=>'secondary'];
                                    $payColors = ['unpaid'=>'danger','partial'=>'warning','paid'=>'success'];
                                @endphp
                                <tr>
                                    <td>{{ $sale->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $sale->invoice_no }}</td>
                                    <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                    <td>Rs. {{ number_format($sale->grand_total, 2) }}</td>
                                    <td>Rs. {{ number_format($sale->paid_amount, 2) }}</td>
                                    <td><span class="badge bg-{{ $payColors[$sale->payment_status] ?? 'secondary' }}">{{ ucfirst($sale->payment_status) }}</span></td>
                                    <td><span class="badge bg-{{ $statusColors[$sale->status] ?? 'secondary' }}">{{ ucfirst($sale->status) }}</span></td>
                                    <td>
                                        <a href="{{ route('sales.show', $sale->id) }}" class="me-2"><img src="{{ asset('backend/assets/img/icons/eye.svg') }}" alt="view"></a>
                                        <a href="{{ route('pos.receipt', $sale->id) }}" target="_blank"><img src="{{ asset('backend/assets/img/icons/printer.svg') }}" alt="print"></a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted">No sales found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection