@extends('backend.layouts.layout')
@section('content')

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Admin User</h4>
                <h6>Edit Admin User Detail</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- Use update route with PUT method -->
                <form method="post" action="{{ route('admin.user.update', $admin_data->id) }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="first_name">First Name*</label>
                                <div class="form-control-wrap">
                                    <input type="text" required name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $admin_data->first_name) }}">
                                    <div class="text-danger">
                                        @error('first_name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="last_name">Last Name*</label>
                                <div class="form-control-wrap">
                                    <input type="text" required name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $admin_data->last_name) }}">
                                    <div class="text-danger">
                                        @error('last_name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="username">Username*</label>
                                <div class="form-control-wrap">
                                    <input type="text" required name="username" id="username" class="form-control" value="{{ old('username', $admin_data->username) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Username should be unique">
                                    <div class="text-danger">
                                        @error('username')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="email">Email*</label>
                                <div class="form-control-wrap">
                                    <input type="email" required class="form-control" id="email" name="email" value="{{ old('email', $admin_data->email) }}">
                                    <div class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Optional Password Fields -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="password">Password</label>
                                <div class="form-control-wrap">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                                    <div class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="form-control-wrap">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Leave blank to keep current password">
                                    <div class="text-danger">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Status Field -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="role">Role*</label>
                                <div class="">
                                    <select name="role" required class="form-select" id="role">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role', $admin_data->roles->first()->id ?? null) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                         <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form-label" for="status">Status*</label>
                                <div class="">
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status', $admin_data->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $admin_data->status) == '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <!-- Submit and Cancel Buttons -->
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                            <a href="{{ route('admin.user.show') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
