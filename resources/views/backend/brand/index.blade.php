@extends('backend.layouts.layout')
@section('title', 'All Brands')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage your Product Brands </h4>
                    
                </div>
                <div class="page-btn">
                    
                </div>
                @can('create_brands', 'admin')
                <div class="page-btn">
                    <a href="{{ route('brand.create') }}" class="btn btn-added"><img
                            src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img">Add Brand</a>
                </div>
                @endcan
        
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brand as $item)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" class="select-category" data-id="{{ $item->id }}" onchange="toggleDeleteButton()">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('backend/assets/img/noimage.png') }}"
                                                    alt="profile image"
                                                    style="width:60px; height:60px; border-radius:100px;">
                                            </a>
                                        </td>
                                        <td>{{ $item->name }} </td>
                                                                         
                                        <td>
                                            @if ($item->status == '1')
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="
                                            {{ route('brand.edit', $item->id) }}
                                             " class="me-3">
                                                <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                            </a>
            
                                            <!-- Delete Form (hidden) -->
                                            <form id="deleteCat-{{ $item->id }}" action="
                                                {{ route('brand.destroy', $item->id) }}
                                                 " method="POST" style="display: none;">
                                                @csrf
                                                @method('delete')
                                            </form>
                                            
                                            <!-- Delete Icon -->
                                            <a onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteCat-{{ $item->id }}').submit(); } return false;" class="me-3">
                                                <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button id="delete-selected-btn" class="btn btn-danger btn-sm mt-3" style="display: none; " onclick="deleteSelectedCategories()">Delete Selected</button>
                </div>
            </div>

            <!-- Bulk Delete Form -->
            <form id="bulk-delete-form" action="{{ route('brand.bulk-delete') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="brand_ids" id="category-ids">
            </form>


        </div>
    </div>
  
@endsection
