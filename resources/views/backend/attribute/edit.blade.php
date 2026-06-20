@extends('backend.layouts.layout')
@section('title', 'Edit Attribute')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Attribute</h4>
                    <h6>Edit Attribute</h6>
                </div>
            </div>

            <form method="post" class="" action="{{ route('attribute.update', $attribute->id) }}">
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
                                            value="{{ old('name', $attribute->name) }}"> <!-- Pre-fill name field -->
                                        <div class="text-danger">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Slug -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="slug"> Slug*</label>
                                    <div class="form-control-wrap">
                                        <input type="text" required name="slug" id="slug" class="form-control"
                                            value="{{ old('slug', $attribute->slug) }}"> <!-- Pre-fill slug field -->
                                        <div class="text-danger">
                                            @error('slug')
                                                {{ $message }}
                                            @enderror
                                        </div>
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
                            
                            
                            

                            <!-- Status -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status', $attribute->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $attribute->status) == '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
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
