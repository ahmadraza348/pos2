@extends('backend.layouts.layout')
@section('title', 'All Purchases')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Purchases</h4>
            </div>
            <div class="page-btn d-flex gap-2">
                <a href="{{ route('purchase.restorePurchase') }}" class="btn btn-outline-secondary">Trashed Purchases</a>
                <a href="{{ route('purchase.create') }}" class="btn btn-added">
                    <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img"> Add Purchase
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Supplier</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $item)
                                <tr>
                                    <td>{{ $item->invoice_no }}</td>
                                    <td>{{ $item->supplier->name ?? 'N/A' }}</td>
                                    <td>{{ $item->purchase_date->format('d M, Y') }}</td>
                                    <td>{{ number_format($item->total_amount, 2) }}</td>
                                    <td>{{ number_format($item->paid_amount, 2) }}</td>
                                    <td>{{ number_format($item->due_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $paymentColors = ['unpaid' => 'danger', 'partial' => 'warning', 'paid' => 'success'];
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $paymentColors[$item->payment_status] ?? 'secondary' }}">
                                            {{ ucfirst($item->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = ['pending' => 'warning', 'received' => 'success', 'cancelled' => 'danger'];
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $statusColors[$item->status] ?? 'secondary' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('purchase.edit', $item->id) }}" class="me-3">
                                            <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                        </a>

                                        <form id="deletepur-{{ $item->id }}"
                                            action="{{ route('purchase.destroy', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('delete')
                                        </form>

                                        <a onclick="if(confirm('Are you sure to delete this purchase? Stock changes will be reversed.')) { document.getElementById('deletepur-{{ $item->id }}').submit(); } return false;">
                                            <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection