@extends('backend.layouts.layout')
@section('title', 'Add Product')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Product</h4>
            </div>
        </div>

        <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="row">

                    <!-- Basic Info -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name*</label>
                                    <input type="text" required name="name" id="name"
                                        class="form-control" value="{{ old('name') }}">
                                    <div class="text-danger">
                                        @error('name') {{ $message }} @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="sku">SKU*</label>
                                    <input type="text" required name="sku" id="sku"
                                        class="form-control" value="{{ old('sku') }}">
                                    <div class="text-danger">
                                        @error('sku') {{ $message }} @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode"
                                        class="form-control" value="{{ old('barcode') }}">
                                    <div class="text-danger">
                                        @error('barcode') {{ $message }} @enderror
                                    </div>
                                </div>

                                
                                    <div class="mb-3">
                                        <label class="form-label" for="profit_margin">Profit Margin (%)*</label>
                                        <input type="number" step="0.01" name="profit_margin" required
                                            class="form-control" value="{{ old('profit_margin', '') }}">
                                        <div class="text-danger">
                                            @error('profit_margin') {{ $message }} @enderror
                                        </div>
                                    </div>       

                                <div class="mb-0">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="0" {{ old('status', 0) == 0 ? 'selected' : '' }}>Blocked</option>
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category / Brand / Unit -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @error('category_id') {{ $message }} @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="brand_id">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('brand_id', '') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @error('brand_id') {{ $message }} @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="unit_id">Unit</label>
                                    <select name="unit_id" id="unit_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('unit_id', '') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @error('unit_id') {{ $message }} @enderror
                                    </div>
                                </div>

                                
                                    <div class="mb-3">
                                        <label class="form-label" for="image">Product Image</label>
                                        <input type="file" name="image" id="image" accept="image/*" class="form-control"onchange="previewImage(event)">
                                        <div class="text-danger">
                                            @error('image') {{ $message }} @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 100%; max-height: 150px; border-radius: 8px;">
                                    </div>


                                    
                            </div>
                        </div>
                    </div>

                    <!-- Pricing / Stock / Image -->
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                     <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control">{{ old('description') }}</textarea>
                                        <div class="text-danger">
                                            @error('description') {{ $message }} @enderror
                                        </div>
                                    </div>

                            


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection