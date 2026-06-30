@extends('backend.layouts.layout')
@section('title', 'Sales Report')
@section('content')
<script>
    window.SALES_REPORT_CONFIG = { trend: @json($trend) };
</script>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Sales Report</h4></div></div>

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
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($summary['total_sales'], 2) }}</h5><h6>Total Sales</h6>
                </div></div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget dash1"><div class="dash-widgetcontent">
                    <h5>{{ $summary['invoice_count'] }}</h5><h6>Invoices</h6>
                </div></div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget dash2"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($summary['avg_invoice_value'], 2) }}</h5><h6>Avg. Invoice Value</h6>
                </div></div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="dash-widget dash3"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($summary['total_due'], 2) }}</h5><h6>Total Due</h6>
                </div></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">Daily Sales Trend</h5></div>
                    <div class="card-body"><div id="sales_trend_chart"></div></div>
                </div>
            </div>
            <div class="col-lg-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">By Payment Method</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <thead><tr><th>Method</th><th>Invoices</th><th>Total</th></tr></thead>
                            <tbody>
                                @forelse ($byPaymentMethod as $row)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_',' ',$row->payment_method)) }}</td>
                                        <td>{{ $row->count }}</td>
                                        <td>Rs. {{ number_format($row->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">Top Customers</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <thead><tr><th>Customer</th><th>Invoices</th><th>Total</th></tr></thead>
                            <tbody>
                                @forelse ($topCustomers as $row)
                                    <tr>
                                        <td>{{ $row->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $row->count }}</td>
                                        <td>Rs. {{ number_format($row->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">Top Selling Products</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <thead><tr><th>Product</th><th>Qty Sold</th><th>Revenue</th></tr></thead>
                            <tbody>
                                @forelse ($topProducts as $row)
                                    <tr>
                                        <td>{{ $row->product_name }} <small class="text-muted">({{ $row->product_sku }})</small></td>
                                        <td>{{ $row->qty_sold }}</td>
                                        <td>Rs. {{ number_format($row->revenue, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0"><h5 class="card-title mb-0">Detailed Sales</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Date</th><th>Invoice</th><th>Customer</th><th>Cashier</th><th>Total</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->created_at->format('d M Y, h:i A') }}</td>
                                    <td><a href="{{ route('sales.show', $sale->id) }}">{{ $sale->invoice_no }}</a></td>
                                    <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                    <td>{{ $sale->creator->name ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format($sale->grand_total, 2) }}</td>
                                    <td><span class="badge bg-success">{{ ucfirst($sale->payment_status) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No sales found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined') return;
    const trend = window.SALES_REPORT_CONFIG.trend;

    new ApexCharts(document.getElementById('sales_trend_chart'), {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Sales', data: trend.map(t => t.total) }],
        xaxis: { categories: trend.map(t => t.date) },
        colors: ['#0d6efd'],
        stroke: { curve: 'smooth', width: 2 },
        yaxis: { labels: { formatter: v => 'Rs. ' + v.toLocaleString() } },
        tooltip: { y: { formatter: v => 'Rs. ' + v.toLocaleString() } },
    }).render();
});
</script>
@endsection