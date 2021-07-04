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

@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="text-right">
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('categories.index')}}">لیست {{$page_title}}
                        </a>
                </div>
                @component('common-components.admin-errors')
                @endcomponent
                <form action="{{URL::route('categories.store')}}{{isset($category) ? '?action=edit' : ''}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($category)
                    <input type="hidden" name="category_id" value="{{$category->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">نام دسته بندی</label>
                            <input class="form-control" type="text" name="title" value="{{$category->title ?? ''}}"
                                required id="example-text-input">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label class="col-form-label"><span class="text-danger">*</span> دسته بالایی</label>
                            <select class="form-control select2 enable-tag" id="parent_category"
                                name="parent_id" required>
                                <option value="0">ندارد </option>
                                @foreach (\App\Category::orderBy('title')->get() as $item)
                                <option value="{{$item->id}}"
                                    {{isset($category) && $category->parent_id == $item->id ? 'selected' : ''}}>
                                    {{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @isset($category->picture)
                    <div class="col-md-6">
                       <img src="{{ asset($category->picture) }}" width="100px" alt="">
                    </div>
                    @endisset

                  <div class="row form-group">
                    <div class=" col-md-6">
                        <label for="" class="col-form-label">انتخاب آیکون </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            <span class="file-name text-success"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">نمایش در سایت </label>
                        <select class="form-control" name="appearance" id="appearance">
                            <option value="0" {{isset($category) && $category->appearance == 0 ? 'selected' : ''}}>
                                خیر</option>
                            <option value="1" {{isset($category) && $category->appearance == 1 ? 'selected' : ''}}>
                                بله</option>
                        </select>
                    </div>
                  </div>


                    <div class="col-md-12 my-3 btn--wrapper">

                        <button type="submit" class="btn btn-primary waves-effect waves-light" >
                            @isset($category)
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
<script>
    $(".select2").select2({
        tags:false
    });
    $(".select2.enable-tag").select2({
    tags:true
    });
</script>

@endsection