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
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('sliders.index')}}">لیست {{$page_title}}
                        ها</a>
                </div>
                <form action="{{URL::route('sliders.store')}}{{isset($slider) ? '?action=edit' : ''}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($slider)
                    <input type="hidden" name="slider_id" value="{{$slider->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">نام {{$page_title}}</label>
                            <input class="form-control" type="text" name="title" value="{{$slider->title ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>

                    @isset($slider)
                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{ asset($slider->image) }}" class="img-fluid" alt="">
                        </div>
                    </div>
                @endisset

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="" class="col-form-label">انتخاب تصویر(16:9)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="picture" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">وبینار یا دوره را برای لینک شدن انتخاب کنید</label>
                                <select class="form-control select2 " name="post" required>
                                    @foreach (\App\Post::whereIn('post_type',['webinar','course'])->orderBy('title')->get() as $item)
                                    <option value="{{$item->id}}"
                                        {{isset($slider) && $slider->post_id == $item->id ? 'selected' : ''}}>
                                        {{Str::limit($item->title,30,'...')}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">توضیحات: </label>
                            <textarea class="form-control" rows="5" name="description">{!! $slider->description ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>




                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            @isset($slider)
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
<script src="{{URL::asset('/js/pages/form-editor.init.js')}}"></script>


<script>
    $(".select2").select2({
        tags:false
    });

 

  
</script>

@endsection