@extends('layouts.home.master-home')

@section('title') تکوان | ورود @endsection

@section('body')

<body>
    @endsection

    @section('content')

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="mt-2 font-size-20">اطلاعات حساب خود را وارد کنید</h5>
                            </div>
                        </div>
                        <div class="card-body text-right">
                            <div class="p-2">
                                <form method="POST" action="{{ route('login') }}" id="form" class="login--form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="mobile">شماره موبایل</label>
                                        <input type="mobile" required class="form-control
                                        @error('mobile') is-invalid @enderror" name="mobile"
                                            value="{{ old('mobile') }}" id="mobile" autofocus autocomplete="mobile">
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">پسورد</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" id="userpassword">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                    <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="6Le8Z-QaAAAAAImvSEAtV6Disqxo3f-h5ev0vKqI"></div>
                                    @error('g-recaptcha-response')
                                    <span class="invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <div class="custom-control custom-checkbox mt-5">
                                        <input type="checkbox" class="custom-control-input" name="remember"
                                            id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                            for="customControlInline">{{ __('به خاطر بسپار') }}</label>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" id="login"
                                            type="submit">ورود</button>
                                    </div>

                                    {{-- <div class="mt-4 text-center">
                                        <a href="{{ route('password.request') }}" class="text-muted"><i
                                        class="mdi mdi-lock mr-1"></i> {{ __('Forgot Your Password?') }}</a>
                            </div> --}}
                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>حساب کاربری ندارید؟<a href="register" class="font-weight-medium text-primary"> ثبت نام</a> </p>
                    <p>© <script>
                            document.write(new Date().getFullYear())
                        </script> تکوان</p>
                </div>

            </div>
        </div>
    </div>
    </div>

    @endsection

    @section('scripts')
    <!-- JAVASCRIPT -->
    <script src="{{ URL::asset('libs/jquery/jquery.min.js')}}"></script>

    <script src="{{ URL::asset('libs/jquery-validate/jquery.validate.js')}}"></script>

    <script src="{{ URL::asset('assets/js/auth.js')}}"></script>
    @endsection
