@extends('backend.layouts.layout')
@section('title', 'Add Product')
@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header mb-4">
            <div class="page-title"><h4>Add Product</h4></div>
        </div>

        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
            @csrf
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
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="e.g. Lays Classic 40g">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sku">SKU *</label>
                                    <input type="text" required name="sku" id="sku"
                                        class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}"
                                        placeholder="e.g. LAYS-40">
                                    <small class="text-muted">A short internal code you use to identify this product.</small>
                                    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode"
                                        class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}"
                                        placeholder="Scan or leave blank">
                                    <small class="text-muted">Optional — only needed if you scan products at checkout.</small>
                                    @error('barcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="form-control" placeholder="Optional notes about this product">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="image">Product Image</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="form-control" onchange="previewImage(event)">
                                @error('image') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                <div class="mt-3">
                                    <img id="imagePreview" src="#" alt="Preview"
                                        style="display:none; width:100px; height:100px; object-fit:cover; border-radius:6px;">
                                </div>
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
                                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active — visible at POS</option>
                                            <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Blocked — hidden from POS</option>
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary bg-opacity-10">
                                    <h5 class="card-title mb-0 text-primary">Pricing</h5>
                                </div>
                                <div class="card-body">

                                    <div class="alert alert-light border small mb-3">
                                        Stock isn't set here — new products start at <strong>0</strong>.
                                        Add stock by recording a <strong>Purchase</strong> for this product once it's saved.
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label" for="cost_price">Purchase Price *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="number" step="0.01" name="cost_price" id="cost_price" required min="0.01"
                                                    class="form-control @error('cost_price') is-invalid @enderror"
                                                    value="{{ old('cost_price', '') }}"
                                                    placeholder="0.00">
                                            </div>
                                            <small class="text-muted">Your best estimate for now — updates automatically from Purchases.</small>
                                            @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label" for="profit_margin">Profit Margin *</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" max="1000" required
                                                    name="profit_margin" id="profit_margin"
                                                    class="form-control @error('profit_margin') is-invalid @enderror"
                                                    value="{{ old('profit_margin', 20) }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <small class="text-muted">How much to add on top of the purchase price.</small>
                                            @error('profit_margin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-6 mb-0">
                                            <label class="form-label" for="minimum_stock">Low Stock Alert</label>
                                            <input type="number" name="minimum_stock" id="minimum_stock" min="0"
                                                class="form-control"
                                                value="{{ old('minimum_stock', 0) }}">
                                            <small class="text-muted">Get warned when stock drops to this number.</small>
                                        </div>

                                        <div class="col-12 mb-0">
                                            <label class="form-label text-muted">Selling Price (calculated)</label>
                                            <div class="input-group">
                                                <span class="input-group-text text-muted">Rs.</span>
                                                <input type="text" id="selling_price_preview"
                                                    class="form-control bg-light fw-bold text-success"
                                                    value="0.00" disabled readonly>
                                            </div>
                                            <small class="text-muted">
                                                Purchase price × (1 + margin). This is what the cashier will charge — it updates automatically and isn't editable here.
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
                    <button type="submit" class="btn btn-primary px-4 py-2">Add Product</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
function previewImage(event) {
    const img = document.getElementById('imagePreview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function () {
    const costInput    = document.getElementById('cost_price');
    const marginInput  = document.getElementById('profit_margin');
    const previewEl    = document.getElementById('selling_price_preview');

    function recalcSellingPrice() {
        const cost   = parseFloat(costInput.value) || 0;
        const margin = parseFloat(marginInput.value) || 0;
        previewEl.value = (cost * (1 + margin / 100)).toFixed(2);
    }

    costInput.addEventListener('input', recalcSellingPrice);
    marginInput.addEventListener('input', recalcSellingPrice);

    recalcSellingPrice();
});
</script>
@endsection