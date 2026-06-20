@extends('backend.layouts.layout')
@section('title', 'Edit Category - Raza Mall')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Category</h4>
                    <h6>Edit Category</h6>
                </div>
            </div>

            <form method="post" class="" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Category Name -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="name"> Name*</label>
                                    <div class="form-control-wrap">
                                        <input type="text" required name="name" id="name" class="form-control"
                                            value="{{ old('name', $category->name) }}"> <!-- Pre-fill name field -->
                                        <div class="text-danger">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

              
                                <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="image"> Image</label>
                                    <div class="form-control-wrap">
                                        <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                                        <div class="text-danger">
                                            @error('image')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        @if ($category->image)
                                            <img id="imagePreview" src="{{ asset('storage/' . $category->image) }}" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Category Description -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="description">Description</label>
                                    <div class="form-control-wrap">
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ old('description', $category->description) }}</textarea>
                                        <div class="text-danger">
                                            @error('description')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Image -->
                        
                            <!-- Submit Button -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Update</button>
                                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                      </form>
        </div>
    </div>
@endsection
