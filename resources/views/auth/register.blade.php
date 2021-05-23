@extends('layouts.home.master-home')

@section('title') تکوان | ثبت نام @endsection

@section('css')
    <style>
        .hidden{
            display:none;
        }
        .show{
            display:block;
        }
    </style>
@endsection
@section('body')

<body>
    @endsection

    @section('content')
    {{-- @php
        dd($message);
    @endphp --}}

    <div class="home-btn d-none d-sm-block">
        <a href="index" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h3 class=" font-size-20 mt-2">یک حساب کاربری ایجاد کنید</h3>

                            </div>

                        </div>
                        <div class="card-body pt-3 text-right">

                            <div class="p-2">
                                <form method="POST" id="form" action="{{ route('register') }}" class="needs-validation register--form"
                                    novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="useremail">ایمیل</label>
                                        <input type="email" name="email" required
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" id="useremail" autofocus autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="useremail">موبایل</label>
                                        <input type="number" name="mobile" required
                                            class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                            value="{{ old('mobile') }}" id="usermobile" autofocus autocomplete="mobile">
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <button href="#" onclick="confirmMobile(event)" class="btn btn-info btn-sm sms-btn">ارسال پیامک تایید شماره موبایل <i class="icon-envelope"></i></button>

                                        <div class="form-group code-wrapper-input my-3">
                                            <label for="useremail">ارسال کد تایید </label>
                                            <input type="number"  required
                                                class="form-control  @error('code') is-invalid @enderror" name="code"
                                                value="" id="" autofocus >
                                                @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                        </div>


                                    <div class="form-group">
                                        <label for="name">نام</label>
                                        <input type="text" name="fname" value="{{ old('fname') }}" required
                                            autocomplete="fname"
                                            class="form-control @error('fname') is-invalid @enderror" autofocus
                                            id="fname">
                                        @error('fname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">نام خانوادگی</label>
                                        <input type="text" name="lname" value="{{ old('lname') }}" required
                                            autocomplete="lname"
                                            class="form-control @error('lname') is-invalid @enderror" autofocus
                                            id="lname">
                                        @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">نام کاربری</label>
                                        <input type="text" name="username" value="{{ old('username') }}" required
                                            autocomplete="username"
                                            class="form-control @error('username') is-invalid @enderror" autofocus
                                            id="username">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">پسورد</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" id="password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">تایید پسورد</label>
                                        <input type="password" required name="password_confirmation"
                                            class="form-control" id="userconfirmpassword">
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" id="register"
                                            type="submit"> ثبت نام</button>
                                    </div>

                                    {{-- <div class="mt-4 text-center">
                                        <p class="mb-0">By registering you agree to the Skote <a href="#" class="text-primary">Terms of Use</a></p>
                                    </div> --}}
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>از قبل حساب کاربری ایجاد کرده اید؟ <a href="login" class="font-weight-medium text-primary">
                                ورود</a> </p>
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
