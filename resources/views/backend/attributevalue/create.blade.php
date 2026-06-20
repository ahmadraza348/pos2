@extends('backend.layouts.layout')
@section('title', 'Create Attrbute Value ')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Attributes Values</h4>
                <h6>Add New Attribute Value</h6>
            </div>
        </div>

        <form method="post" class="" action="{{ route('attributevalue.store') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Category Name -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="name"> Name*</label>
                                <div class="form-control-wrap">
                                    <input type="text" required name="name" id="name" class="form-control"
                                        value="{{ old('name') }}">
                                    <div class="text-danger">
                                        @error('name')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="slug"> Slug*</label>
                                <div class="form-control-wrap">
                                    <input type="text" required name="slug" id="slug" class="form-control"
                                        value="{{ old('slug') }}">
                                    <div class="text-danger">
                                        @error('slug')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="attribute_id">Select Attribute*</label>
                                <select name="attribute_id" id="attribute_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach ($attributes as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('attribute_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                        <!-- Status -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="status">Status*</label>
                                <select name="status" required class="form-select" id="status">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>

<script>
    document.getElementById('attribute_id').addEventListener('change', function() {
        var colorInput = document.getElementById('colorinput');
        var selectedAttributeId = this.value;

        // Replace '1' with the actual ID of the "Color" attribute in your database
        if (selectedAttributeId == '4') { // Assuming 1 is the ID for "Color"
            colorInput.style.display = 'block';
        } else {
            colorInput.style.display = 'none';
        }
    });

    // Initial check if the page loads with a selected attribute
    document.addEventListener('DOMContentLoaded', function() {
        var selectedAttributeId = document.getElementById('attribute_id').value;
        var colorInput = document.getElementById('colorinput');

        if (selectedAttributeId == '1') { // Assuming 1 is the ID for "Color"
            colorInput.style.display = 'block';
        } else {
            colorInput.style.display = 'none';
        }
    });
</script>

@endsection