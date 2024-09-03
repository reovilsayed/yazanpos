@extends('layouts.app')
@section('content')
    <div class="login_pages_contents_inr11">
        <div class="login_pages_contents_inr col-md-12 text-center">
            <a href="{{ route('dashboard') }}" class="main_img"><img
                    src="{{ @$setting->logo ? Storage::url($setting->logo) : asset('images/logo.png') }}" alt=""
                    width="200"></a>
            <div class="login_pages_contents_hdngg">
                <h5 class="text-start">Forgot Password?</h5>
                <p>Enter Your Email and we will send a mail to you Email.</p>
            </div>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="login_pages_contents_inr_form">
                    <div class="row login_pages_contents_inr_form_row">
                        <div class="col-lg-12 login_pages_contents_inr_form_col">
                            <div class="input_form_holderr">
                                <h6>Email Address</h6>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>





                    </div>
                </div>

                <div class="row mb-0 mt-2">

                    <div class="col-lg-12 login_pages_contents_inr_form_col">
                        <button type="submit" class="">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
