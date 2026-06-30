@extends('backend.layouts.layout')
@section('title', 'Inventory Report')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Inventory Valuation Report</h4></div>
            <div class="page-btn">
                <a href="{{ route('reports.stock-movement') }}" class="btn btn-outline-secondary">Stock Movement Report</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="dash-widget"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($valuation['total_cost_value'], 2) }}</h5><h6>Stock Value (at cost)</h6>
                </div></div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="dash-widget dash1"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($valuation['total_retail_value'], 2) }}</h5><h6>Stock Value (at retail)</h6>
                </div></div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="dash-widget dash2"><div class="dash-widgetcontent">
                    <h5>Rs. {{ number_format($valuation['potential_profit'], 2) }}</h5><h6>Unrealized Profit on Shelf</h6>
                </div></div>
            </div>
        </div>

        <ul class="nav nav-tabs nav-tabs-solid nav-justified mt-3" id="invTabs">
            <li class="nav-item"><a class="nav-link active" href="#all-stock" data-bs-toggle="tab">All Stock</a></li>
            <li class="nav-item"><a class="nav-link" href="#low-stock" data-bs-toggle="tab">Low Stock ({{ $lowStock->count() }})</a></li>
            <li class="nav-item"><a class="nav-link" href="#out-stock" data-bs-toggle="tab">Out of Stock ({{ $outOfStock->count() }})</a></li>
            <li class="nav-item"><a class="nav-link" href="#dead-stock" data-bs-toggle="tab">Dead Stock ({{ $deadStock->count() }})</a></li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="all-stock">
                <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead><tr><th>SKU</th><th>Product</th><th>Category</th><th>Stock</th><th>Cost Value</th><th>Retail Value</th></tr></thead>
                            <tbody>
                                @forelse ($valuation['products'] as $p)
                                    <tr>
                                        <td>{{ $p->sku }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->category->name ?? 'N/A' }}</td>
                                        <td>{{ $p->stock }}</td>
                                        <td>Rs. {{ number_format($p->stock * $p->cost_price, 2) }}</td>
                                        <td>Rs. {{ number_format($p->stock * $p->selling_price, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">No products.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div></div>
            </div>

            <div class="tab-pane fade" id="low-stock">
                <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead><tr><th>SKU</th><th>Product</th><th>Stock</th><th>Min. Stock</th></tr></thead>
                            <tbody>
                                @forelse ($lowStock as $p)
                                    <tr class="table-warning">
                                        <td>{{ $p->sku }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->stock }}</td>
                                        <td>{{ $p->minimum_stock }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No low stock items.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div></div>
            </div>

            <div class="tab-pane fade" id="out-stock">
                <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead><tr><th>SKU</th><th>Product</th><th>Category</th></tr></thead>
                            <tbody>
                                @foreach ($outOfStock as $p)
                                    <tr class="table-danger">
                                        <td>{{ $p->sku }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->category->name ?? 'N/A' }}</td>
                                    </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                </div></div>
            </div>

            <div class="tab-pane fade" id="dead-stock">
                <div class="card"><div class="card-body">
                    <p class="text-muted">Products with stock but no sales in the last 60 days.</p>
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead><tr><th>SKU</th><th>Product</th><th>Stock</th><th>Tied-up Cost Value</th></tr></thead>
                            <tbody>
                                @foreach ($deadStock as $p)
                                    <tr>
                                        <td>{{ $p->sku }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->stock }}</td>
                                        <td>Rs. {{ number_format($p->stock * $p->cost_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div></div>
            </div>
        </div>
    </div>
</div>
@endsection