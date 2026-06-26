@extends('backend.layouts.layout')
@section('title', 'Expense Reports')
@section('content')
<script>
    window.EXPENSE_REPORT_CONFIG = {
        trendDataUrl: "{{ route('expense-reports.trend-data') }}",
        initialTrend: @json($trend),
    };
</script>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Expense Reports &amp; Analytics</h4></div></div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-lg-3"><input type="date" name="from" class="form-control" value="{{ $summary['from'] }}"></div>
                    <div class="col-lg-3"><input type="date" name="to" class="form-control" value="{{ $summary['to'] }}"></div>
                    <div class="col-lg-2"><button type="submit" class="btn btn-primary w-100">Apply</button></div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="dash-widget">
                    <div class="dash-widgetcontent">
                        <h5>Rs. {{ number_format($summary['total_expense'], 2) }}</h5>
                        <h6>Total Expenses (selected range)</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dash-widget dash1">
                    <div class="dash-widgetcontent">
                        <h5>Rs. {{ number_format($summary['total_sales'], 2) }}</h5>
                        <h6>Total Sales (selected range)</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dash-widget dash2">
                    <div class="dash-widgetcontent">
                        <h5>Rs. {{ number_format($summary['net_after_expense'], 2) }}</h5>
                        <h6>Net (Sales − Expenses)</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Monthly Expense Trend</h5>
                        <div class="dropdown">
                            <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="year-btn" data-bs-toggle="dropdown">
                                {{ $selectedYear }}
                            </button>
                            <ul class="dropdown-menu">
                                @for ($y = now()->year; $y >= now()->year - 4; $y--)
                                    <li><a href="javascript:void(0);" class="dropdown-item year-option" data-year="{{ $y }}">{{ $y }}</a></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="card-body"><div id="expense_trend_chart"></div></div>
                </div>
            </div>

            <div class="col-lg-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0"><h5 class="card-title mb-0">Top Categories</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <thead><tr><th>Category</th><th>Count</th><th>Total</th></tr></thead>
                            <tbody>
                                @forelse ($topCategories as $row)
                                    <tr>
                                        <td>{{ $row->category->name ?? 'Uncategorized' }}</td>
                                        <td>{{ $row->count }}</td>
                                        <td>Rs. {{ number_format($row->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No data for this range.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0"><h5 class="card-title mb-0">Breakdown by Payment Method</h5></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Method</th><th>Total</th></tr></thead>
                    <tbody>
                        @forelse ($summary['by_payment_method'] as $method => $total)
                            <tr><td>{{ ucfirst(str_replace('_',' ',$method)) }}</td><td>Rs. {{ number_format($total, 2) }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted">No data for this range.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cfg = window.EXPENSE_REPORT_CONFIG;
    let chart;

    function renderTrend(trend) {
        if (typeof ApexCharts === 'undefined') {
            document.getElementById('expense_trend_chart').innerHTML = '<p class="text-muted text-center py-4">Chart library not loaded.</p>';
            return;
        }
        const options = {
            chart: { type: 'line', height: 300, toolbar: { show: false } },
            series: [{ name: 'Expenses', data: trend.data }],
            xaxis: { categories: trend.labels },
            colors: ['#dc3545'],
            stroke: { curve: 'smooth', width: 3 },
            yaxis: { labels: { formatter: v => 'Rs. ' + v.toLocaleString() } },
            tooltip: { y: { formatter: v => 'Rs. ' + v.toLocaleString() } },
        };
        if (chart) { chart.updateOptions(options); } else {
            chart = new ApexCharts(document.getElementById('expense_trend_chart'), options);
            chart.render();
        }
    }

    renderTrend(cfg.initialTrend);

    document.querySelectorAll('.year-option').forEach(el => {
        el.addEventListener('click', function () {
            const year = this.dataset.year;
            document.getElementById('year-btn').textContent = year;
            fetch(`${cfg.trendDataUrl}?year=${year}`)
                .then(r => r.json())
                .then(res => { if (res.success) renderTrend(res.trend); });
        });
    });
});
</script>
@endsection