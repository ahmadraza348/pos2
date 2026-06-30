@extends('backend.layouts.layout')
@section('title', 'Supplier Reports')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Supplier Reports — Outstanding Dues</h4></div></div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Supplier</th><th>Phone</th><th>Total Due</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse ($withDue as $supplier)
                                <tr>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td class="text-danger">Rs. {{ number_format($supplier->total_due, 2) }}</td>
                                    <td><a href="{{ route('supplier.edit', $supplier->id) }}">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">No suppliers with outstanding due.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection