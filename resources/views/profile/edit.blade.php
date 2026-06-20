{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('frontend.layouts.layout')
@section('content')
    <div class="my-account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="active" data-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Dashboard</a>
                                    <a href="#account-info" data-toggle="tab"><i class="fa fa-user"></i> Account Details</a>
                                    <a href="#orders" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                    <a href="#download" data-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a>
                                    <a href="#payment-method" data-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                                        Method</a>
                                    <a href="#address-edit" data-toggle="tab"><i class="fa fa-map-marker"></i> address</a>
                                    <a href="login-register.html"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong>{{ Auth::user()->first_name }} </strong> (If Not
                                                    <strong>{{ Auth::user()->first_name }}!</strong><a
                                                        href="javascript:void(0);" id="userlogout" class="logout"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        Logout
                                                    </a>)

                                                <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                                </p>
                                            </div>
                                            <p class="mb-0">From your account dashboard. you can easily check & view your
                                                recent orders, manage your shipping and billing addresses and edit your
                                                password and account details.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Account Details</h3>
                                            <div class="account-details-form">

                                                <form id="send-verification" method="post"
                                                    action="{{ route('verification.send') }}">
                                                    @csrf
                                                </form>


                                                <form method="POST" action="{{ route('profile.update') }}">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="row">
                                                        <!-- First Name -->
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="first-name" class="required">First Name</label>
                                                                <input type="text" id="first-name" name="first_name"
                                                                    placeholder="First Name"
                                                                    value="{{ Auth::user()->first_name }}" />
                                                                @error('first_name')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <!-- Last Name -->
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="last-name" class="required">Last Name</label>
                                                                <input type="text" id="last-name" name="last_name"
                                                                    placeholder="Last Name"
                                                                    value="{{ Auth::user()->last_name }}" />
                                                                @error('last_name')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Username -->
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="display-name" class="required">Username</label>
                                                                <input type="text" id="display-name" name="username"
                                                                    placeholder="Display Name"
                                                                    value="{{ Auth::user()->username }}" />
                                                                @error('username')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- Phone -->
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="lphone" class="required">Phone</label>
                                                                <input type="number" id="lphone" name="phone"
                                                                    placeholder="Contact number"
                                                                    value="{{ Auth::user()->phone }}" />
                                                                @error('phone')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Date of Birth and Gender -->
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="dob">Date of Birth</label>
                                                                <input type="date" id="dob" name="dob"
                                                                    value="{{ Auth::user()->dob }}" />
                                                                @error('dob')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="gender">Gender</label>
                                                                <select name="gender" id="gender">
                                                                    <option value="">Select Gender</option>
                                                                    <option value="male"
                                                                        {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>
                                                                        Male</option>
                                                                    <option value="female"
                                                                        {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>
                                                                        Female</option>
                                                                    <option value="other"
                                                                        {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>
                                                                        Other</option>
                                                                </select>
                                                                @error('gender')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="single-input-item">
                                                        <label for="email" class="required">Email Address</label>
                                                        <input type="email" id="email" name="email"
                                                            placeholder="Email Address"
                                                            value="{{ Auth::user()->email }}" />
                                                        @error('email')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                                        <div>
                                                            <p class="text-sm mt-4 ">
                                                                {{ __('Your email address is unverified.') }}

                                                                <button form="send-verification"
                                                                    class="btn btn-info btn-sm">
                                                                    {{ __('Click here to re-send the verification email.') }}
                                                                </button>
                                                            </p>

                                                            @if (session('status') === 'verification-link-sent')
                                                                <p class="mt-2 font-medium text-sm text-green-600">
                                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <div class="single-input-item ">
                                                        <button class="check-btn sqr-btn "type="submit">Save
                                                            Changes</button>
                                                    </div>
                                                </form>


                                                <!-- Password Fields -->
                                                <form class="mt-5" action="{{ route('password.update') }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <fieldset>
                                                        <legend>Password change</legend>
                                                        <div class="single-input-item">
                                                            <label for="current-pwd" class="required">Current Password</label>
                                                            <input type="password" id="update_password_current_password"
                                                                name="current_password" placeholder="Current Password" value="{{ old('current_password') }}" />
                                                            @error('current_password', 'updatePassword')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="new-pwd" class="required">New Password</label>
                                                                    <input type="password" id="update_password_password"
                                                                        name="password" placeholder="New Password" />
                                                                    @error('password', 'updatePassword')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="confirm-pwd" class="required">Confirm Password</label>
                                                                    <input type="password" id="update_password_password_confirmation"
                                                                        name="password_confirmation" placeholder="Confirm Password" />
                                                                    @error('password_confirmation', 'updatePassword')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <button class="check-btn sqr-btn" type="submit">Update</button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                                

                                                {{-- <section class="space-y-6">
                                                    <header>
                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Delete Account') }}
                                                        </h2>
                                                
                                                        <p class="mt-1 text-sm text-gray-600">
                                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                                                        </p>
                                                    </header>
                                                
                                                    <x-danger-button
                                                        x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                                    >{{ __('Delete Account') }}</x-danger-button>
                                                
                                                    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                                            @csrf
                                                            @method('delete')
                                                
                                                            <h2 class="text-lg font-medium text-gray-900">
                                                                {{ __('Are you sure you want to delete your account?') }}
                                                            </h2>
                                                
                                                            <p class="mt-1 text-sm text-gray-600">
                                                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                                            </p>
                                                
                                                            <div class="mt-6">
                                                                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                                                
                                                                <x-text-input
                                                                    id="password"
                                                                    name="password"
                                                                    type="password"
                                                                    class="mt-1 block w-3/4"
                                                                    placeholder="{{ __('Password') }}"
                                                                />
                                                
                                                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                                            </div>
                                                
                                                            <div class="mt-6 flex justify-end">
                                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                                    {{ __('Cancel') }}
                                                                </x-secondary-button>
                                                
                                                                <x-danger-button class="ms-3">
                                                                    {{ __('Delete Account') }}
                                                                </x-danger-button>
                                                            </div>
                                                        </form>
                                                    </x-modal>
                                                </section> --}}

                                                <fieldset>
                                                    <legend>Delete Account</legend>
                                                    <header>
                                                
                                                        <p class="mt-1 text-sm text-gray-600">
                                                            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                                                        </p>
                                                    </header>
                                                
                                                    <!-- Delete Account Button -->
                                                    <div>
                                                        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="  mt-3 btn-sm">
                                                            Delete Account
                                                        </x-primary-button>



                                                    </div>
                                                
                                                    <!-- Confirmation Modal -->
                                                    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                        <form method="POST" action="{{ route('profile.destroy') }}" class="mt-3">
                                                            @csrf
                                                            @method('delete')
                                                
                                                            <h4 class="text-lg font-medium ">Are you sure you want to delete your account?</h4>
                                                
                                                            <p class="tect-danger">
                                                                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.
                                                            </p>
                                                
                                                            <!-- Password Input -->
                                                            <div class="single-input-item mt-6">
                                                                <label for="password" class="required sr-only">Password</label>
                                                                <input type="password" id="password" name="password" class="single-input-item w-full" placeholder="Password" />
                                                                @error('password')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                
                                                            <!-- Modal Actions -->
                                                            <div class="mt-6 flex justify-end">
                                                                <button x-on:click="$dispatch('close')" class="btn btn-primary me-3">
                                                                    Cancel
                                                                </button>
                                                
                                                                <button class="check-btn btn-danger btn-sm danger-btn">
                                                                    Delete Account
                                                                </button>
                                                                
                                                            </div>
                                                        </form>
                                                    </x-modal>
                                                </fieldset>
{{-- 
                                                <section class="myaccount-content space-y-6">
                                           
                                                </section>
                                                 --}}

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Aug 22, 2018</td>
                                                            <td>Pending</td>
                                                            <td>$3000</td>
                                                            <td><a href="cart.html" class="check-btn sqr-btn ">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>July 22, 2018</td>
                                                            <td>Approved</td>
                                                            <td>$200</td>
                                                            <td><a href="cart.html" class="check-btn sqr-btn ">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>June 12, 2017</td>
                                                            <td>On Hold</td>
                                                            <td>$990</td>
                                                            <td><a href="cart.html" class="check-btn sqr-btn ">View</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="download" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Downloads</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Date</th>
                                                            <th>Expire</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Haven - Free Real Estate PSD Template</td>
                                                            <td>Aug 22, 2018</td>
                                                            <td>Yes</td>
                                                            <td><a href="#" class="check-btn sqr-btn "><i
                                                                        class="fa fa-cloud-download"></i> Download File</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>HasTech - Profolio Business Template</td>
                                                            <td>Sep 12, 2018</td>
                                                            <td>Never</td>
                                                            <td><a href="#" class="check-btn sqr-btn "><i
                                                                        class="fa fa-cloud-download"></i> Download File</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Payment Method</h3>
                                            <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Billing Address</h3>
                                            <address>
                                                <p><strong>Alex Tuntuni</strong></p>
                                                <p>1355 Market St, Suite 900 <br>
                                                    San Francisco, CA 94103</p>
                                                <p>Mobile: (123) 456-7890</p>
                                            </address>
                                            <a href="#" class="check-btn sqr-btn "><i class="fa fa-edit"></i> Edit
                                                Address</a>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
@endsection
