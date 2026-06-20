
@extends('frontend.layouts.layout')
@section('content')  

    <!-- login register wrapper start -->
    <div class="login-register-wrapper">
        <div class="container">
            <div class="member-area-from-wrap">
                <div class="row justify-content-center">
    
                    <!-- Register Content Start -->
                    <div class="col-lg-6">
                        @include('message')
                      @include('auth.login_partial')
                    </div>
                    
                    <!-- Register Content End -->
    
                </div>
            </div>
        </div>
    </div>
    
@endsection




