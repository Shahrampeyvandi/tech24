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
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('posts.index')}}?post_type={{$post_type}}">لیست {{$page_title}}
                        ها</a>
                </div>
                @component('common-components.admin-errors')
                    
                @endcomponent
                <form action="{{URL::route('posts.store')}}{{isset($post) ? '?action=edit&post_type='.$post_type.'' : '?post_type='.$post_type.''}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($post)
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label"><span class="text-danger">*</span> نام {{$page_title}}</label>
                            <input class="form-control" type="text" name="title" value="{{$post->title ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label"><span class="text-danger">*</span>  آدرس یکتای {{$page_title}}</label>
                            <input class="form-control" type="text" name="url" value="{{$post->title ?? ''}}" required
                                id="example-text-input">
                        </div>
                    </div>
                    @isset($post)
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset($post->picture) }}" alt="">
                            </div>
                        </div>
                    @endisset
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">انتخاب تصویر (500 X 500)</label>
                        <div class="custom-file row col-md-6">
                            <input type="file" class="custom-file-input" name="picture" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>

                    @if ($post_type == 'podcast')
                    @isset($post)
                    <h5>فایل پادکست </h5>
                    <audio controls>
                        <source src="{{$post->getFileUrl()}}" type="audio/mpeg">
                        Your browser does not support the audio tag.
                      </audio>
                    @endisset

                    <h5>فایل پادکست را به یکی از دو روش زیر وارد نمایید:</h5>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">انتخاب فایل </label>
                        <div class="custom-file row col-md-6">
                            <input type="file" class="custom-file-input" name="file" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">آدرس فایل </label>
                        <div class="custom-file row col-md-6">
                            <input type="url" name="url" id="url" placeholder="https://dl.example.com"
                            class="form-control"
                                pattern="[Hh][Tt][Tt][Pp][Ss]?:\/\/(?:(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)(?:\.(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)*(?:\.(?:[a-zA-Z\u00a1-\uffff]{2,}))(?::\d{2,5})?(?:\/[^\s]*)?"
                             >

                        </div>
                    </div>                     
                    @endif

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">توضیحات: </label>
                            <textarea id="elm1" name="description">{!! $post->description ?? '' !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="example-text-input" class=" col-form-label"><span class="text-danger">*</span> مدت زمان  </label>
                            <div class="">
                                <input id="input-date1" name="duration" class="form-control input-mask"
                                    data-inputmask="'mask': '99:99'" required value="{{$post->duration ?? ''}}">
                                <span class="text-muted">e.g "HH:MM"</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="input-date1" class="col-form-label"><span class="text-danger">*</span> تاریخ </label>
                            <input id="input-date1" name="date" class="form-control input-mask"
                                value="{{$post->start_date ?? ''}}" data-inputmask="'alias': 'datetime'"
                                data-inputmask-inputformat="dd/mm/yyyy" required>
                            <span class="text-muted">e.g "dd/mm/yyyy"</span>
                        </div>
                       @if ($post_type !== 'podcast')
                       <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label">مدرس </label>
                            <select class="form-control select2 select2-multiple" name="teachers" required>
                                @foreach (\App\User::orderBy('fname')->get() as $item)
                                <option value="{{$item->id}}"
                                    {{isset($post) && $post->teachers->contains($item->id) ? 'selected' : ''}}>
                                    {{$item->fname . ' ' . $item->lname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                       @endif
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="col-form-label">رایگان یا غیررایگان</label>
                            <select class="form-control" name="cash_type" id="cash_type">
                                <option value="free" {{isset($post) && $post->cach == 'free' ? 'selected' : ''}}>
                                    رایگان</option>
                                <option value="cash" {{isset($post) && $post->cach == 'money' ? 'selected' : ''}}>
                                    غیررایگان</option>
                            </select>
                            <input type="number" id="cash" class="form-control mt-1 hidden" placeholder="قیمت به تومان">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">عمومی یا اختصاصی</label>
                            <select class="form-control" name="public_type" id="public_type">
                                <option value="public" {{isset($post) && $post->private == 0 ? 'selected' : ''}}>
                                    عمومی</option>
                                <option value="private" {{isset($post) && $post->private == 1 ? 'selected' : ''}}>
                                    اختصاصی</option>
                            </select>
                        </div>
                        {{-- <div class="col-md-4">
                            <label class="col-form-label">ظرفیت گروه</label>
                            <input type="number" id="limit" name="limit" class="form-control ">
                        </div> --}}
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">گروه</label>
                                <select class="form-control select2" name="group">
                                    <option value=""></option>
                                    @foreach (\App\Group::orderBy('title')->get() as $item)
                                    <option value="{{$item->id}}"
                                        {{isset($post) && $post->group_id == $item->id ? 'selected' : ''}}>
                                        {{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if ($post_type == 'course')
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">مدرک</label>
                                <select class="form-control select2" name="certificate">
                                    <option value=""></option>
                                    @foreach (\App\Certificate::orderBy('title')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">آزمون پایان دوره</label>
                                <select class="form-control select2" name="quiz">
                                    <option value=""></option>
                                    @foreach (\App\Quiz::orderBy('title')->get() as $item)
                                    <option value="{{$item->id}}"
                                        {{isset($post) && $post->quiz->id == $item->id ? 'selected' : ''}}>
                                        {{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">پیشنیاز دوره</label>
                                <select class="form-control select2 select2-multiple" multiple="multiple"
                                    name="prerequisites[]">
                                    @foreach (\App\Post::where('post_type','course')->orderBy('title')->get() as $item)
                                    <option value="{{$item->id}}"
                                        {{isset($post) && $post->prerequisites->contains($item->id) ? 'selected' : ''}}>
                                        {{Str::limit($item->title,30,'...')}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">تگ ها</label>
                                <select class="form-control select2 enable-tag select2-multiple" multiple="multiple"
                                    name="tags[]">
                                    @foreach (\App\Tag::orderBy('tagname')->get() as $item)
                                    <option value="{{$item->tagname}}"
                                        {{isset($post) && $post->tags->contains($item->id) ? 'selected' : ''}}>
                                        {{$item->tagname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label"><span class="text-danger">*</span> دسته بندی</label>
                                <select class="form-control select2 enable-tag" name="category" required>
                                    @foreach (\App\Category::orderBy('title')->get() as $item)
                                    <option value="{{$item->title}}"
                                        {{isset($post) && $post->category->id == $item->id ? 'selected' : ''}}>
                                        {{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label"><span class="text-danger">*</span> دسته بالایی</label>
                                <select class="form-control select2 enable-tag" name="parent_category" required>
                                    <option value="0" >ندارد </option>
                                    @foreach (\App\Category::orderBy('title')->get() as $item)
                                    <option value="{{$item->title}}"
                                        {{isset($post) && $post->category->parent_id == $item->id ? 'selected' : ''}}>
                                        {{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            @isset($post)
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
<script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
<!--tinymce js-->
<script src="{{URL::asset('/libs/tinymce/tinymce.min.js')}}"></script>
<!-- Summernote js -->
<script src="{{URL::asset('/libs/summernote/summernote.min.js')}}"></script>
<!-- init js -->
<script src="{{URL::asset('/js/pages/form-editor.init.js')}}"></script>
<!-- form mask -->
<script src="{{URL::asset('/libs/inputmask/inputmask.min.js')}}"></script>
<!-- form mask init -->
<script>
    $(".select2").select2({
        tags:false
    });
    $(".select2.enable-tag").select2({
    tags:true
    });
   $(".input-mask").inputmask();
   $('#cash_type').change(function(e){
       if($(this).val()== 'cash'){
           $('#cash').removeClass('hidden').addClass('show')
       }else{
           $('#cash').removeClass('show').addClass('hidden')
       }
   })
</script>

@endsection