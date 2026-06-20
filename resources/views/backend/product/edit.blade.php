@extends('backend.layouts.layout')
@section('title', 'Edit Product')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Edit Product</h4>
                </div>
              

                <div class="page-btn d-flex gap-2">
                    <a href="{{ route('add.pro.images', $pro_data->id) }}" class="btn btn-added btn-sm">Manage Images</a>
                      @if (
                    $pro_data->product_variation_type === 'color_attribute_varient' ||
                        $pro_data->product_variation_type === 'color_varient')
             
                        <a href="{{ route('admin.pro.attribute.index', $pro_data->id) }}" class="btn btn-added btn-sm">Manage Attributes</a>
                  
                @endif
                </div>
            </div>

            <form method="POST" action="{{ route('product.update', $pro_data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" href="#basic-tab" data-bs-toggle="tab">Basic</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#description-tab" data-bs-toggle="tab">Description</a>
                        </li>
                    
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content mt-4">
                        <!-- Basic Tab -->
                        <div class="tab-pane show active" id="basic-tab">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="name">Name*</label>
                                                <input type="text" required name="name" id="name"
                                                    class="form-control focus" value="{{ old('name', $pro_data->name) }}">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="slug">Slug*</label>
                                                <input type="text" required name="slug" id="slug"
                                                    class="form-control" value="{{ old('slug', $pro_data->slug) }}">
                                                @error('slug')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="sku">SKU*</label>
                                                <input type="text" required name="sku" id="sku"
                                                    class="form-control" value="{{ old('sku', $pro_data->sku) }}">
                                                @error('sku')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label" for="status">Status*</label>
                                                <select name="status" required class="form-select" id="status">
                                                    <option value="active"
                                                        {{ old('status', $pro_data->status) == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="inactive"
                                                        {{ old('status', $pro_data->status) == 0 ? 'selected' : '' }}>
                                                        Blocked</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Categories -->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <label class="form-label" for="categories">Product Categories</label>
                                            <ul class="categoryselectbox" data-bs-spy="scroll"
                                                style="max-height: 240px; max-width: 400px; overflow-y: auto; overflow-x: auto;">
                                                @foreach ($all_category_data as $category)
                                                    <li>
                                                        <input type="checkbox" name="category[]"
                                                            value="{{ $category->id }}"
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
                                                                                                        <input
                                                                                                            type="checkbox"
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
                                </div>

                                <!-- Full Width - Product Details -->
                                <div class="col-lg-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Price Fields -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="sale_price">Sale Price*</label>
                                                    <input type="number" name="sale_price" required class="form-control"
                                                        value="{{ old('sale_price', $pro_data->sale_price) }}">
                                                    @error('sale_price')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="previous_price">Previous Price</label>
                                                    <input type="number" name="previous_price" class="form-control"
                                                        value="{{ old('previous_price', $pro_data->previous_price) }}">
                                                </div>

                                                <!-- Purchase Price -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="purchase_price">Purchase Price</label>
                                                    <input type="number" name="purchase_price" class="form-control"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="This will be hidden for users"
                                                        value="{{ old('purchase_price', $pro_data->purchase_price) }}">
                                                </div>

                                                <!-- Barcode -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="barcode">Barcode*</label>
                                                    <input type="text" name="barcode" required class="form-control"
                                                        value="{{ old('barcode', $pro_data->barcode) }}">
                                                    @error('barcode')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Stock -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="stock">Stock*</label>
                                                    <input type="number" name="stock" required class="form-control"
                                                        value="{{ old('stock', $pro_data->stock) }}">
                                                    @error('stock')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Tags -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="tags">Product Tags</label>
                                                    <input type="text" name="tags" class="form-control"
                                                        value="{{ old('tags', $pro_data->tags) }}">
                                                </div>

                                                <!-- Product Label -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="label">Product Label</label>
                                                    <select name="label" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="new"
                                                            {{ old('label', $pro_data->label) == 'new' ? 'selected' : '' }}>
                                                            New</option>
                                                        <option value="hot"
                                                            {{ old('label', $pro_data->label) == 'hot' ? 'selected' : '' }}>
                                                            Hot</option>
                                                        <option value="sale"
                                                            {{ old('label', $pro_data->label) == 'sale' ? 'selected' : '' }}>
                                                            Sale</option>
                                                    </select>
                                                </div>

                                                <!-- Video Upload -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="video">Product Video</label>
                                                    <input type="file" name="video" class="form-control">
                                                    @if ($pro_data->video)
                                                        <div class="mt-2">
                                                            <label>Current Video:</label>
                                                            <video width="320" height="240" controls>
                                                                <source src="{{ asset('storage/' . $pro_data->video) }}"
                                                                    type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Brand Selection -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="brand_id">Product Brand</label>
                                                    <select name="brand_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}"
                                                                {{ $pro_data->brand_id == $brand->id ? 'selected' : '' }}>
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Variation Type -->
                                                <div class="col-lg-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="product_variation_type">Product
                                                        Variation Type*</label>
                                                    <select name="product_variation_type" disabled
                                                        id="product_variation_type" class="form-control">
                                                        <option value="simple"
                                                            {{ old('product_variation_type', $pro_data->product_variation_type) == 'simple' ? 'selected' : '' }}>
                                                            Simple</option>
                                                        <option value="color_varient"
                                                            {{ old('product_variation_type', $pro_data->product_variation_type) == 'color_varient' ? 'selected' : '' }}>
                                                            Color varient</option>
                                                        <option value="color_attribute_varient"
                                                            {{ old('product_variation_type', $pro_data->product_variation_type) == 'color_attribute_varient' ? 'selected' : '' }}>
                                                            Color & attribute varient</option>
                                                    </select>
                                                </div>

                                                <!-- Attribute Selection -->
                                                <div class="col-lg-6 col-sm-12 mb-3 attribute_input d-none">
                                                    <label class="form-label" for="attribute_id">Select Attribute</label>
                                                    <select disabled name="attribute_id" class="form-control">
                                                        <option value="">None</option>
                                                        @php
                                                            $filteredAttributes = $attributes->where(
                                                                'slug',
                                                                '!=',
                                                                'color',
                                                            );
                                                        @endphp
                                                        @foreach ($filteredAttributes as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('attribute_id', $pro_data->attribute_id) == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Featured Checkbox -->
                                                <div class="col-lg-12 col-sm-12 mb-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" id="is_featured" name="is_featured"
                                                            value="1" class="form-check-input"
                                                            {{ old('is_featured', $pro_data->is_featured) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_featured">Is
                                                            Featured</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Tab -->
                        <div class="tab-pane" id="description-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="short_description">Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $pro_data->short_description) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="long_description">Long Description</label>
                                        <textarea id="summernote" name="long_description" class="summernote-basic">{{ old('long_description', $pro_data->long_description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Meta Tab -->
                     
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variationTypeSelect = document.querySelector('select[name="product_variation_type"]');
            const attributeSelectDiv = document.querySelector('.attribute_input');

            function toggleAttributeSelect() {
                if (variationTypeSelect.value === 'color_attribute_varient') {
                    attributeSelectDiv.classList.remove('d-none');
                } else {
                    attributeSelectDiv.classList.add('d-none');
                }
            }

            variationTypeSelect.addEventListener('change', toggleAttributeSelect);
            toggleAttributeSelect(); // Initialize on load
        });
    </script>
@endsection
