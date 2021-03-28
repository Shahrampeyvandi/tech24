@extends('layouts.home.master-home')

@section('title') تکوان | بازیابی رمز عبور @endsection

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
                                <h5 class="mt-2 font-size-20">رمز عبور جدید خود را وارد نمایید</h5>

                            </div>
                        </div>
                        <div class="card-body text-right">
                            <div class="p-2">
                                <form method="POST" action="{{ route('password.sendcode') }}" id="form">
                                    @csrf
                                    <input type="hidden" name="mobile" value="{{ $mobile }}">
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

                                    <div class="form-group">
                                        <label for="">کد ارسالی به شماره موبایل</label>
                                        <input type="text" required name="code"
                                        class="form-control @error('code') is-invalid @enderror" >
                                            @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>




                                 
                                

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" id="login"
                                            type="submit">ارسال پیامک بازیابی رمز عبور</button>
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

    <script>
        $.validator.addMethod(
    "regex",
    function(value, element, regexp) {
        return this.optional(element) || regexp.test(value);
    },
    "Please check your input."
);
    $("#form").validate({
		rules: {
            code: {
				required: true,
			
			},
            password: {
				required: true,
				minlength: 6
			},
			password_confirmation: {
				required: true,
				equalTo: "#password"
			},
		
		},
		messages: {
            code: {
				required: "کد ارسالی را وارد نمایید",
			},
            password: {
				required: "رمز عبور دا وارد نمایید",
				minlength: "رمز عبور بایستی حداقل 6 کاراکتر باشد"
			},
			password_confirmation: {
				required: "رمز عبور را وارد نمایید",
				equalTo: "رمز عبور وارد شده مطابقت ندارد"
			}
		}
	});
    </script>

    @endsection