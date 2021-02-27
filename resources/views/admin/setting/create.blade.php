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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right">
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('settings.index')}}">لیست {{$page_title}}
                        ها</a>
                </div>
                <form action="{{URL::route('settings.store')}}{{isset($setting) ? '?action=edit' : ''}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($setting)
                    <input type="hidden" name="setting_id" value="{{$setting->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">نام - این نام را تغییر ندهید</label>
                            <input class="form-control" type="text" name="key" value="{{$setting->key ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">مقدار</label>
                            <input class="form-control" type="text" name="value" value="{{$setting->value ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                @isset($setting)
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
<script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
<!--tinymce js-->
<script src="{{URL::asset('/libs/tinymce/tinymce.min.js')}}"></script>

<script>
    $(".select2").select2({
        tags:false
    });
    $(".select2.enable-tag").select2({
    tags:true
    });
 

  
</script>

@endsection