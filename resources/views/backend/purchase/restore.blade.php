@extends('backend.layouts.layout')
@section('title', 'Trashed Purchases')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Trashed Purchases</h4>
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
                                    <td>
                                        @php
                                            $statusColors = ['pending' => 'warning', 'received' => 'success', 'cancelled' => 'danger'];
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $statusColors[$item->status] ?? 'secondary' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-2">
                                        <form action="{{ route('purchase.restore', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                        </form>

                                        <form id="deletepur-{{ $item->id }}"
                                            action="{{ route('purchase.forceDelete', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('delete')
                                        </form>

                                        <a onclick="if(confirm('Permanently delete this purchase?')) { document.getElementById('deletepur-{{ $item->id }}').submit(); } return false;"
                                            class="btn btn-sm btn-danger">
                                            Delete
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