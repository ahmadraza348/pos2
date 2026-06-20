@extends('backend.layouts.layout')
@section('title', 'Edit Brand ')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h6>Edit Brand</h6>
                </div>
            </div>

            <!-- Form for updating the brand -->
            <form method="post" action="{{ route('brand.update', $brand->id) }}" enctype="multipart/form-data">
                @csrf
              
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Brand Name -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="name">Name*</label>
                                    <div class="form-control-wrap">
                                        <input type="text" required name="name" id="name" class="form-control"
                                            value="{{ old('name', $brand->name) }}">
                                        <div class="text-danger">
                                            @error('name') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Brand Slug -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="slug">Slug*</label>
                                    <div class="form-control-wrap">
                                        <input type="text" required name="slug" id="slug" class="form-control"
                                            value="{{ old('slug', $brand->slug) }}">
                                        <div class="text-danger">
                                            @error('slug') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="website">Website</label>
                                    <div class="form-control-wrap">
                                        <input type="url" name="website" id="website" class="form-control"
                                            value="{{ old('website', $brand->website) }}">
                                        <div class="text-danger">
                                            @error('website') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1"
                                            {{ old('status', $brand->status) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $brand->status) == 'inactive' ? 'selected' : '' }}>
                                            Blocked
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="image">Image</label>
                                    <div class="form-control-wrap">
                                        <input type="file" name="image" class="form-control" id="image"
                                            accept="image/*" onchange="previewImage(event)">
                                        <div class="text-danger">
                                            @error('image') {{ $message }} @enderror
                                        </div>
                                    </div>
                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        @if($brand->image)
                                            <img id="imagePreview" src="{{ asset('storage/' . $brand->image) }}" alt="Image Preview"
                                                 style="max-width: 200px; max-height: 200px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Image Preview"
                                                 style="display: none; max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Categories Selection -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="category_id">Select Category</label>
                                    <ul class="categoryselectbox" data-bs-spy="scroll"
                                        style="max-height: 240px; max-width: 400px; overflow-y: auto; overflow-x: auto;">
                                        @foreach ($all_category_data as $category)
                                            <li>
                                                <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                                    {{ in_array($category->id, $selected_categories) ? 'checked' : '' }}>
                                                {{ $category->name }}
                                                @if ($category->subcategories->count() > 0)
                                                    <ul class="nested-list">
                                                        @foreach ($category->subcategories as $subCategory)
                                                            <li>
                                                                <input type="checkbox" name="category[]"
                                                                    value="{{ $subCategory->id }}"
                                                                    {{ in_array($subCategory->id, $selected_categories) ? 'checked' : '' }}>
                                                                {{ $subCategory->name }}
                                                                @if ($subCategory->subcategories->count() > 0)
                                                                    <ul class="nested-list">
                                                                        @foreach ($subCategory->subcategories as $childCategory)
                                                                            <li>
                                                                                <input type="checkbox"
                                                                                    name="category[]"
                                                                                    value="{{ $childCategory->id }}"
                                                                                    {{ in_array($childCategory->id, $selected_categories) ? 'checked' : '' }}>
                                                                                {{ $childCategory->name }}
                                                                                @if ($childCategory->subcategories->count() > 0)
                                                                                <ul class="nested-list">
                                                                                    @foreach ($childCategory->subcategories as $superchild)
                                                                                        <li>
                                                                                            <input type="checkbox"
                                                                                                name="category[]"
                                                                                                value="{{ $superchild->id }}"
                                                                                                {{ in_array($superchild->id, $selected_categories) ? 'checked' : '' }}>
                                                                                            {{ $superchild->name }}

                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="description">Description</label>
                                    <div class="form-control-wrap">
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ old('description', $brand->description) }}</textarea>
                                        <div class="text-danger">
                                            @error('description') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
