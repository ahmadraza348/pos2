@extends('backend.layouts.layout')
@section('title', 'Stock Movement Report')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Stock Movement Report</h4></div></div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-lg-3"><input type="date" name="from" class="form-control" value="{{ $from }}"></div>
                    <div class="col-lg-3"><input type="date" name="to" class="form-control" value="{{ $to }}"></div>
                    <div class="col-lg-2"><button type="submit" class="btn btn-primary w-100">Apply</button></div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>SKU</th><th>Product</th>
                                <th>Purchased In</th><th>Returned In</th><th>Sold Out</th>
                                <th>Net Change</th><th>Current Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movement as $row)
                                <tr>
                                    <td>{{ $row['product']->sku }}</td>
                                    <td>{{ $row['product']->name }}</td>
                                    <td class="text-success">+{{ $row['purchased_in'] }}</td>
                                    <td class="text-success">+{{ $row['returned_in'] }}</td>
                                    <td class="text-danger">-{{ $row['sold_out'] }}</td>
                                    <td class="{{ $row['net_change'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $row['net_change'] >= 0 ? '+' : '' }}{{ $row['net_change'] }}
                                    </td>
                                    <td>{{ $row['current_stock'] }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">No stock movement in this range.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection