@extends('backend.layouts.layout')
@section('title', 'Edit Expense')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Edit Expense</h4></div></div>

        <form method="POST" action="{{ route('expenses.update', $expense->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Title*</label>
                            <input type="text" name="title" required class="form-control" value="{{ old('title', $expense->title) }}">
                            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Category*</label>
                            <select name="expense_category_id" required class="form-control">
                                <option value="">Select</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('expense_category_id', $expense->expense_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('expense_category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Amount (Rs.)*</label>
                            <input type="number" step="0.01" name="amount" required class="form-control" value="{{ old('amount', $expense->amount) }}">
                            @error('amount') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Expense Date*</label>
                            <input type="date" name="expense_date" required class="form-control" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}">
                            @error('expense_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Payment Method*</label>
                            <select name="payment_method" required class="form-control">
                                @foreach (['cash'=>'Cash','card'=>'Card','bank_transfer'=>'Bank Transfer'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('payment_method', $expense->payment_method) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Payment Reference</label>
                            <input type="text" name="payment_reference" class="form-control" value="{{ old('payment_reference', $expense->payment_reference) }}">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Receipt/Attachment</label>
                            <input type="file" name="attachment" class="form-control">
                            @if ($expense->attachment)
                                <a href="{{ asset('storage/'.$expense->attachment) }}" target="_blank" class="d-block mt-1">View current attachment</a>
                            @endif
                            @error('attachment') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description', $expense->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update Expense</button>
        </form>
    </div>
</div>
@endsection