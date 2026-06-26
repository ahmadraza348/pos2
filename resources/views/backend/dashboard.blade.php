@extends('backend.layouts.layout')
@section('title', 'Dashboard')
@section('content')

<script>
    window.DASHBOARD_CONFIG = {
        chartDataUrl: "",
        initialChart: @json($dashboardData['chart']),
    };
</script>

<div class="page-wrapper">
    <div class="content">

        {{-- ===================== TOP SUMMARY CARDS ===================== --}}
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('backend/assets/img/icons/dash1.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>Rs. {{ number_format($dashboardData['cards']['total_purchase_due'], 2) }}</h5>
                        <h6>Total Purchase Due</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('backend/assets/img/icons/dash2.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>Rs. {{ number_format($dashboardData['cards']['total_sales_due'], 2) }}</h5>
                        <h6>Total Sales Due</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('backend/assets/img/icons/dash3.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>Rs. {{ number_format($dashboardData['cards']['total_sale_amount'], 2) }}</h5>
                        <h6>Total Sale Amount</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('backend/assets/img/icons/dash4.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>Rs. {{ number_format($dashboardData['cards']['gross_profit'], 2) }}</h5>
                        <h6>Gross Profit</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== TODAY HIGHLIGHT + ENTITY COUNTS ===================== --}}
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>Rs. {{ number_format($dashboardData['cards']['today_sales'], 2) }}</h4>
                        <h5>Today's Sales</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="trending-up"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4>{{ $dashboardData['counts']['customers'] }}</h4>
                        <h5>Customers</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="user"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4>{{ $dashboardData['counts']['suppliers'] }}</h4>
                        <h5>Suppliers</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="user-check"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <h4>{{ $dashboardData['counts']['sales_invoices'] }}</h4>
                        <h5>Sales Invoices</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="file"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>{{ $dashboardData['counts']['purchase_invoices'] }}</h4>
                        <h5>Purchase Invoices</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="file-text"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4>{{ $dashboardData['counts']['products'] }}</h4>
                        <h5>Total Products</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="box"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4>{{ $dashboardData['counts']['held_orders'] }}</h4>
                        <h5>Held Orders</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="pause-circle"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <h4>{{ $dashboardData['low_stock_products']->count() }}</h4>
                        <h5>Low Stock Alerts</h5>
                    </div>
                    <div class="dash-imgs"><i data-feather="alert-triangle"></i></div>
                </div>
            </div>
        </div>

        {{-- ===================== CHART + RECENTLY ADDED PRODUCTS ===================== --}}
        <div class="row">
            <div class="col-lg-7 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Purchase &amp; Sales</h5>
                        <div class="graph-sets">
                            <ul>
                                <li><span style="color:#0d6efd;">&#9632;</span> Sales</li>
                                <li><span style="color:#fd7e14;">&#9632;</span> Purchase</li>
                            </ul>
                            <div class="dropdown">
                                <button class="btn btn-white btn-sm dropdown-toggle" type="button"
                                    id="year-dropdown-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $dashboardData['selected_year'] }}
                                    <img src="{{ asset('backend/assets/img/icons/dropdown.svg') }}" alt="img" class="ms-2">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="year-dropdown-btn">
                                    @foreach ($dashboardData['available_years'] as $yr)
                                        <li><a href="javascript:void(0);" class="dropdown-item year-option" data-year="{{ $yr }}">{{ $yr }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="sales_purchase_chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Recently Added Products</h4>
                        <a href="{{ route('product.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dataview">
                            <table class="table">
                                <thead>
                                    <tr><th>Sno</th><th>Product</th><th>Price</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($dashboardData['recently_added'] as $i => $product)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="productimgname">
                                                <a href="{{ route('product.edit', $product->id) }}" class="product-img">
                                                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('backend/assets/img/noimage.png') }}" alt="product">
                                                </a>
                                                <a href="{{ route('product.edit', $product->id) }}">{{ $product->name }}</a>
                                            </td>
                                            <td>Rs. {{ number_format($product->selling_price, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted">No products yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== LOW STOCK + RECENT SALES ===================== --}}
        <div class="row">
            <div class="col-lg-7 col-sm-12 col-12 d-flex">
                <div class="card flex-fill mb-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="card-title mb-0">Low Stock Products</h4>
                            <a href="{{ route('product.index') }}" class="btn btn-sm btn-outline-warning">Manage Stock</a>
                        </div>
                        <div class="table-responsive dataview">
                            <table class="table">
                                <thead>
                                    <tr><th>SNo</th><th>SKU</th><th>Product</th><th>Category</th><th>Stock</th><th>Min. Stock</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($dashboardData['low_stock_products'] as $i => $product)
                                        <tr class="{{ $product->stock <= 0 ? 'table-danger' : 'table-warning' }}">
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ $product->minimum_stock }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center text-muted">All products are sufficiently stocked.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-sm-12 col-12 d-flex">
                <div class="card flex-fill mb-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="card-title mb-0">Recent Sales</h4>
                            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                        </div>
                        <div class="table-responsive dataview">
                            <table class="table">
                                <thead>
                                    <tr><th>Invoice</th><th>Customer</th><th>Total</th><th>Status</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($dashboardData['recent_sales'] as $sale)
                                        @php
                                            $payColors = ['unpaid'=>'danger','partial'=>'warning','paid'=>'success'];
                                        @endphp
                                        <tr>
                                            <td><a href="{{ route('sales.show', $sale->id) }}">{{ $sale->invoice_no }}</a></td>
                                            <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                            <td>Rs. {{ number_format($sale->grand_total, 2) }}</td>
                                            <td><span class="badge bg-{{ $payColors[$sale->payment_status] ?? 'secondary' }}">{{ ucfirst($sale->payment_status) }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted">No sales yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cfg = window.DASHBOARD_CONFIG;
    let chart;

    function renderChart(data) {
        const options = {
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            series: [
                { name: 'Sales', data: data.sales },
                { name: 'Purchase', data: data.purchases },
            ],
            xaxis: { categories: data.labels },
            colors: ['#0d6efd', '#fd7e14'],
            plotOptions: { bar: { columnWidth: '45%', borderRadius: 4 } },
            dataLabels: { enabled: false },
            legend: { show: false },
            yaxis: {
                labels: {
                    formatter: function (val) { return 'Rs. ' + val.toLocaleString(); }
                }
            },
            tooltip: {
                y: { formatter: function (val) { return 'Rs. ' + val.toLocaleString(); } }
            },
        };

        if (typeof ApexCharts === 'undefined') {
            document.getElementById('sales_purchase_chart').innerHTML =
                '<p class="text-muted text-center py-4">Chart library not loaded. Include ApexCharts in your layout to enable this graph.</p>';
            return;
        }

        if (chart) {
            chart.updateOptions(options);
        } else {
            chart = new ApexCharts(document.getElementById('sales_purchase_chart'), options);
            chart.render();
        }
    }

    renderChart(cfg.initialChart);

    document.querySelectorAll('.year-option').forEach(el => {
        el.addEventListener('click', function () {
            const year = this.dataset.year;
            document.getElementById('year-dropdown-btn').innerHTML =
                year + ' <img src="{{ asset('backend/assets/img/icons/dropdown.svg') }}" alt="img" class="ms-2">';

            fetch(`${cfg.chartDataUrl}?year=${year}`)
                .then(r => r.json())
                .then(res => {
                    if (res.success) renderChart(res.chart);
                });
        });
    });
});
</script>
@endsection