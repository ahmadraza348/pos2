{{-- backend/returns/index.blade.php --}}
@extends('backend.layouts.layout')
@section('title', 'Returns')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Returns</h4></div>
            <div class="page-btn">
                <a href="{{ route('returns.create') }}" class="btn btn-added">
                    <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img"> New Return
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr><th>Date</th><th>Return No</th><th>Sale Invoice</th><th>Customer</th><th>Refund</th><th>Method</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($returns as $return)
                                <tr>
                                    <td>{{ $return->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $return->return_no }}</td>
                                    <td>{{ $return->sale->invoice_no ?? 'N/A' }}</td>
                                    <td>{{ $return->customer->name ?? 'Walk-in' }}</td>
                                    <td>Rs. {{ number_format($return->refund_amount, 2) }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ', $return->refund_method)) }}</span></td>
                                    <td><a href="{{ route('returns.show', $return->id) }}">
                                        <img src="{{ asset('backend/assets/img/icons/eye.svg') }}" alt="view"></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">No returns recorded yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection