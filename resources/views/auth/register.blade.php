@extends('frontend.layouts.layout')
@section('content')  

    <!-- login register wrapper start -->
    <div class="login-register-wrapper">
        <div class="container">
            <div class="member-area-from-wrap">
                <div class="row justify-content-center">
    
                    <!-- Register Content Start -->
                    <div class="col-lg-8">
                        @include('message')
                        <div class="login-reg-form-wrap mt-md-34 mt-sm-34">
                            <h2>Register</h2>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                    
                                <!-- First Name and Last Name -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="first_name">First Name</label>
                                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required />
                                            @error('first_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="last_name">Last Name</label>
                                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required />
                                            @error('last_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Username and Email -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Username" required />
                                            @error('username')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your Email" required />
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Phone and Gender -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="phone">Phone</label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your Phone Number" required />
                                            @error('phone')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="gender">Gender</label>
                                            <select name="gender" id="gender" >
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Date of Birth -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="single-input-item">
                                            <label class="form-label" for="dob">Date of Birth</label>
                                            <input type="date" id="dob" name="dob" value="{{ old('dob') }}" placeholder="Date of Birth" />
                                            @error('dob')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Password and Confirm Password -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" name="password" placeholder="Enter your Password" required />
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat your Password" required />
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Newsletter Subscription -->
                                <div class="single-input-item">
                                    <div class="login-reg-form-meta">
                                        <div class="remember-meta">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="subnewsletter">
                                                <label class="custom-control-label" for="subnewsletter">Subscribe to Our Newsletter</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Submit Button -->
                                <div class="single-input-item">
                                    <button type="submit" class="sqr-btn">Register</button>
                                </div>
                                <p class="mt-2">Alredy have an account? <a class="forget-pwd " href="{{route('login')}}">Login Now</a> </p> 

                            </form>
                        </div>
                    </div>
                    
                    <!-- Register Content End -->
    
                </div>
            </div>
        </div>
    </div>
    
@endsection
