@extends('layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') {{$page_title}} @endslot
@slot('li_1') جدید @endslot
@endcomponent

@section('css')
<link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                اطلاعیه جدید
            </div>
            <div class="card-body">
                <form action="{{URL::route('notifications.store')}}{{isset($notification) ? '?action=edit' : ''}}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($notification)
                    <input type="hidden" name="notification_id" value="{{$notification->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="example-text-input" class=" col-form-label">عنوان</label>
                            <input class="form-control" type="text" name="title" value="{{$notification->title ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">ارسال به</label>
                                <select required class="form-control select2 " name="for">
                                    <option value="all" {{isset($notification) && $notification->for == 'all' ? 'selected' : ''}}>تمام اعضا</option>
                                    <option value="students" {{isset($notification) && $notification->for == 'students' ? 'selected' : ''}}>دانشجوها</option>
                                    <option value="teachers" {{isset($notification) && $notification->for == 'teachers' ? 'selected' : ''}}>اساتید</option>
                                    <option value="admins" {{isset($notification) && $notification->for == 'admins' ? 'selected' : ''}}>مدیران سایت</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">متن اطلاعیه: </label>
                            <textarea id="elm1" name="text">{!! $notification->text ?? '' !!}</textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            @isset($notification)
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
</div> 

@endsection

@section('script')

<!--tinymce js-->
<script src="{{URL::asset('/libs/tinymce/tinymce.min.js')}}"></script>
<!-- Summernote js -->
<script src="{{URL::asset('/libs/summernote/summernote.min.js')}}"></script>
<!-- init js -->
<script src="{{URL::asset('/js/pages/form-editor.init.js')}}"></script>

@endsection