@extends('backend.auth.layouts.layout')
@section('content')
   

<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <div class="login-userset">
                    <div class="login-logo">
                        <img src="{{ asset('backend/assets/img/logo.png') }}" alt="img">
                    </div>
                    <div class="login-userheading">
                        <h3>Sign In</h3>
                        <h4>Please login to your account</h4>
                    </div>

                    <!-- Start of Updated Form -->
                    <form method="post" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="form-login">
                            <label>Email or Username</label>
                            <div class="form-addons">
                                <input type="text" name="email_username" required id="email_username"
                                    class="form-control" value="{{ old('email_username') }}"
                                    placeholder="Enter your email address or username">
                                <img src="{{ asset('backend/assets/img/icons/mail.svg') }}" alt="img">
                            </div>
                            <div class="text-danger">
                                @error('email_username')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-login">
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" required name="password" class="pass-input"
                                    id="password" placeholder="Enter your password">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                            <div class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-login">
                            <div class="alreadyuser">
                                <h4><a href="{{ route('admin.forgetpass') }}" class="hover-a">Forgot Password?</a></h4>
                            </div>
                        </div>

                        <div class="form-login">
                            <button class="btn btn-login" type="submit">Sign In</button>
                        </div>
                    </form>
                    <!-- End of Updated Form -->

                    <!-- Start of Quick Login (demo accounts) -->
                    {{--
                        SECURITY NOTE: this box used to contain the REAL
                        super admin's email/password in plain text in the
                        page source. That is how the account was
                        compromised and the data was deleted. It has been
                        replaced with two low-privilege demo accounts
                        ("Admin" and "Cashier" roles - see RoleSeeder) that
                        cannot edit or delete anything, so it is safe to
                        expose their credentials here for recruiters/demo
                        purposes. The real admin account is never shown on
                        this page or anywhere in the frontend.
                    --}}
                    <div class="form-login quick-login-box">
                        <label class="d-block mb-2">Quick Login (Demo Accounts)</label>
                        <div class="d-flex" style="gap:10px;">
                            <button type="button" class="btn btn-outline-primary w-100"
                                onclick="quickLogin('demo_admin', 'Demo@Admin123')">
                                Admin (view &amp; create only)
                            </button>
                            <button type="button" class="btn btn-outline-secondary w-100"
                                onclick="quickLogin('demo_cashier', 'Demo@Cashier123')">
                                Cashier (POS only)
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">
                            Both demo accounts are restricted: they can view the panel and create new
                            records, but cannot edit or delete anything.
                        </small>
                    </div>
                    <script>
                        function quickLogin(usernameOrEmail, password) {
                            document.getElementById('email_username').value = usernameOrEmail;
                            document.getElementById('password').value = password;
                        }
                    </script>
                    <!-- End of Quick Login (demo accounts) -->

                </div>
            </div>
            <div class="login-img">
                <img src="{{ asset('backend/assets/img/login.jpg') }}" alt="img">
            </div>
        </div>
    </div>
</div>

@endsection