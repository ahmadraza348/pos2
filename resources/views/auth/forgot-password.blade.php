@extends('frontend.layouts.layout')
@section('content')
    <!-- Session Status -->
    
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="login-register-wrapper">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row justify-content-center">
                        
                        <div class="login-reg-form-wrap mt-md-34 mt-sm-34">
                            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="single-input-item">
                                    <label class="form-label" for="email">Email Address</label>
                                    <input type="email" id="dob" name="email" value="{{ old('email') }}"required
                                        placeholder="Your Email" />
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="single-input-item">
                                <button type="submit" class="sqr-btn">Email password reset link</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </form>
@endsection
