@extends('backend.layouts.layout')
@section('title', 'Manage Product Images - Raza Mall')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="mb-3">Manage Product Images —  <a href="{{ route('product.edit', $product->id) }}">{{ $product->name }}</a></h4>

        {{-- UPLOAD NEW IMAGES --}}
        <form action="{{ route('admin.product.store-images') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-4">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <select name="color_id" class="form-control">
                        <option value="">-- Select Color --</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <input type="file" name="images[]" multiple class="form-control" required>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>

        <hr>

        {{-- UPDATE + DELETE --}}
        <form action="{{ route('admin.product.update-images') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <table class="table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Featured (Main)</th>
                        <th>Back View</th>
                        <th>Sort</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($images as $img)
                    <tr>
                        <td>
                            <input type="checkbox" class="delete-check" name="delete_ids[]" value="{{ $img->id }}">
                        </td>
                        <td>
                            <img src="{{ asset('storage/'.$img->image) }}" width="80" class="img-thumbnail">
                        </td>
                        <td>
                            <select name="images[{{ $img->id }}][color_id]" class="form-control">
                                <option value="">Select Color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" {{ $img->color_id == $color->id ? 'selected' : '' }}>
                                        {{ $color->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-center">
                            <input type="radio" name="featured_id" value="{{ $img->id }}" {{ $img->is_featured ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input type="radio" name="back_id" value="{{ $img->id }}" {{ $img->is_back ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="number" name="images[{{ $img->id }}][sort_order]" value="{{ $img->sort_order }}" class="form-control" style="width:80px;">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Update All Settings</button>
                <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">Delete Selected</button>
            </div>
        </form>

        {{-- SEPARATE HIDDEN DELETE FORM --}}
        <form id="bulk-delete-form" action="{{ route('admin.product.delete-images') }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
            <div id="delete-input-container"></div>
        </form>
    </div>
</div>

<script>
    function confirmBulkDelete() {
        const selected = document.querySelectorAll('.delete-check:checked');
        if (selected.length === 0) {
            alert('Please select at least one image to delete.');
            return;
        }

        if (confirm('Are you sure you want to delete selected images?')) {
            const container = document.getElementById('delete-input-container');
            container.innerHTML = ''; // Clear previous
            
            selected.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
            
            document.getElementById('bulk-delete-form').submit();
        }
    }
</script>
@endsection