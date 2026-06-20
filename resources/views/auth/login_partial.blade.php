  <div class="login-reg-form-wrap mt-md-34 mt-sm-34">
                            <h2>Login</h2>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                    
                        
                                             
                                <!-- Username or  Email -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="single-input-item">
                                            <label class="form-label" for="username">Username or Email</label>
                                            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Username or Email" required />
                                            @error('username')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                    </div>

                                </div>
                
                    
                                <!-- Password and Confirm Password -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="single-input-item">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" name="password" placeholder="Enter your Password" required />
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                
                                </div>

                                <div class="single-input-item">
                                    <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                        <div class="remember-meta">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember_me">
                                                <label class="custom-control-label" for="remember_me"name="remember">Remember Me</label>
                                            </div>
                                        </div>
                                        @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forget-pwd">Forget Password?</a>
                                        @endif
                                    </div>
                                </div>
                    
                             
                    
                                <!-- Submit Button -->
                                <div class="single-input-item">
                                    <button type="submit" class="sqr-btn">Login</button>
                                </div>
                               <p class="mt-2">Not a member yet? <a class="forget-pwd " href="{{route('register')}}">Register Now</a> </p> 
                            </form>
                        </div>