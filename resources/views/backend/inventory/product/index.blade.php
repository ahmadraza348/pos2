@extends('backend.layouts.layout')
@section('title', 'All Products')
@section('content')
<div class="page-wrapper">
    <div class="content">
 
        <div class="page-header">
    <div class="page-title">
        <h4>Manage Products</h4>
    </div>
    <div class="page-btn d-flex gap-2">
        <a href="{{ route('product.restoreProduct') }}" class="btn btn-outline-secondary">
            <img src="{{ asset('backend/assets/img/icons/trash12.svg') }}" alt="img"> Trashed Products
        </a>
        <a href="{{ route('product.create') }}" class="btn btn-added">
            <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img">Add Product
        </a>
    </div>
</div>

        <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group d-flex w-50 gap-2 mb-4">
                <input type="file" name="products_file" id="products_file" class="form-control" required>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
        

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all" onclick="selectAll(this)">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Category</th>                 
                                <th>Unit Cost</th>
                                <th>Profit</th>
                                <th>Selling Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="select-option" data-id="{{ $item->id }}"
                                                onchange="toggleDeleteButton()">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="product-img">
                                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('backend/assets/img/noimage.png') }}"
                                                alt="{{ $item->name }}"
                                                style="width:60px; height:60px; border-radius:8px; object-fit:cover;">
                                        </a>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->category->name ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format($item->cost_price, 2) }}</td>    
                                    <td>{{ number_format($item->profit_margin) }}%</td>    
                                    <td>Rs. {{ number_format($item->selling_price, 2) }}</td>
                                    <td>
                                        {{ $item->stock }}
                                        @if ($item->is_low_stock)
                                            <span class="badge rounded-pill bg-warning text-dark ms-1">Low</span>
                                        @endif
                                    </td>
                                 
                                    <td>
                                        @if ($item->status)
                                            <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit', $item->id) }}" class="me-3">
                                            <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                        </a>

                                        <form id="deletepro-{{ $item->id }}"
                                            action="{{ route('product.destroy', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('delete')
                                        </form>

                                        <a onclick="if(confirm('Are you sure to delete this?')) { document.getElementById('deletepro-{{ $item->id }}').submit(); } return false;"
                                            class="me-3">
                                            <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button id="delete-selected-btn" class="btn btn-danger btn-sm mt-3" style="display: none;"
                    onclick="deleteSelectedOptions()">Delete Selected</button>
            </div>
        </div>

        <form id="bulk-delete-form" action="{{ route('product.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="pro_ids" id="option-ids">
        </form>

    </div>
</div>
@endsection