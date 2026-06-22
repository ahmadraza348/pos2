@extends('backend.layouts.layout')
@section('title', 'Edit Product')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Product</h4>
            </div>
        </div>

        <form method="POST" action="{{ route('product.update', $pro_data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-md-12">
                <div class="row">

                    <!-- Basic Info -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name*</label>
                                    <input type="text" required name="name" id="name"
                                        class="form-control" value="{{ old('name', $pro_data->name) }}">
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="sku">SKU*</label>
                                    <input type="text" required name="sku" id="sku"
                                        class="form-control" value="{{ old('sku', $pro_data->sku) }}">
                                    @error('sku') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode"
                                        class="form-control" value="{{ old('barcode', $pro_data->barcode) }}">
                                    @error('barcode') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status', $pro_data->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $pro_data->status) == 0 ? 'selected' : '' }}>Blocked</option>
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
                                                {{ old('category_id', $pro_data->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="brand_id">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('brand_id', $pro_data->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label class="form-label" for="unit_id">Unit</label>
                                    <select name="unit_id" id="unit_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('unit_id', $pro_data->unit_id) == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing / Stock / Image -->
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 mb-3">
                                        <label class="form-label" for="cost_price">Cost Price*</label>
                                        <input type="number" step="0.01" name="cost_price" required
                                            class="form-control" value="{{ old('cost_price', $pro_data->cost_price) }}">
                                        @error('cost_price') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-lg-6 col-sm-12 mb-3">
                                        <label class="form-label" for="profit_margin">Profit Margin*</label>
                                        <input type="number" step="0.01" name="profit_margin" required
                                            class="form-control" value="{{ old('profit_margin', $pro_data->profit_margin) }}">
                                        @error('profit_margin') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-lg-6 col-sm-12 mb-3">
                                        <label class="form-label" for="selling_price">Selling Price*</label>
                                        <input disabled type="number" step="0.01" name="selling_price" required
                                            class="form-control" value="{{ old('selling_price', $pro_data->selling_price) }}">
                                        @error('selling_price') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-lg-6 col-sm-12 mb-3">
                                        <label class="form-label" for="stock">Stock*</label>
                                        <input type="number" name="stock" required
                                            class="form-control" value="{{ old('stock', $pro_data->stock) }}">
                                        @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-lg-6 col-sm-12 mb-3">
                                        <label class="form-label" for="minimum_stock">Minimum Stock</label>
                                        <input type="number" name="minimum_stock"
                                            class="form-control" value="{{ old('minimum_stock', $pro_data->minimum_stock) }}">
                                        @error('minimum_stock') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-lg-6 col-sm-12 mb-3">
                                        <label class="form-label" for="image">Product Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                        @if ($pro_data->image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $pro_data->image) }}"
                                                    alt="{{ $pro_data->name }}"
                                                    style="width:80px; height:80px; object-fit:cover; border-radius:6px;">
                                            </div>
                                        @endif
                                        @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-lg-12 col-sm-12">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control">{{ old('description', $pro_data->description) }}</textarea>
                                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection