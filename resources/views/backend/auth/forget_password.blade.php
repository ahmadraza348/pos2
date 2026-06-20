@extends('backend.auth.layouts.layout')
@section('content')

<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <div class="login-userset ">
                    <div class="login-logo">
                        <img src="{{ asset('backend/assets/img/logo.png') }}" alt="img">
                    </div>
                    <div class="login-userheading">
                        <h3>Forgot password?</h3>
                        <h4>Don’t worry! It happens. Please enter the address <br>
                            associated with your account.</h4>
                    </div>
                    <!-- Start of Updated Form -->
                    <form action="{{ route('admin.forgetpass.submit') }}" method="POST">
                        @csrf
                        <div class="form-login">
                            <label>Email</label>
                            <div class="form-addons">
                                <input type="email" required name="email" id="form2Example11"
                                    class="form-control" placeholder="Enter your email address"
                                    value="{{ old('email') }}">
                                <img src="{{ asset('backend/assets/img/icons/mail.svg') }}" alt="img">
                            </div>
                            <div class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-login">
                            <button class="btn btn-login" type="submit">Send Password Reset Link</button>
                        </div>
                    </form>
                    <!-- End of Updated Form -->
                </div>
            </div>
            <div class="login-img">
                <img src="{{ asset('backend/assets/img/login.jpg') }}" alt="img">
            </div>
        </div>
    </div>
</div>

@endsection
