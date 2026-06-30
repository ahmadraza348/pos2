@extends('backend.layouts.layout')
@section('title', 'Day-End Report')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Day-End / Cash Register Report</h4></div></div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-lg-3"><input type="date" name="date" class="form-control" value="{{ $date }}"></div>
                    <div class="col-lg-2"><button type="submit" class="btn btn-primary w-100">View</button></div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget"><div class="dash-widgetcontent">
                    <h5>{{ $report['invoice_count'] }}</h5><h6>Invoices Today</h6>
                </div></div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget dash1"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($report['total_sales'], 2) }}</h5><h6>Total Sales</h6>
                </div></div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget dash2"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($report['total_due'], 2) }}</h5><h6>Total Due</h6>
                </div></div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget dash3"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($report['expected_cash_in_drawer'], 2) }}</h5><h6>Expected Cash in Drawer</h6>
                </div></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">Sales by Payment Method</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <tr><td>Cash Sales</td><td class="text-end">Rs. {{ number_format($report['cash_sales'], 2) }}</td></tr>
                            <tr><td>Card Sales</td><td class="text-end">Rs. {{ number_format($report['card_sales'], 2) }}</td></tr>
                            <tr><td>Bank Transfer Sales</td><td class="text-end">Rs. {{ number_format($report['bank_sales'], 2) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">Cash Drawer Reconciliation</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <tr><td>Cash Sales</td><td class="text-end">Rs. {{ number_format($report['cash_sales'], 2) }}</td></tr>
                            <tr><td>(−) Cash Refunds</td><td class="text-end">Rs. {{ number_format($report['cash_refunds'], 2) }}</td></tr>
                            <tr><td>(−) Cash Expenses Paid Today</td><td class="text-end">Rs. {{ number_format($report['cash_expenses'], 2) }}</td></tr>
                            <tr class="fw-bold border-top"><td>= Expected Cash in Drawer</td><td class="text-end">Rs. {{ number_format($report['expected_cash_in_drawer'], 2) }}</td></tr>
                        </table>
                        <p class="text-muted mt-2 mb-0">Count the physical cash drawer and compare against this figure to reconcile the shift.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0"><h5 class="card-title mb-0">Breakdown by Cashier</h5></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Cashier</th><th>Invoices</th><th>Total Sales</th></tr></thead>
                    <tbody>
                        @forelse ($byCashier as $row)
                            <tr>
                                <td>{{ $row->creator->name ?? 'N/A' }}</td>
                                <td>{{ $row->count }}</td>
                                <td>Rs. {{ number_format($row->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">No sales recorded for this date.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection