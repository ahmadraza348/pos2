@extends('backend.layouts.layout')
@section('title', 'Add A Product Attribute - Raza Mall')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-title">
                    <h4>Add Product Attribute - <a href="{{ route('product.edit', $product->id) }}">{{ $product->name }}</a> </h4>
                </div>
            </div>

            {{-- Attribute Form --}}
            <form method="POST" id="attributeForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="id" id="edit_id" value="">

                @if (!empty($attribute_data))
                    <input type="hidden" name="attribute_id" value="{{ $attribute_data->id }}" class="form-control">
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item Code*</th>
                                        <th>Color*</th>
                                        @if (!empty($attribute_data))
                                            <th>{{ $attribute_data->name }}*</th>
                                        @endif
                                        <th>Stock*</th>
                                        <th>Price*</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="number" name="itemcode" class="form-control" required
                                                placeholder="Item Code">
                                        </td>

                                        @if (!empty($colors))
                                            <td>
                                                <select name="color_id" class="form-select" style="width:150px" required>
                                                    <option value="">Select Color</option>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endif

                                        @if (!empty($attribute_data))
                                            <td>
                                                <select name="attribute_value_id" class="form-select" style="width:150px"
                                                    required>
                                                    <option value="">Select {{ $attribute_data->name }}</option>
                                                    @foreach ($attribute_data->attributevalue as $attr)
                                                        <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endif

                                        <td>
                                            <input type="number" name="stock" class="form-control" required
                                                placeholder="Stock">
                                        </td>

                                        <td>
                                            <input type="number" name="price" class="form-control" required
                                                placeholder="Price">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group m-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>


            {{-- Product Attribute List --}}
            <div class="page-header mt-5">
                <div class="page-title">
                    <h4>All Product Attributes</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Color</th>
                                    @if (!empty($attribute_data))
                                        <th>{{ $attribute_data->name }}</th>
                                    @endif
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="attributeTableBody">
                                <!-- Filled dynamically by AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            let product_id = "{{ $product->id }}";

            // ----------------------------
            // Fetch Attributes on Load
            // ----------------------------
            fetchAttributes();

            function fetchAttributes() {
                $.ajax({
                    url: "{{ route('admin.pro.attribute.fetch', ':id') }}".replace(':id', product_id),
                    method: "GET",
                    success: function(response) {
                        // console.log(response)
                        if (response.status === 'success') {
                            let rows = '';

                            if (response.data.length === 0) {
                                rows =
                                    `<tr><td colspan="7" class="text-center">No attributes found.</td></tr>`;
                            } else {
                                $.each(response.data, function(index, item) {
                                    rows += `
                                <tr>
                                    <td>${item.itemcode ?? '-'}</td>
                                    <td>${item.color ? item.color.name : '-'}</td>
                                    @if (!empty($attribute_data))
                                    <td>${item.attribute_value ? item.attribute_value.name : '-'}</td>
                                    @endif
                                    <td>${item.stock ?? '-'}</td>
                                    <td>${item.price ?? '-'}</td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary editAttrBtn"
                                            data-id="${item.id}"
                                            data-itemcode="${item.itemcode}"
                                            data-color_id="${item.color_id}"
                                            @if (!empty($attribute_data)) data-varient_id="${item.attribute_value_id}" @endif
                                            data-stock="${item.stock}"
                                            data-price="${item.price}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteAttrBtn"
                                            data-id="${item.id}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                                });
                            }

                            $('#attributeTableBody').html(rows);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error fetching attributes!');
                    }

                });
            }

            // ----------------------------
            // Handle Edit Button
            // ----------------------------
            $(document).on('click', '.editAttrBtn', function() {
                let id = $(this).data('id');
                $('#edit_id').val(id);

                $('input[name="itemcode"]').val($(this).data('itemcode'));
                $('select[name="color_id"]').val($(this).data('color_id'));
                $('select[name="attribute_value_id"]').val($(this).data('varient_id'));
                $('input[name="stock"]').val($(this).data('stock'));
                $('input[name="price"]').val($(this).data('price'));

                $('button[type="submit"]').text('Update');
            });


            // ----------------------------
            // Handle Form Submit (Add / Update)
            // ----------------------------
            $('#attributeForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let editId = $('#edit_id').val();
                let url = editId ?
                    "{{ route('admin.pro.attribute.update', ':id') }}".replace(':id', editId) :
                    "{{ route('admin.pro.attribute.store') }}";

                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true).text('Saving...');
                    },
                    success: function(response) {
                        $('button[type="submit"]').prop('disabled', false).text('Submit');

                        if (response.status === 'success') {
                            alert(response.message);

                            // Reset form
                            $('#attributeForm')[0].reset();
                            $('#edit_id').val('');
                            $('button[type="submit"]').text('Submit');

                            // Refresh table
                            fetchAttributes();
                        } else {
                            alert('Something went wrong!');
                        }
                    },
                    error: function(xhr) {
                        $('button[type="submit"]').prop('disabled', false).text('Submit');
                        console.log(xhr.responseText);
                        alert('Error saving attributes!');
                    }
                });
            });

            // ----------------------------
            // Handle Delete Button
            // ----------------------------

            $(document).on('click', '.deleteAttrBtn', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let deleteUrl = "{{ route('admin.pro.attribute.delete', ':id') }}".replace(':id', id);

                if (!confirm("Are you sure you want to delete this attribute?")) {
                    return;
                }

                $.ajax({
                    url: deleteUrl,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status === 'success') {

                            alert(res.message);

                            // Reset form state if the deleted item was being edited
                            let currentEditId = $('#edit_id').val();
                            if (currentEditId == id) {
                                $('#attributeForm')[0].reset();
                                $('#edit_id').val('');
                                $('button[type="submit"]').text('Submit');
                            }

                            fetchAttributes();
                        } else {
                            alert("Deletion failed.");
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("Server error while deleting.");
                    }
                });
            });
        });
    </script>

@endsection
