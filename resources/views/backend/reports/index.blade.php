@extends('backend.layouts.layout')
@section('title', 'Reports')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Reports &amp; Analytics</h4></div></div>

        <div class="row">
            @php
                $reports = [
                    ['route' => 'reports.profit-loss', 'icon' => 'trending-up', 'title' => 'Profit & Loss', 'desc' => 'Revenue, COGS, expenses, net profit'],
                    ['route' => 'reports.sales', 'icon' => 'shopping-cart', 'title' => 'Sales Report', 'desc' => 'Trends, by customer, cashier, payment method'],
                    ['route' => 'reports.purchases', 'icon' => 'truck', 'title' => 'Purchase Report', 'desc' => 'Supplier spend, purchase trends'],
                    ['route' => 'reports.inventory', 'icon' => 'box', 'title' => 'Inventory Valuation', 'desc' => 'Stock value, low/out of stock, dead stock'],
                    ['route' => 'reports.stock-movement', 'icon' => 'repeat', 'title' => 'Stock Movement', 'desc' => 'In/out audit trail per product'],
                    ['route' => 'reports.day-end', 'icon' => 'dollar-sign', 'title' => 'Day-End / Cash Register', 'desc' => 'End of shift cash reconciliation'],
                    ['route' => 'reports.customers', 'icon' => 'users', 'title' => 'Customer Reports', 'desc' => 'Dues, top customers, lifetime value'],
                    ['route' => 'reports.suppliers', 'icon' => 'user-check', 'title' => 'Supplier Reports', 'desc' => 'Outstanding dues by supplier'],
                    ['route' => 'reports.returns', 'icon' => 'rotate-ccw', 'title' => 'Returns Report', 'desc' => 'Return rate, reasons, refund totals'],
                    ['route' => 'expense-reports.index', 'icon' => 'file-minus', 'title' => 'Expense Report', 'desc' => 'Category breakdown, monthly trend'],
                ];
            @endphp

            @foreach ($reports as $r)
                <div class="col-lg-4 col-sm-6 col-12 mb-3">
                    <a href="{{ route($r['route']) }}" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-start gap-3">
                                <div class="dash-imgs"><i data-feather="{{ $r['icon'] }}"></i></div>
                                <div>
                                    <h5 class="mb-1 text-dark">{{ $r['title'] }}</h5>
                                    <p class="text-muted mb-0">{{ $r['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection