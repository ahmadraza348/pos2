@extends('backend.layouts.layout')
@section('title', 'Create Color')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h6>Add New Color</h6>
            </div>
        </div>

        <form method="post" action="{{ route('colors.store') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-4">

                        <!-- Name -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="name">Name*</label>
                                <input type="text"
                                    name="name"
                                    id="name"
                                    required
                                    class="form-control"
                                    value="{{ old('name') }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="col-lg-6 col-sm-12 ">
                            <div class="form-group mb-0">
                                <label class="form-label" for="slug">Slug*</label>
                                <input type="text"
                                    name="slug"
                                    id="slug"
                                    required
                                    class="form-control"
                                    value="{{ old('slug') }}">
                                @error('slug')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
              
                        <!-- Color Code (HEX) -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="colorcode">Color Code*</label>
                                <input type="color"
                                    name="color_code"
                                    id="colorcode"
                                    required
                                    class="form-control form-control-color"
                                    value="{{ old('colorcode') ?? '#000000' }}">
                                @error('colorcode')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="status">Status*</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection