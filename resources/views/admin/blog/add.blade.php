@extends('layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') {{$page_title}} @endslot
@slot('li_1') جدید @endslot
@endcomponent

@section('css')
<link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('libs/prism/prism.css') }}">

@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right">
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('blogs.index')}}">لیست {{$page_title}}
                        ها</a>
                </div>
                <form action="{{URL::route('blogs.store')}}{{isset($blog) ? '?action=edit' : ''}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($blog)
                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">عنوان {{$page_title}}</label>
                            <input class="form-control" type="text" name="title" value="{{$blog->title ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">آدرس یکتای {{$page_title}}</label>
                            <input class="form-control" type="text" name="url" value="{{$blog->url ?? ''}}" required
                                id="example-text-input">
                        </div>
                    </div>
                    @isset($blog)
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset($blog->picture) }}" class="img-fluid" alt="">
                            </div>
                        </div>
                    @endisset
                    <div class="form-group row my-2">
                        <label for="" class="col-md-2 col-form-label">انتخاب تصویر (16:9)</label>
                        <div class="custom-file row col-md-6">
                            <input type="file" class="custom-file-input" name="picture" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">توضیحات کوتاه: </label>
                            <textarea class="form-control" name="short_description">{!! $blog->short_description ?? '' !!}</textarea>
                        </div>
                    </div>
                    @isset($blog)
                    <div class="form-group row">
                        <div class="col-md-8 pl-5">
                            <input class="form-check-input" type="checkbox" name="change_desc" value="1" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                              ویرایش توضیحات 
                            </label>
                        </div>
                    </div>
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">توضیحات: </label>
                            <textarea id="elm1" name="description">{!! $blog->description ?? '' !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">جاگذاری ویدیو</label>
                            <textarea class="form-control" name="video_frame">{!! $blog->video_frame ?? '' !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="col-form-label">دسته بندی</label>
                            <select class="form-control select2 enable-tag" name="category" required>
                                @foreach (\App\BlogCategory::orderBy('name')->get() as $item)
                                <option value="{{$item->name}}"
                                    {{isset($blog) && $blog->category_id == $item->id ? 'selected' : ''}}>
                                    {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                   
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label class="col-form-label">تگ ها</label>
                            <select class="form-control select2 enable-tag select2-multiple" multiple="multiple"
                                name="tags[]">
                                @foreach (\App\Tag::orderBy('tagname')->get() as $item)
                                <option value="{{$item->tagname}}"
                                    {{isset($blog) && $blog->tags->contains($item->id) ? 'selected' : ''}}>
                                    {{$item->tagname}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="" class="col-form-label">عنوان سئو</label>
                            <div class="custom-file">
                                <input type="text" name="seo_title" id="seo_title" 
                                    class="form-control" required value="{{ $blog->seo_title ?? '' }}">
    
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="col-form-label">توضیحات سئو</label>
                            <div class="custom-file">
                                <input type="text" name="seo_description" id="seo_description" 
                                    class="form-control" required value="{{ $blog->seo_description ?? '' }}">
    
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="col-form-label">canonical url</label>
                            <div class="custom-file">
                                <input type="text" name="seo_canonical" id="seo_canonical" 
                                    class="form-control" required value="{{ $blog->seo_canonical ?? '' }}">
    
                            </div>
                        </div>
                       
                  

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            @isset($blog)
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
<script src="{{URL::asset('/libs/prism/prism.js')}}" data-manual></script>
<script src="{{URL::asset('/libs/tinymce/tinymce.min.js')}}"></script>
<!-- Summernote js -->
<script src="{{URL::asset('/libs/summernote/summernote.min.js')}}"></script>
<!-- init js -->
<script src="{{URL::asset('/js/pages/form-editor.init.js')}}"></script>
<!-- form mask -->
<script src="{{URL::asset('/libs/inputmask/inputmask.min.js')}}"></script>
<!-- form mask init -->
<script>
//       $('textarea#elm1').tinymce({  
//   plugins: 'codesample',
  
//   codesample_languages: [
//     { text: 'HTML/XML', value: 'markup' },
//     { text: 'JavaScript', value: 'javascript' },
//     { text: 'CSS', value: 'css' },
//     { text: 'PHP', value: 'php' },
//     { text: 'Ruby', value: 'ruby' },
//     { text: 'Python', value: 'python' },
//     { text: 'Java', value: 'java' },
//     { text: 'C', value: 'c' },
//     { text: 'C#', value: 'csharp' },
//     { text: 'C++', value: 'cpp' }
//   ],
//   toolbar: 'codesample' });
 
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