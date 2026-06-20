@extends('backend.layouts.layout')
@section('title', 'All Categories - Raza Mall')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Categories</h4>
                <h6>Manage your Product Categories </h6>

            </div>
            <div class="page-btn">
                <a href="{{ route('category.create') }}" class="btn btn-added"><img
                        src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img">Add Category</a>
            </div>               



        </div>
      

        <form action="{{ route('category.import') }}"class=" d-flex justify-content-end" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group d-flex"style="width:400px;">
                <input type="file" name="categories_file" id="categories_file" class="form-control mx-2 " required>
                <button type="submit" class="btn btn-primary">Import </button>
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
                                <th>Category</th>                  
                              <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories_data as $category)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox" class="select-category" data-id="{{ $category->id }}"
                                            onchange="toggleDeleteButton()">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>

                                <td>
                                    <a href="javascript:void(0);" class="product-img">
                                        <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('backend/assets/img/noimage.png') }}"
                                            alt="profile image"
                                            style="width:60px; height:60px; border-radius:100px;">
                                    </a>
                                </td>
                                <td>{{ $category->name }} </td>
                               
                             
                                <td>
                                    @if ($category->status == '1')
                                    <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                    <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>

                                    <a href="{{ route('category.edit', $category->id) }}" class="me-3">
                                        <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                    </a>


                                    <form id="deleteCat-{{ $category->id }}"
                                        action="{{ route('category.destroy', $category->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>


                                    <a onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteCat-{{ $category->id }}').submit(); } return false;"
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

                <button id="delete-selected-btn" class="btn btn-danger mt-3" style="display: none; "
                    onclick="deleteSelectedCategories()">Delete Selected
                </button>

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