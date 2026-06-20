@extends('backend.layouts.layout')
@section('title', 'Create Category ')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Category</h4>
                    <h6>Add New Category</h6>
                </div>
            </div>

            <form method="post" class="" action="{{ route('category.store') }}" enctype="multipart/form-data">
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
                                            value="{{ old('name') }}">
                                        <div class="text-danger">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>



                                 <!-- Category Image -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                                                 <!-- Image Preview -->
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="Image Preview"
                                            style="display: none; max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="image"> Image</label>
                                    <div class="form-control-wrap">
                                        <input type="file" name="image" class="form-control" id="image"
                                            accept="image/*" onchange="previewImage(event)">
                                        <div class="text-danger">
                                            @error('image')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="Image Preview"
                                            style="display: none; max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                            </div>

                            
                            <!-- Status -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                </div>
                            </div>
                                  <!-- Category Description -->
                                  <div class="col-lg-6 col-sm-12">
                                    <div class="form-group mb-0">
                                        <label class="form-label" for="description">Description</label>
                                        <div class="form-control-wrap">
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                            <div class="text-danger">
                                                @error('description')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       

                      
                            <!-- Submit Button -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
