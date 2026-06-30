@extends('backend.layouts.layout')
@section('title', 'Purchase Report')
@section('content')
<script>
    window.PURCHASE_REPORT_CONFIG = { trend: @json($trend) };
</script>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Purchase Report</h4></div></div>

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
                    <h5>Rs. {{ number_format($summary['total_purchase'], 2) }}</h5><h6>Total Purchases</h6>
                </div></div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="dash-widget dash1"><div class="dash-widgetcontent">
                    <h5>{{ $summary['invoice_count'] }}</h5><h6>Purchase Invoices</h6>
                </div></div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="dash-widget dash2"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($summary['total_due'], 2) }}</h5><h6>Total Due to Suppliers</h6>
                </div></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">Daily Purchase Trend</h5></div>
                    <div class="card-body"><div id="purchase_trend_chart"></div></div>
                </div>
            </div>
            <div class="col-lg-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">By Supplier</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <thead><tr><th>Supplier</th><th>Invoices</th><th>Total</th><th>Due</th></tr></thead>
                            <tbody>
                                @forelse ($bySupplier as $row)
                                    <tr>
                                        <td>{{ $row->supplier->name ?? 'N/A' }}</td>
                                        <td>{{ $row->count }}</td>
                                        <td>Rs. {{ number_format($row->total, 2) }}</td>
                                        <td>Rs. {{ number_format($row->due, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header pb-0"><h5 class="card-title mb-0">Most Purchased Products</h5></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Product</th><th>Qty Purchased</th><th>Total Cost</th></tr></thead>
                    <tbody>
                        @forelse ($mostPurchased as $row)
                            <tr>
                                <td>{{ $row->name }} <small class="text-muted">({{ $row->sku }})</small></td>
                                <td>{{ $row->qty_purchased }}</td>
                                <td>Rs. {{ number_format($row->total_cost, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">No data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0"><h5 class="card-title mb-0">Detailed Purchases</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Date</th><th>Invoice</th><th>Supplier</th><th>Total</th><th>Paid</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse ($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->purchase_date->format('d M Y') }}</td>
                                    <td><a href="{{ route('purchase.edit', $purchase->id) }}">{{ $purchase->invoice_no }}</a></td>
                                    <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format($purchase->total_amount, 2) }}</td>
                                    <td>Rs. {{ number_format($purchase->paid_amount, 2) }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($purchase->status) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No purchases found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined') return;
    const trend = window.PURCHASE_REPORT_CONFIG.trend;

    new ApexCharts(document.getElementById('purchase_trend_chart'), {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Purchases', data: trend.map(t => t.total) }],
        xaxis: { categories: trend.map(t => t.date) },
        colors: ['#fd7e14'],
        stroke: { curve: 'smooth', width: 2 },
        yaxis: { labels: { formatter: v => 'Rs. ' + v.toLocaleString() } },
        tooltip: { y: { formatter: v => 'Rs. ' + v.toLocaleString() } },
    }).render();
});
</script>
@endsection