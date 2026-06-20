@extends('backend.layouts.layout')
@section('title', 'Edit Color')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h6>Edit Color</h6>
            </div>
        </div>

        <form method="post" action="{{ route('colors.update', $color->id) }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-4">

                        {{-- Name --}}
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="name">Name*</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $color->name) }}"
                                       required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="slug">Slug*</label>
                                <input type="text"
                                       id="slug"
                                       name="slug"
                                       class="form-control"
                                       value="{{ old('slug', $color->slug) }}"
                                       required>
                                @error('slug')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Color Code --}}
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="color_code">Color Code*</label>
                                <input type="color"
                                       id="color_code"
                                       name="color_code"
                                       class="form-control form-control-color"
                                       value="{{ old('color_code', $color->color_code) }}"
                                       required>
                                @error('color_code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="status">Status*</label>
                                <select id="status"
                                        name="status"
                                        class="form-select"
                                        required>
                                    <option value="1" {{ $color->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $color->status == 0 ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                            <a href="{{ route('colors.index') }}" class="btn btn-cancel">Cancel</a>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
