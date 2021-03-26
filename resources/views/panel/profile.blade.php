@extends('layouts.panel.master')

@section('content')
<section class="main-section">
    <div class="card-dashboard">
        <form action="{{ route('member.profile',$user->username) }}" method="POST" class="change-detail-box" enctype="multipart/form-data">
            @csrf
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
                            <input type="text" id="Email" name="email" value="{{$user->email}}" readonly
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="input-place">
                            <label for="Phone">
                                شماره تماس:
                            </label>
                            <input type="text" id="Phone" value="{{$user->mobile}}" name="phone" readonly
                                autocomplete="off">
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
                                <li class="select-option" id="Evidence1">مدرک1</li>
                                <li class="select-option" id="Evidence2">مدرک2</li>
                                <li class="select-option" id="Evidence3">مدرک3</li>
                                <li class="select-option" id="Evidence4">مدرک4</li>
                                <li class="select-option" id="Evidence5">مدرک5</li>
                                <li class="select-option" id="Evidence6">مدرک6</li>
                                <li class="select-option" id="Evidence7">مدرک7</li>
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
                                            <input type="text" id="username" name="username" readonly
                                                value="{{$user->username}}" autocomplete="off">
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
</script>
@endsection