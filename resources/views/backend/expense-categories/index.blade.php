@extends('backend.layouts.layout')
@section('title', 'Expense Categories')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Expense Categories</h4></div>
            <div class="page-btn">
                <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-category">
                    <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img"> Add Category
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Name</th><th>Expenses Count</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->expenses_count }}</td>
                                    <td>
                                        @if ($category->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="me-2 edit-category-btn"
                                           data-id="{{ $category->id }}"
                                           data-name="{{ $category->name }}"
                                           data-description="{{ $category->description }}"
                                           data-status="{{ $category->status }}"
                                           data-bs-toggle="modal" data-bs-target="#edit-category">
                                            <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                        </a>
                                        <form id="delcat-{{ $category->id }}" action="{{ route('expense-categories.destroy', $category->id) }}" method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                        <a onclick="if(confirm('Delete this category?')) { document.getElementById('delcat-{{ $category->id }}').submit(); } return false;">
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

{{-- Add Modal --}}
<div class="modal fade" id="add-category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Expense Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('expense-categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name*</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="edit-category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Expense Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="edit-category-form">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name*</label>
                        <input type="text" name="name" id="edit-name" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit-description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit-status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-category-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            document.getElementById('edit-category-form').action = `{{ url('admin/expense-categories') }}/${id}`;
            document.getElementById('edit-name').value = this.dataset.name;
            document.getElementById('edit-description').value = this.dataset.description || '';
            document.getElementById('edit-status').value = this.dataset.status;
        });
    });
});
</script>
@endsection