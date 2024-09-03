@extends('layouts.app')
@section('content')
    <div class="login_pages_contents_inr11">
        <div class="login_pages_contents_inr text-center">
            <a href="{{ route('login') }}">
                <img src="{{ asset('logo/logo.gif') }}" style="width: 400px" alt=""></a>
            {{-- <img src="{{ @$setting->logo ? Storage::url($setting->logo) : asset('images/logo.png') }}" alt=""></a> --}}
            <div class="login_pages_contents_hdngg">
                <h5>Login</h5>
                <p>Welcome back! please enter your details</p>
            </div>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="login_pages_contents_inr_form">
                    <div class="row login_pages_contents_inr_form_row">
                        <div class="col-lg-12 login_pages_contents_inr_form_col">
                            <div class="input_form_holderr">
                                <h6>Email Address Or Phone Number</h6>
                                <input type="text" class="w-100 @error('email') is-invalid @enderror" id="email"
                                    placeholder="company@example.com" name="email" value="{{old('email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12 login_pages_contents_inr_form_col">
                            <div class="input_form_holderr password_hold" data-toggle-password>
                                <h6>Password</h6>
                                <input type="password" class=" @error('password') is-invalid @enderror"
                                    placeholder="*********" id="password" name="password">
                                <a href="Javascript:void(0);" class="toggle_open_eye"></a>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12 login_pages_contents_inr_form_col">
                            <div class="row remember_pass_row">
                                <div class="col-6 remember_pass_col_in">
                                    <div class="custom_checked_remmbr">
                                        <div class="form_input_check">
                                            <label>
                                                <input type="checkbox" name="remember" id="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <span>Remember session?</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 remember_pass_col_in">
                                    <a href="{{ route('password.request') }}" class="cmn_anc_nn">Forgot password?</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 login_pages_contents_inr_form_col">
                            <button type="submit">Sign in</button>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find the eye button and password input
            var eyeButton = document.querySelector('.toggle_open_eye');
            var passwordInput = document.getElementById('password');

            // Add click event listener to the eye button
            eyeButton.addEventListener('click', function() {
                // Toggle the type attribute of the password input between 'password' and 'text'
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            });
        });
    </script>
@endsection
