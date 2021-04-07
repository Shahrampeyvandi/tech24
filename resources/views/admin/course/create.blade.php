@extends('layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') {{$page_title}} @endslot
@slot('li_1') جدید @endslot
@endcomponent

@section('css')
<link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    .progress {

        height: 1rem !important;
    }
</style>

@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right">
                    <a class="btn btn-primary mr-auto mb-3"
                        href="{{URL::route('posts.index')}}?post_type={{$post_type}}">لیست {{$page_title}}
                        ها</a>
                </div>
                @component('common-components.admin-errors')

                @endcomponent
                <form
                    action="{{URL::route('posts.store')}}{{isset($post) ? '?action=edit&post_type='.$post_type.'' : '?post_type='.$post_type.''}}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($post)
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label"><span class="text-danger">*</span>
                                نام {{$page_title}}</label>
                            <input class="form-control" type="text" name="title" value="{{$post->title ?? ''}}" required
                                id="example-text-input">
                        </div>
                    </div>

                   @if ($post_type == 'webinar')
                   <div class="form-group row">
                    <div class="col-md-8">
                        <label for="example-text-input" class=" col-form-label"><span class="text-danger">*</span>
                          SCO Url (آدرس وبینار ایجاد شده در ادوبی)</label>
                        <input class="form-control" type="text" name="sco_id" value="{{ $post->sco_url ?? '' }}" required
                            id="example-text-input">
                    </div>
                </div>
                   <div class="form-group row">
                    <div class="col-md-8">
                        <label for="example-text-input" class=" col-form-label"><span class="text-danger">*</span>
                            نام گروه وبینار (لاتین)</label>
                        <input class="form-control" type="text"
                        pattern = "[A-Za-z]{2,}" title="تنها حروف لاتین"
                        name="group_name" 
                        @isset($post)
                        value="{{$post->adobeGroup->name ?? ''}}"
                        @else 
                        required
                        @endisset
                        
                            id="example-text-input">
                    </div>
                </div>
                   @endif

                    @isset($post)
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset($post->picture) }}" alt="">
                        </div>
                    </div>
                    @endisset
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">انتخاب تصویر (1:1)</label>
                        <div class="custom-file row col-md-6">
                            <input type="file" class="custom-file-input" name="picture" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            <span class="file-name text-success"></span>
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
                            <span class="file-name text-success"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">آدرس فایل </label>
                        <div class="custom-file row col-md-6">
                            <input type="url" name="url" id="url" placeholder="https://dl.example.com"
                                class="form-control"
                                pattern="[Hh][Tt][Tt][Pp][Ss]?:\/\/(?:(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)(?:\.(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)*(?:\.(?:[a-zA-Z\u00a1-\uffff]{2,}))(?::\d{2,5})?(?:\/[^\s]*)?">

                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">توضیحات کوتاه: </label>
                            <textarea class="form-control" name="short_description">{!! $post->short_description ?? '' !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">توضیحات: </label>
                            <textarea name="desc">{!! $post->description ?? '' !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="example-text-input" class=" col-form-label"><span class="text-danger">*</span>
                                مدت زمان </label>
                            <div class="">
                                <input id="input-date1" name="duration" class="form-control input-mask"
                                    data-inputmask="'mask': '99:99'" required value="{{$post->duration ?? ''}}">
                                <span class="text-muted">e.g "HH:MM"</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="input-date1" class="col-form-label"><span class="text-danger">*</span> تاریخ
                            </label>
                            <input id="input-date1" name="date" class="form-control input-mask" @isset($post)
                                value="{{jalaliDate($post->start_date)}}" @endisset data-inputmask="'alias': 'datetime'"
                                data-inputmask-inputformat="dd/mm/yyyy" required>
                            <span class="text-muted">e.g "dd/mm/yyyy"</span>
                        </div>
                        @if ($post_type !== 'podcast')
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">مدرس </label>
                                <select class="form-control select2 select2-multiple" name="teachers" required>
                                    @foreach (\App\User::role('teacher')->orderBy('fname')->get() as $item)
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
                                <option value="money" {{isset($post) && $post->cach == 'money' ? 'selected' : ''}}>
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
                        {{-- <div class="col-md-4">
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
                        </div> --}}
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
                                        {{isset($post) && $post->quiz && $post->quiz->id == $item->id ? 'selected' : ''}}>
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
                                <select class="form-control select2 enable-tag" id="category" name="category" required>
                                    <option value="">باز کردن فهرست انتخاب </option>
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
                                <select class="form-control select2 enable-tag" id="parent_category"
                                    name="parent_category" required>
                                    <option value="0">ندارد </option>
                                    @foreach (\App\Category::orderBy('title')->get() as $item)
                                    <option value="{{$item->id}}"
                                        {{isset($post) && $post->category->parent_id == $item->id ? 'selected' : ''}}>
                                        {{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    @if ($post_type == 'webinar')
                    <div class="col-md-4">
                        <label class="col-form-label">آرشیو</label>
                        <select class="form-control" name="archive" id="archive">
                            <option value="no" {{isset($post) && $post->archive == 0 ? 'selected' : ''}}>
                                خیر</option>
                            <option value="yes" {{isset($post) && $post->archive == 1 ? 'selected' : ''}}>
                                بله</option>
                        </select>
                    </div>
                    @isset($post->file)
                    <div class="col-md-6">
                        <video width="320" height="240" controls>
                            <source src="{{$post->getFileUrl()}}" type="video/mp4">
                            <source src="movie.ogg" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    @endisset

                    <div class="row archive" @if (isset($post)) @else style="display: none" @endif>
                        <div class="form-group col-md-12">
                            <label for="" class="col-form-label">انتخاب فایل </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                <span class="file-name text-success"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="col-form-label">آدرس فایل </label>
                            <div class="custom-file">
                                <input type="url" name="url" id="url" placeholder="https://dl.example.com"
                                    class="form-control"
                                    pattern="[Hh][Tt][Tt][Pp][Ss]?:\/\/(?:(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)(?:\.(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)*(?:\.(?:[a-zA-Z\u00a1-\uffff]{2,}))(?::\d{2,5})?(?:\/[^\s]*)?">

                            </div>
                        </div>

                       
                    </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">عنوان سئو</label>
                        <div class="custom-file">
                            <input type="text" name="seo_title" id="seo_title" 
                                class="form-control" required value="{{ $post->seo_title ?? '' }}">

                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">توضیحات سئو</label>
                        <div class="custom-file">
                            <input type="text" name="seo_description" id="seo_description" 
                                class="form-control" required value="{{ $post->seo_description ?? '' }}">

                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">canonical url</label>
                        <div class="custom-file">
                            <input type="text" name="seo_canonical" id="seo_canonical" 
                                class="form-control" required value="{{ $post->seo_canonical ?? '' }}">

                        </div>
                    </div>
            </div>
            <div class="col-md-12 my-3 btn--wrapper">

                <button type="submit" class="btn btn-primary waves-effect waves-light" >
                    @isset($post)
                    ویرایش
                    @else
                    ثبت
                    @endisset
                </button>



            </div>
            <div class="col-md-12">
                <div class="progress mt-2">
                    <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"
                        style="width: 0%">
                        0%
                    </div>
                </div>
                <br />
                <div id="success">
                </div>
                <div id="errors">

                </div>
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
<script src="{{URL::asset('/libs/ckeditor/ckeditor.js')}}"></script>
<!-- Sweet Alerts js -->
<script src="{{ URL::asset('/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- form mask -->
<script src="{{URL::asset('/libs/inputmask/inputmask.min.js')}}"></script>

<script src="{{asset('assets/js/jquery.form.min.js')}}"></script>

<script>
    CKEDITOR.replace('desc',{
            
          
            contentsLangDirection: 'rtl'
        });
    $(".select2").select2({
        tags:false
    });
    $(".select2.enable-tag").select2({
    tags:true
    });
   $(".input-mask").inputmask();
   $('#cash_type').change(function(e){
       if($(this).val()== 'money'){
           $('#cash').removeClass('hidden').addClass('show')
       }else{
           $('#cash').removeClass('show').addClass('hidden')
       }
   })

   $('#archive').change(function(e){
       if($(this).val()== 'yes'){
           $('.archive').removeClass('hidden').addClass('show')
       }else{
           $('.archive').removeClass('show').addClass('hidden')
       }
   })

   $('form').ajaxForm({
        beforeSerialize:function($Form, options){
        /* Before serialize */
        $("#errors").html('')
        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        return true; 
        },
        beforeSend:function(){
            $('#success').empty();
            
      },
      uploadProgress:function(event, position, total, percentComplete)
      {
      
        $('.btn--wrapper button').text(`در حال ارسال ...`)
        $('.btn--wrapper button').attr('disabled','true')
       
        $('.progress-bar').text(percentComplete + '%');
        $('.progress-bar').css('width', percentComplete + '%');
      
      
      },
     
      success:function(data)
      {

          $('.btn--wrapper button').html(`ارسال`)
          $('.btn--wrapper button').removeAttr('disabled');

        if(data.status == 'success')
        {
            Swal.fire({
            title: '',
            text: 'پست با موفقیت آپلود شد',
            type: 'success',
            confirmButtonColor: '#3b5de7',
            confirmButtonText: "مشاهده دوره ها"
            }).then(function (result) {
        if (result.value) {
          location.href = data.url
        }
      });
        }
        
            $('.progress-bar').text('انجام شد');
            $('.progress-bar').css('width', '0%');

            
         
      },

      error:function(data){
        $("#errors").html('')
          if(data.status == 500) {
            $("#errors").append("<li class='alert alert-danger'>"+data.responseJSON.message+"</li>")
          }
    
          if(data.status == 422) {
              $.each(data.responseJSON.errors, function (key, item) 
                {
                  $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                });
          } 

      
          $('.btn--wrapper button').html(`ارسال`)
          $('.btn--wrapper button').removeAttr('disabled');
        $('.progress-bar').css('width', '0%');
     
      }
    });
   
</script>

@endsection