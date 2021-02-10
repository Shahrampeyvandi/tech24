@extends('layouts.master')

@section('title') {{$title}} @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') {{$title}} @endslot
@slot('li_1') جدید @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @component('common-components.admin-errors')
        @endcomponent
        <div class="card">
            <div class="card-body">
                <div class="text-right">
                    <a  class="btn btn-primary mr-auto mb-3" href="{{URL::route('users.index')}}">لیست {{$title}} ها</a>
                </div>
                <form action="{{URL::route('users.store')}}{{isset($user) ? '?action=edit' : ''}}" method="post">
                    @csrf
                    @isset($user)
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                    @endisset
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">نام {{$title}}</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="fname" value="{{$user->fname ?? ''}}" required id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">نام خانوادگی {{$title}}</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="lname" value="{{$user->lname ?? ''}}" required
                                id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">نام کاربری</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" 
                            pattern="[a-zA-Z]{4,12}" title="نام کاربری شامل حروف لاتین و بین 4 تا 12 حرف میباشد"
                            name="username" value="{{$user->username ?? ''}}" required
                                id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">شماره موبایل</label>
                        <div class="col-md-4">
                            <input class="form-control" type="number" name="mobile"
                             value="{{$user->mobile ?? ''}}"
                             id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">آدرس ایمیل</label>
                        <div class="col-md-4">
                            <input class="form-control"
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                            title="ایمیل وارد شده صحیح نمیباشد"
                            required
                            type="email" name="email" value="{{$user->email ?? ''}}"
                                id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">رمز عبور</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text"
                            pattern=".{6,}"
                            title="رمز عبور حداقل شامل 6 کاراکتر میباشد"
                            name="password" value="{{$user->password ?? ''}}"
                                id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">نقش</label>
                        <div class="col-md-4">
                            <select class="form-control" name="group">
                                <option value="student">دانشجو</option>
                                <option value="teacher">استاد</option>
                                <option value="admin">مدیر</option>
                            </select>
                        </div>
                    </div>

               
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            @isset($user)
                            ویرایش
                            @else    
                            ثبت
                            @endisset

                        </button>
                    </div>

                </form>



            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection

@section('script')

@endsection