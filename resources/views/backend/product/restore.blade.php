@extends('backend.layouts.layout')
@section('title', 'All Products')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage Products</h4>
                </div>
            </div>


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
                                    <th>Sku</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Label</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $item)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" class="select-category" data-id="{{ $item->id }}"
                                                    onchange="toggleDeleteButton()">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{ $item->featured_image ? asset('storage/' . $item->featured_image) : asset('backend/assets/img/noimage.png') }}"
                                                    alt="profile image"
                                                    style="width:60px; height:60px; border-radius:100px;">
                                            </a>
                                        </td>
                                        <td>{{ $item->name }} </td>
                                        <td>{{ $item->sku }} </td>
                                        <td>{{ $item->sale_price }} </td>
                                        <td>{{ $item->stock }} </td>
                                        @if ($item->label)
                                            <td> <span class="badge rounded-pill bg-success">{{ $item->label }}</span>
                                            </td>
                                        @else
                                        <td> <span class="badge rounded-pill bg-danger">None</span>
                                            @endif

                                        <td>
                                            @if ($item->is_featured == '1')
                                                <span class="badge rounded-pill bg-success">Yes</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == '1')
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>

                                            <form action="{{ route('products.restore', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit">Restore</button>
                                            </form>

                                            <!-- Delete Form (hidden) -->
                                            <form id="deletepro-{{ $item->id }}"
                                                action="{{ route('products.forceDelete', $item->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('delete')
                                            </form>

                                            <!-- Delete Icon -->
                                            <a onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deletepro-{{ $item->id }}').submit(); } return false;"
                                                class="me-3">
                                                <img src="{{ asset('backend/assets/img/icons/delete.svg') }}"
                                                    alt="delete">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button id="delete-selected-btn" class="btn btn-danger btn-sm mt-3" style="display: none; "
                        onclick="deleteSelectedCategories()">Delete Selected</button>
                </div>
            </div>

            <!-- Bulk Delete Form -->
            <form id="bulk-delete-form" action="{{ route('category.bulk-delete') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="category_ids" id="category-ids">
            </form>


        </div>
    </div>

@endsection
