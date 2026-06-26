@extends('backend.layouts.layout')
@section('title', 'Trashed Expenses')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Trashed Expenses</h4></div></div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Date</th><th>Expense No</th><th>Title</th><th>Amount</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_date->format('d M Y') }}</td>
                                    <td>{{ $expense->expense_no }}</td>
                                    <td>{{ $expense->title }}</td>
                                    <td>Rs. {{ number_format($expense->amount, 2) }}</td>
                                    <td class="d-flex gap-2">
                                        <form action="{{ route('expenses.restore.action', $expense->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                        </form>
                                        <form id="delexp-{{ $expense->id }}" action="{{ route('expenses.forceDelete', $expense->id) }}" method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                        <a onclick="if(confirm('Permanently delete this expense?')) { document.getElementById('delexp-{{ $expense->id }}').submit(); } return false;" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">No trashed expenses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection