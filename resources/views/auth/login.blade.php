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
                                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="useremail">ایمیل</label>
                                        <input type="email"  required class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="useremail" autofocus  autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">پسورد</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" id="userpassword" >
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember" id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customControlInline">{{ __('به خاطر بسپار') }}</label>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" id="login" type="submit">ورود</button>
                                    </div>

                                    {{-- <div class="mt-4 text-center">
                                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock mr-1"></i> {{ __('Forgot Your Password?') }}</a>
                                    </div> --}}
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>حساب کاربری ندارید؟<a href="register" class="font-weight-medium text-primary"> ثبت نام</a> </p>
                        <p>© <script> document.write(new Date().getFullYear()) </script> تکوان</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ URL::asset('libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('libs/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('libs/metismenu/metismenu.min.js')}}"></script>
    <script src="{{ URL::asset('libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ URL::asset('libs/node-waves/node-waves.min.js')}}"></script>

    <script src="{{ URL::asset('js/app.min.js')}}"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
        </script>

    @endsection