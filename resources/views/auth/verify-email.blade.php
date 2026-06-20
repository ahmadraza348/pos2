    @extends('frontend.layouts.layout')
    @section('content')
        <div class="login-register-wrapper">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row justify-content-center">

                        <div class="login-reg-form-wrap mt-md-34 mt-sm-34">
                            <!-- Informational Message -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="single-input-item">
                                        <p class="text-sm text-gray-600">
                                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Verification Status Message -->
                            @if (session('status') == 'verification-link-sent')
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="single-input-item">
                                            <p class="font-medium text-sm text-success">
                                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- Resend Verification Email -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="single-input-item">
                                        <form method="POST" action="{{ route('verification.send') }}">
                                            @csrf
                                            <button type="submit" class="sqr-btn">
                                                {{ __('Resend Verification Email') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="single-input-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
