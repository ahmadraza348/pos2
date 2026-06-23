@extends('backend.layouts.layout')
@section('title', 'Add Product')
@section('content')
<div class="page-wrapper">
    <div class="content">
        
        <div class="page-header mb-4">
            <div class="page-title">
                <h4>Add Product</h4>
            </div>
        </div>

        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name">Product Name *</label>
                                <input type="text" required name="name" id="name"
                                    class="form-control" value="{{ old('name') }}">
                                @error('name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sku">SKU *</label>
                                    <input type="text" required name="sku" id="sku"
                                        class="form-control" value="{{ old('sku') }}">
                                    @error('sku') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode"
                                        class="form-control" value="{{ old('barcode') }}">
                                    @error('barcode') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" id="description" rows="5"
                                    class="form-control">{{ old('description') }}</textarea>
                                @error('description') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="image">Product Image</label>
                                <input type="file" name="image" id="image" accept="image/*" class="form-control" onchange="previewImage(event)">
                                @error('image') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                
                                <div class="mt-3 p-2  ">
                                    <img id="imagePreview" src="#" alt="Preview" style="display: none; width:100px; height:100px; object-fit:cover; border-radius:6px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12">
                    <div class="row g-4">
                        
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Categorization & Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status *</label>
                                        <select name="status" required class="form-select" id="status">
                                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Blocked</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="brand_id">Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-select">
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label" for="unit_id">Unit</label>
                                        <select name="unit_id" id="unit_id" class="form-select">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0 text-muted">Inventory & Pricing (Read-Only)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label text-muted" for="stock">Current Stock</label>
                                            <input disabled type="number" name="stock" id="stock"
                                                class="form-control bg-light" value="{{ old('stock', '') }}">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label text-muted" for="minimum_stock">Min Alert Stock</label>
                                            <input disabled type="number" name="minimum_stock" id="minimum_stock"
                                                class="form-control bg-light" value="{{ old('minimum_stock', '') }}">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label text-muted" for="cost_price">Cost Price</label>
                                            <input disabled type="number" step="0.01" name="cost_price" id="cost_price"
                                                class="form-control bg-light" value="{{ old('cost_price', '') }}">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label" for="profit_margin">Profit Margin (%) *</label>
                                            <input type="number" step="0.01" name="profit_margin" id="profit_margin" required
                                                class="form-control" value="{{ old('profit_margin', '') }}">
                                            @error('profit_margin') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12 mb-0">
                                            <label class="form-label text-muted" for="selling_price">Selling Price</label>
                                            <input disabled type="number" step="0.01" name="selling_price" id="selling_price"
                                                class="form-control bg-light" value="{{ old('selling_price', '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">Add Product</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection