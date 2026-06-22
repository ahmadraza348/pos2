@extends('backend.layouts.layout')
@section('title', 'All Categories - Raza Mall')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage Categories</h4>
                    <h6>Manage your Product Categories</h6>
                </div>            
            </div>

            <form action="{{ route('category.import') }}" class="d-flex justify-content-end mb-3" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group d-flex" style="width:400px;">
                    <input type="file" name="categories_file" id="categories_file" class="form-control mx-2" required>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $editable_category ? 'Edit Category' : 'Add Category' }}</h5>
                            <hr>

                           <form method="POST"
                                action="{{ $editable_category ? route('category.update', $editable_category) : route('category.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if($editable_category)
                                    @method('PUT')
                                @endif

                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Name*</label>
                                    <input type="text" required name="name" id="name" class="form-control"
                                           value="{{ old('name', $editable_category->name ?? '') }}">
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="image">Image</label>
                                    <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                                    @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2 text-center">
                                        @if($editable_category && $editable_category->image)
                                            <img id="imagePreview" src="{{ asset('storage/' . $editable_category->image) }}" alt="Preview" style="max-width: 100%; max-height: 150px; border-radius: 8px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 100%; max-height: 150px; border-radius: 8px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status', $editable_category->status ?? '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $editable_category->status ?? '1') == '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="4">{{ old('description', $editable_category->description ?? '') }}</textarea>
                                    @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">{{ $editable_category ? 'Update' : 'Submit' }}</button>
                                    @if($editable_category)
                                        <a href="{{ route('category.index') }}" class="btn btn-light w-100">Cancel</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox" id="select-all" onclick="selectAll(this)">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th>Image</th>
                                            <th>Category</th>                  
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories_data as $category)
                                        <tr class="{{ $editable_category && $editable_category->id === $category->id ? 'table-primary' : '' }}">
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox" class="select-option" data-id="{{ $category->id }}" onchange="toggleDeleteButton()">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('backend/assets/img/noimage.png') }}"
                                                     alt="category image" style="width:50px; height:50px; object-fit: cover; border-radius:50px;">
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <span class="badge rounded-pill {{ $category->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $category->status == '1' ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('category.edit', $category->id) }}" class="me-3">
                                                    <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                                </a>

                                                <a href="#" onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteCat-{{ $category->id }}').submit(); } return false;">
                                                    <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                                </a>
                                                <form id="deleteCat-{{ $category->id }}" action="{{ route('category.destroy', $category->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button id="delete-selected-btn" class="btn btn-danger mt-3" style="display: none;" onclick="deleteSelectedOptions()">
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <form id="bulk-delete-form" action="{{ route('category.bulk-delete') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="category_ids" id="option-ids">
            </form>
        </div>
    </div>

@endsection