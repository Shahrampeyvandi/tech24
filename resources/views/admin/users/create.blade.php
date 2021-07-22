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
                <form action="{{URL::route('users.store')}}{{isset($user) ? '?action=edit' : ''}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($user)
                        <input type="hidden" name="uid" value="{{$user->id}}">
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

                    @isset($user)
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ $user->getPicture() }}" alt="" class="w-100">
                        </div>
                    </div>
                    @endisset

                    <div class="form-group row">
                        <label for="" class="col-md-3 col-form-label">انتخاب تصویر (1:1)</label>
                        <div class="custom-file row col-md-6">
                            <input type="file" class="custom-file-input" name="avatar" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">نام کاربری</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text"
                            pattern="[a-zA-Z\d]{5,12}" title="نام کاربری بایستی با حروف لاتین شروع شود و از 5 تا 12 کاراکتر میباشد"
                            name="username" value="{{$user->username ?? ''}}" required
                                id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">بیو: </label>
                            <textarea id="elm1" name="bio">{!! $user->bio ?? '' !!}</textarea>
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
                        <label for="example-text-input" class="col-md-2 col-form-label">رمز عبور جدید</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text"
                            pattern=".{8,}"
                            title="رمز عبور حداقل شامل 8 کاراکتر میباشد"
                            name="password" value=""
                                id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">نقش</label>
                        <div class="col-md-4">
                            <select class="form-control" name="group" id="group">
                                <option value="student" {{isset($user) && $user->hasRole('student') ? 'selected' : ''}}>دانشجو</option>
                                <option value="teacher" {{isset($user) && $user->hasRole('teacher') ? 'selected' : ''}}>استاد</option>
                                <option value="admin" {{isset($user) && $user->hasRole('admin') ? 'selected' : ''}}>مدیر</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row " id="ability" @isset($user)@else style="display: none" @endisset>
                        <label for="example-text-input" class="col-md-2 col-form-label">تخصص : (به طور مثال 'امنیت شبکه')</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text"
                            name="ability" value="{{$user->ability ?? ''}}"
                                id="example-text-input">
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
<!--tinymce js-->
<script src="{{URL::asset('/libs/prism/prism.js')}}" data-manual></script>
<script src="{{URL::asset('/libs/tinymce/tinymce.min.js')}}"></script>
<!-- Summernote js -->
<script src="{{URL::asset('/libs/summernote/summernote.min.js')}}"></script>
<!-- init js -->
<script src="{{URL::asset('/js/pages/form-editor.init.js')}}"></script>
<script>
    $('#group').change(function(e){
       if($(this).val()== 'teacher'){
           $('#ability').removeClass('hidden').addClass('show')
       }else{
           $('#ability').removeClass('show').addClass('hidden')
       }
   })
</script>
@endsection
