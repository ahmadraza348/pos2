@extends('backend.layouts.layout')
@section('title', 'All Brands - Raza Mall')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage Brands</h4>
                    <h6>Manage your Product Brands</h6>
                </div>            
            </div>          

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $editable_brand ? 'Edit Brand' : 'Add Brand' }}</h5>
                            <hr>

                           <form method="POST"
                                action="{{ $editable_brand ? route('brand.update', $editable_brand) : route('brand.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if($editable_brand)
                                    @method('PUT')
                                @endif

                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Name*</label>
                                    <input type="text" required name="name" id="name" class="form-control"
                                           value="{{ old('name', $editable_brand->name ?? '') }}">
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="image">Image</label>
                                    <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                                    @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2 text-center">
                                        @if($editable_brand && $editable_brand->image)
                                            <img id="imagePreview" src="{{ asset('storage/' . $editable_brand->image) }}" alt="Preview" style="max-width: 100%; max-height: 150px; border-radius: 8px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 100%; max-height: 150px; border-radius: 8px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status', $editable_brand->status ?? '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $editable_brand->status ?? '1') == '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="4">{{ old('description', $editable_brand->description ?? '') }}</textarea>
                                    @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">{{ $editable_brand ? 'Update' : 'Submit' }}</button>
                                    @if($editable_brand)
                                        <a href="{{ route('brand.index') }}" class="btn btn-light w-100">Cancel</a>
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
                                            <th>Image</th>
                                            <th>Brand</th>                  
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands_data as $brand)
                                        <tr class="{{ $editable_brand && $editable_brand->id === $brand->id ? 'table-primary' : '' }}">
                                         
                                            <td>
                                                <img src="{{ $brand->image ? asset('storage/' . $brand->image) : asset('backend/assets/img/noimage.png') }}"
                                                     alt="brand image" style="width:50px; height:50px; object-fit: cover; border-radius:50px;">
                                            </td>
                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                <span class="badge rounded-pill {{ $brand->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $brand->status == '1' ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('brand.edit', $brand->id) }}" class="me-3">
                                                    <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                                </a>

                                                <a href="#" onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteBrand-{{ $brand->id }}').submit(); } return false;">
                                                    <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                                </a>
                                                <form id="deleteBrand-{{ $brand->id }}" action="{{ route('brand.destroy', $brand->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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

        
        </div>
    </div>

@endsection