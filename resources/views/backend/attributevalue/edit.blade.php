@extends('backend.layouts.layout')
@section('title', 'Edit Attribute Value')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Attribute Value</h4>
                <h6>Edit Attribute</h6>
            </div>
        </div>

        <form method="post" class="" action="{{ route('attributevalue.update', $attributevalue->id) }}">
            @csrf
            @method('PUT') <!-- Use PUT method for updating -->

            <div class="card">
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Category Name -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="name"> Name*</label>
                                <div class="form-control-wrap">
                                    <input type="text" required name="name" id="name" class="form-control"
                                        value="{{ old('name', $attributevalue->name) }}"> <!-- Pre-fill name field -->
                                    <div class="text-danger">
                                        @error('name')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Slug -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="slug"> Slug*</label>
                                <div class="form-control-wrap">
                                    <input type="text" required name="slug" id="slug" class="form-control"
                                        value="{{ old('slug', $attributevalue->slug) }}"> <!-- Pre-fill slug field -->
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
                                    <!-- Ensure current category is excluded and parent category is selected -->
                                    <option value="{{ $item->id }}"
                                        {{ old('attribute_id', $attributevalue->attribute_id) == $item->id ? 'selected' : '' }}>
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
                                    <option value="1" {{ old('status', $attributevalue->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $attributevalue->status) == '0' ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection