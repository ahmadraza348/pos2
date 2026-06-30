@extends('backend.layouts.layout')
@section('title', 'Customer Reports')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Customer Reports</h4></div></div>

        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
            <li class="nav-item"><a class="nav-link active" href="#with-due" data-bs-toggle="tab">Customers with Due ({{ $withDue->count() }})</a></li>
            <li class="nav-item"><a class="nav-link" href="#top-customers" data-bs-toggle="tab">Top Customers by Value</a></li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="with-due">
                <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead><tr><th>Customer</th><th>Phone</th><th>Total Due</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach ($withDue as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td class="text-danger">Rs. {{ number_format($customer->total_due, 2) }}</td>
                                        <td><a href="{{ route('customer.edit', $customer->id) }}">View</a></td>
                                    </tr>
                              
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div></div>
            </div>

            <div class="tab-pane fade" id="top-customers">
                <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead><tr><th>Customer</th><th>Phone</th><th>Lifetime Value</th></tr></thead>
                            <tbody>
                                @foreach ($topCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>Rs. {{ number_format($customer->lifetime_value ?? 0, 2) }}</td>
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