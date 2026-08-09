@extends('backend.layouts.layout')
@section('title', 'Edit Product')
@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header mb-4">
            <div class="page-title"><h4>Edit Product — {{ $pro_data->name }}</h4></div>
        </div>

        <form method="POST" action="{{ route('product.update', $pro_data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">

                {{-- ===================== LEFT: Product Info ===================== --}}
                <div class="col-lg-7 col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name">Product Name *</label>
                                <input type="text" required name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $pro_data->name) }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sku">SKU *</label>
                                    <input type="text" required name="sku" id="sku"
                                        class="form-control @error('sku') is-invalid @enderror"
                                        value="{{ old('sku', $pro_data->sku) }}">
                                    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode"
                                        class="form-control @error('barcode') is-invalid @enderror"
                                        value="{{ old('barcode', $pro_data->barcode) }}">
                                    @error('barcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="form-control">{{ old('description', $pro_data->description) }}</textarea>
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="image">Product Image</label>
                                <input type="file" name="image" id="image" accept="image/*" class="form-control">
                                @if ($pro_data->image)
                                    <div class="mt-3">
                                        <p class="small text-muted mb-1">Current Image:</p>
                                        <img src="{{ asset('storage/'.$pro_data->image) }}"
                                            alt="{{ $pro_data->name }}"
                                            style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                                    </div>
                                @endif
                                @error('image') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== RIGHT: Categorization + Pricing ===================== --}}
                <div class="col-lg-5 col-md-12">
                    <div class="row g-4">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Categorization &amp; Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status *</label>
                                        <select name="status" required class="form-select" id="status">
                                            <option value="1" {{ old('status', $pro_data->status) == 1 ? 'selected' : '' }}>Active — visible at POS</option>
                                            <option value="0" {{ old('status', $pro_data->status) == 0 ? 'selected' : '' }}>Blocked — hidden from POS</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $pro_data->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="brand_id">Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-select">
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand_id', $pro_data->brand_id) == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label" for="unit_id">Unit</label>
                                        <select name="unit_id" id="unit_id" class="form-select">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ old('unit_id', $pro_data->unit_id) == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary bg-opacity-10">
                                    <h5 class="card-title mb-0 text-primary">Inventory &amp; Pricing</h5>
                                </div>
                                <div class="card-body">

                                    <div class="alert alert-light border small mb-3">
                                        Stock and purchase price are set by <strong>Purchases</strong> now — they're shown
                                        here for reference only. Record a Purchase to change them.
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label text-muted" for="stock_display">Current Stock</label>
                                            <input type="text" id="stock_display"
                                                class="form-control bg-light" value="{{ $pro_data->stock }}"
                                                disabled readonly>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label" for="minimum_stock">Low Stock Alert</label>
                                            <input type="number" name="minimum_stock" id="minimum_stock" min="0"
                                                class="form-control"
                                                value="{{ old('minimum_stock', $pro_data->minimum_stock) }}">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label text-muted" for="cost_price_display">Purchase Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text text-muted">Rs.</span>
                                                <input type="text" id="cost_price_display"
                                                    class="form-control bg-light"
                                                    value="{{ number_format($pro_data->cost_price, 2) }}"
                                                    disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label" for="profit_margin">Profit Margin *</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" max="1000"
                                                    name="profit_margin" id="profit_margin" required
                                                    class="form-control @error('profit_margin') is-invalid @enderror"
                                                    value="{{ old('profit_margin', $pro_data->profit_margin) }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            @error('profit_margin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12 mb-0">
                                            <label class="form-label text-muted">Selling Price (calculated)</label>
                                            <div class="input-group">
                                                <span class="input-group-text text-muted">Rs.</span>
                                                <input type="text" id="selling_price_preview"
                                                    class="form-control bg-light fw-bold text-success"
                                                    value="{{ number_format($pro_data->selling_price, 2) }}"
                                                    disabled readonly>
                                            </div>
                                            <small class="text-muted">
                                                Purchase price × (1 + margin) — updates live as you change the margin.
                                            </small>
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
                    <button type="submit" class="btn btn-primary px-4 py-2">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fixedCost   = {{ (float) $pro_data->cost_price }};
    const marginInput = document.getElementById('profit_margin');
    const previewEl   = document.getElementById('selling_price_preview');

    function recalcSellingPrice() {
        const margin = parseFloat(marginInput.value) || 0;
        previewEl.value = (fixedCost * (1 + margin / 100)).toFixed(2);
    }

    marginInput.addEventListener('input', recalcSellingPrice);
});
</script>
@endsection