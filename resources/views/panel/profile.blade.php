@extends('layouts.panel.master')

@section('content')
<section class="main-section">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{$error}}</div>
    @endforeach
    @endif
    <div class="card-dashboard">
        <form action="{{ route('member.profile',$user->username) }}" method="POST" class="change-detail-box"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div class="profile-images">
                <div class="backdrop">
                    <img class="backdrop" src="{{ asset('panel-assets/Images/Dashboard/header/bg.jpg') }}" alt="">
                </div>
                <div class="avatar-place">
                    <img class="avatar" src="{{ $user->getPicture() }}" alt="">

                    <span id="avatar-name">{{$user->getFullName()}}</span>
                </div>
                <div id="change-img">

                    <img src="{{ asset('panel-assets/Images/Dashboard/header/camera.png') }}" alt="">
                    <input type="file" name="avatar" style="opacity: 0;position: absolute;width: 100%;">
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <div class="input-place">
                            <label for="fName">
                                نام:
                            </label>
                            <input type="text" id="fName" name="firstname" value="{{$user->fname}}" required
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="input-place">
                            <label for="lName">
                                نام خانوادگی:
                            </label>
                            <input type="text" id="lName" value="{{$user->lname}}" name="lastname" required
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-place">
                            <label for="Email">
                                ایمیل:
                            </label>
                            <input type="text" id="Email" name="email" value="{{$user->email}}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="input-place">
                            <label for="Phone">
                                موبایل {{$user->mobile_verified ? '(تایید شده)' : '(شماره موبایل خود را تایید کنید)'}}
                            </label>
                            <input type="text" id="Phone" value="{{$user->mobile}}" name="phone" autocomplete="off">
                            <a href="#" onclick="sendSMS(event)" class="btn--ripple" type="submit">
                                تایید موبایل
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="input-place">
                            <label for="Phone">
                                کد تایید موبایل
                            </label>
                            <input type="text" id="code" 
                            value=""
                             name="code" autocomplete="off">
                           
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="input-place">
                            <label for="select">
                                تحصیلات:
                            </label>
                            <a href="#" id="select" class="select">
                                <div class="text">انتخاب تحصیلات</div>
                                <img src="assets/Images/Dashboard/header/arrow-down-input.png" alt="">
                                <label>
                                    <input type="text" name="Evidence_type" id="Evidence_type">
                                </label>
                            </a>
                            <ul class="select_items">
                                {{-- <li class="select-option" id="Evidence1">مدرک1</li>
                                <li class="select-option" id="Evidence2">مدرک2</li>
                                <li class="select-option" id="Evidence3">مدرک3</li>
                                <li class="select-option" id="Evidence4">مدرک4</li>
                                <li class="select-option" id="Evidence5">مدرک5</li>
                                <li class="select-option" id="Evidence6">مدرک6</li>
                                <li class="select-option" id="Evidence7">مدرک7</li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 no-padding">
                        <div class="container-fluid">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-8 no-padding-right">
                                        <div class="input-place">
                                            <label for="username">
                                                نام کاربری:
                                            </label>
                                            <input type="text" id="username" name="username" value="{{$user->username}}"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-4 no-padding-left">
                                        <div class="input-place">
                                            <label for="birthday">
                                                تاریخ تولد
                                            </label>
                                            <input type="text" id="birthday" name="birthday" class="input-mask"
                                                autocomplete="off" data-inputmask="'alias': 'datetime'"
                                                data-inputmask-inputformat="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6"></div>
                    <div class="col-12 col-lg-6">
                        <button class="btn--ripple" type="submit">
                            ویرایش اطلاعات
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<!-- form mask -->
<script src="{{URL::asset('/libs/inputmask/inputmask.min.js')}}"></script>
<script>
    $(".input-mask").inputmask();
    function sendSMS(event){
        event.preventDefault()
      
        let mobile = $('input[name="phone"]').val()
   var  request = $.post('/verify-mobile', {  mobile: mobile, _token: token });
    request.fail(function (err) {
        // alert(err.responseJSON.errors.message[0])
      $.each(err.responseJSON.errors.message,(i,n)=>{
          if(err.responseJSON.errors.message[i] instanceof Array) {
            toastr.error(err.responseJSON.errors.message[i][0])
          }else{
            toastr.error(err.responseJSON.errors.message[i])
          }
      })
    })
    
    request.done(function (res) {
        // alert('کد برای شما پیامک شد')
        toastr.success('کد به شماره موبایل شما پیامک شد')
    })
}
</script>
@endsection