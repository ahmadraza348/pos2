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
                        <h3>Reset Password</h3>
                        <h4>Enter your new password below.</h4>
                    </div>
                    <!-- Start of Updated Reset Password Form -->
                    <form action="{{ route('reset.password.post', ['token' => $token]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

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
                            <label>Password</label>
                            <div class="form-addons">
                                <input type="password" required name="password" id="form2Example11"
                                    class=" pass-input form-control" placeholder="Enter your new password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            <div class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-login">
                            <label>Confirm Password</label>
                            <div class="form-addons">
                                <input type="password" required name="password_confirmation"id="password"
                                    class=" form-control" placeholder="Confirm your new password">
                                </div>
                            <div class="text-danger">
                                @error('password_confirmation')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-login">
                            <button class="btn btn-login" type="submit">Reset Password</button>
                        </div>
                    </form>
                    <!-- End of Updated Reset Password Form -->
                </div>
            </div>
            <div class="login-img">
                <img src="{{ asset('backend/assets/img/login.jpg') }}" alt="img">
            </div>
        </div>
    </div>
</div>

@endsection
