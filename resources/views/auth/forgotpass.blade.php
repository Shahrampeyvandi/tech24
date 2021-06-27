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
                                <h5 class="mt-2 font-size-20">موبایل خود را جهت ارسال کد یکبار مصرف وارد نمایید</h5>

                            </div>
                        </div>
                        <div class="card-body text-right">
                            <div class="p-2">
                                <form method="POST" action="{{ route('password.email') }}" id="form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="mobile">شماره موبایل</label>
                                        <input type="mobile" required class="form-control 
                                        @error('mobile') is-invalid @enderror" name="mobile"
                                            value="" id="mobile" autofocus autocomplete="mobile">
                                        @error('mobile')
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
            mobile: {
                required: true,
                regex: /^[0][1-9]\d{9}$|^[1-9]\d{9}$/
			},
		
		},
		messages: {
         
            mobile:{
                required:"شماره موبایل خود را وارد نمایید",
                regex:"موبایل دارای فرمت نامعتبر می باشد"
            }
		}
	});
    </script>

    @endsection