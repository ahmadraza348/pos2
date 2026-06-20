@extends('backend.layouts.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Profile</h4>
                    <h6>Admin  Profile </h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.user.profile.update', $user->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="profile-set">
                            <div class="profile-head">
                            </div>
                            <div class="profile-top">
                                <div class="profile-content">
                                    <div class="profile-contentimg">
                                        <!-- Display current profile image, default if not available -->
                                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/customer/customer5.jpg') }}"
                                            alt="img" id="blah">
                                        <div class="profileupload">
                                            <input type="file" id="imgInp" name="image" accept="image/*">
                                            <a href="javascript:void(0);">
                                                <img src="{{ asset('backend/assets/img/icons/edit-set.svg') }}"
                                                    alt="img">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="profile-contentname">
                                        <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
                                        <h4>Update Your Photo and Personal Details.</h4>
                                    </div>
                                </div>
                                {{-- <div class="ms-auto">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                        </div> --}}

                            </div>
                        </div>

                        <!-- Profile Form -->


                        <div class="row">
                            <!-- First Name -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name"
                                        value="{{ old('first_name', $user->first_name) }}" class="form-control"
                                        placeholder="William">
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                        class="form-control" placeholder="Castillo">
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-control" placeholder="william@example.com">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Gender -->
                            {{-- <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <input type="text" name="gender" value="{{ old('gender', $user->gender) }}" class="form-control" placeholder="Male/Female">
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="gender">Gender*</label>
                                    <div class="">
                                        <select name="gender" required class="form-select" id="gender">
                                            <option value="">select</option>
                                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- Phone -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="form-control" placeholder="+1452 876 5432">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                        class="form-control" placeholder="william123">
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Leave blank if you don't want to change">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Leave blank if you don't want to change">
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{route('admin.user.profile')}}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
