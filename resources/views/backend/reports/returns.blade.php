@extends('backend.layouts.layout')
@section('title', 'Returns Report')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Returns Report</h4></div></div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-lg-3"><input type="date" name="from" class="form-control" value="{{ $from }}"></div>
                    <div class="col-lg-3"><input type="date" name="to" class="form-control" value="{{ $to }}"></div>
                    <div class="col-lg-2"><button type="submit" class="btn btn-primary w-100">Apply</button></div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="dash-widget"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($summary['total_refunded'], 2) }}</h5><h6>Total Refunded</h6>
                </div></div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="dash-widget dash1"><div class="dash-widgetcontent">
                    <h5>{{ $summary['return_count'] }}</h5><h6>Return Transactions</h6>
                </div></div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header pb-0"><h5 class="card-title mb-0">By Reason</h5></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Reason</th><th>Count</th><th>Total Refunded</th></tr></thead>
                    <tbody>
                        @foreach ($byReason as $row)
                            <tr>
                                <td>{{ $row->reason }}</td>
                                <td>{{ $row->count }}</td>
                                <td>Rs. {{ number_format($row->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0"><h5 class="card-title mb-0">Detailed Returns</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Date</th><th>Return No</th><th>Sale Invoice</th><th>Customer</th><th>Refund</th></tr></thead>
                        <tbody>
                            @foreach ($returns as $ret)
                                <tr>
                                    <td>{{ $ret->created_at->format('d M Y, h:i A') }}</td>
                                    <td><a href="{{ route('returns.show', $ret->id) }}">{{ $ret->return_no }}</a></td>
                                    <td>{{ $ret->sale->invoice_no ?? 'N/A' }}</td>
                                    <td>{{ $ret->customer->name ?? 'Walk-in' }}</td>
                                    <td>Rs. {{ number_format($ret->refund_amount, 2) }}</td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $returns->links() }}
            </div>
        </div>
    </div>
</div>
@endsection