@extends('backend.layouts.layout')
@section('title', 'Expenses')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Expenses</h4></div>
            <div class="page-btn d-flex gap-2">
                <a href="{{ route('expense-reports.index') }}" class="btn btn-outline-secondary">Reports</a>
                <a href="{{ route('expenses.restore') }}" class="btn btn-outline-secondary">Trashed</a>
                <a href="{{ route('expenses.create') }}" class="btn btn-added">
                    <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img"> Add Expense
                </a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-lg-3">
                        <input type="text" name="search" class="form-control" placeholder="Expense no / title" value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <div class="col-lg-3">
                        <select name="category_id" class="form-control">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2"><input type="date" name="from" class="form-control" value="{{ $filters['from'] ?? '' }}"></div>
                    <div class="col-lg-2"><input type="date" name="to" class="form-control" value="{{ $filters['to'] ?? '' }}"></div>
                    <div class="col-lg-2"><button type="submit" class="btn btn-primary w-100">Filter</button></div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                               
                                <th>Date</th>
                                <th>Expense No</th><th>Title</th><th>Category</th><th>Amount</th><th>Method</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                       
                                    <td>{{ $expense->expense_date->format('d M Y') }}</td>
                                    <td>{{ $expense->expense_no }}</td>
                                    <td>{{ $expense->title }}</td>
                                    <td>{{ $expense->category->name ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format($expense->amount, 2) }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$expense->payment_method)) }}</span></td>
                                    <td>
                                        <a href="{{ route('expenses.edit', $expense->id) }}" class="me-2">
                                            <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                        </a>
                                        <form id="delexp-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                        <a onclick="if(confirm('Delete this expense?')) { document.getElementById('delexp-{{ $expense->id }}').submit(); } return false;">
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