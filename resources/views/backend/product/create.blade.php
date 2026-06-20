@extends('backend.layouts.layout')
@section('title', 'Create Product - Raza Mall')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Product</h4>
            </div>
        </div>

        <form method="post" class="" action="{{ route('product.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                    <li class="nav-item"><a class="nav-link active" href="#basic-tab" data-bs-toggle="tab">Basic</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="#description-tab"
                            data-bs-toggle="tab">Description</a></li>
               
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content mt-4">

                    <!-- Basic Tab -->
                    <div class="tab-pane show active" id="basic-tab">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label class="form-label" for="name"> Name*</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required name="name" id="name"
                                                class="form-control focus" value="{{ old('name') }}">
                                            <div class="text-danger">
                                                @error('name')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <label class="form-label" for="slug"> Slug*</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required name="slug" id="slug"
                                                class="form-control" value="{{ old('slug') }}">
                                            <div class="text-danger">
                                                @error('slug')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <label class="form-label" for="sku"> SKU*</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required name="sku" id="sku"
                                                class="form-control" value="{{ old('sku') }}">
                                            <div class="text-danger">
                                                @error('sku')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group mb-0">
                                            <label class="form-label" for="status">Status*</label>
                                            <select name="status" required class="form-select" id="status">
                                                <option value="1"
                                                    {{ old('status') == 1 ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="0"
                                                    {{ old('status') == 0 ? 'selected' : '' }}>
                                                    Blocked</option>
                                            </select>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label class="form-label" for="categories">Product Categories</label>
                                        <ul class="categoryselectbox" data-bs-spy="scroll"
                                            style="max-height: 240px; max-width: 400px; overflow-y: auto; overflow-x: auto;">
                                            @foreach ($categories as $category)
                                            <li>
                                                <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                                    {{ in_array($category->id, old('category', [])) ? 'checked' : '' }}>
                                                {{ $category->name }}
                                                @if ($category->subcategories->count() > 0)
                                                <ul class="nested-list">
                                                    @foreach ($category->subcategories as $subCategory)
                                                    <li>
                                                        <input type="checkbox" name="subcategory[]"
                                                            value="{{ $subCategory->id }}"
                                                            {{ in_array($subCategory->id, old('subcategory', [])) ? 'checked' : '' }}>
                                                        {{ $subCategory->name }}

                                                        @if ($subCategory->subcategories->count() > 0)
                                                        <ul class="nested-list">
                                                            @foreach ($subCategory->subcategories as $childCategory)
                                                            <li>
                                                                <input type="checkbox"
                                                                    name="childcategory[]"
                                                                    value="{{ $childCategory->id }}"
                                                                    {{ in_array($childCategory->id, old('childcategory', [])) ? 'checked' : '' }}>
                                                                {{ $childCategory->name }}

                                                                @if ($childCategory->subcategories->count() > 0)
                                                                <ul class="nested-list">
                                                                    @foreach ($childCategory->subcategories as $superchild)
                                                                    <li>
                                                                        <input
                                                                            type="checkbox"
                                                                            name="superchild[]"
                                                                            value="{{ $superchild->id }}"
                                                                            {{ in_array($superchild->id, old('superchild', [])) ? 'checked' : '' }}>
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
                            <div class="col-lg-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="sale_price">Sale Price*</label>
                                                <input type="number" name="sale_price" required class="form-control"
                                                    value="{{ old('sale_price') }}">
                                                <div class="text-danger">
                                                    @error('sale_price')
                                                    {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="previous_price">Previous
                                                    Price</label>
                                                <input type="number" name="previous_price" class="form-control"
                                                    value="{{ old('previous_price') }}">
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="purchase_price">Purchase
                                                    Price</label>
                                                <input type="number" name="purchase_price" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-original-title="This will be hidden for users"
                                                    class="form-control" value="{{ old('purchase_price') }}">
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="barcode">Barcode*</label>
                                                <input type="text" name="barcode" required class="form-control"
                                                    value="{{ old('barcode') }}">
                                                <div class="text-danger">
                                                    @error('barcode')
                                                    {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="stock">Stock*</label>
                                                <input type="number" name="stock" required class="form-control"
                                                    value="{{ old('stock') }}">
                                                <div class="text-danger">
                                                    @error('stock')
                                                    {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="tags">Product Tags</label>
                                                <input type="text" name="tags" class="form-control"
                                                    value="{{ old('tags') }}">
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="label">Product
                                                    Label</label>
                                                <select name="label" class="form-control">
                                                    <option value="">Select</option>
                                                    <option
                                                        value="new" {{ old('label') == 'new' ? 'selected' : '' }}>
                                                        New</option>
                                                    <option
                                                        value="hot" {{ old('label') == 'hot' ? 'selected' : '' }}>
                                                        Hot</option>
                                                    <option
                                                        value="sale" {{ old('label') == 'sale' ? 'selected' : '' }}>
                                                        Sale</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label for="video"class="form-label mt-2">Product Video</label>
                                                <input type="file" name="video" class="form-control">
                                            </div>


                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="label">Product
                                                    Brand</label>
                                                <select name="brand_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($brands as $item)
                                                    <option
                                                        value="{{ $item->id }}" {{ old('brand_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <label class="form-label mt-2" for="label">Product Variation Type*
                                                </label>
                                                <select name="product_variation_type" id="product_variation_type" class="form-control">
                                                    <option value="simple" {{ old('product_variation_type') == 'simple' ? 'selected' : '' }}>Simple</option>
                                                    <option value="color_varient" {{ old('product_variation_type') == 'color_varient' ? 'selected' : '' }}>Color varient</option>
                                                    <option value="color_attribute_varient" {{ old('product_variation_type') == 'color_attribute_varient' ? 'selected' : '' }}>Color & attribute varient</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 col-sm-12 attribute_input d-none">
                                                <label class="form-label mt-2" for="label">Select Attribute
                                                </label>
                                                <select name="attribute_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @php
                                                    $filteredAttributes = $attributes->where('slug', '!=', 'color');
                                                    @endphp

                                                    @foreach ($filteredAttributes as $item)
                                                    <option value="{{ $item->id }}" {{ old('attribute_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const variationTypeSelect = document.querySelector('select[name="product_variation_type"]');
                                                    const attributeSelectDiv = document.querySelector('.attribute_input'); // FIXED

                                                    function toggleAttributeSelect() {
                                                        if (variationTypeSelect.value === 'color_attribute_varient') {
                                                            attributeSelectDiv.classList.remove('d-none');
                                                        } else {
                                                            attributeSelectDiv.classList.add('d-none');
                                                        }
                                                    }

                                                    variationTypeSelect.addEventListener('change', toggleAttributeSelect);

                                                    // run once on load
                                                    toggleAttributeSelect();
                                                });
                                            </script>



                                            <div class="col-lg-12 col-sm-12">
                                                <label class="form-label mt-2" for="is_featured">Is Featured</label>
                                                <input type="checkbox" name="is_featured" value="1"
                                                    {{ old('is_featured') ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- description Tab -->
                    <div class="tab-pane" id="description-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <label class="form-label" for="short_description"> Short
                                                    Description</label>
                                                <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>

                                                <label class="form-label mt-2" for="long_description"> Long
                                                    Description</label>

                                                <textarea id="summernote" name="long_description" class="summernote-basic">{{ old('long_description') }}</textarea>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                 
                    {{-- Submission --}}
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>


                </div>
            </div>
        </form>
    </div>
</div>
@endsection