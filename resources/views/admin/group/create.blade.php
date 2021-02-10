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
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('groups.index')}}">لیست {{$page_title}}
                        ها</a>
                </div>
                <form action="{{URL::route('groups.store')}}{{isset($group) ? '?action=edit' : ''}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($group)
                    <input type="hidden" name="group_id" value="{{$group->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">نام {{$page_title}}</label>
                            <input class="form-control" type="text" name="title" value="{{$group->title ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">انتخاب تصویر</label>
                        <div class="custom-file row col-md-6">
                            <input type="file" class="custom-file-input" name="picture" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>



                    {{-- <div class="form-group row">
                       
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="selectuser">Example multiple select</label>
                                <select multiple class="form-control" id="selectuser">
                                  @foreach (\App\User::orderBy('fname')->get() as $item)
                                      <option value="{{$item->id}}">{{$item->fame . ' ' . $item->lname}}</option>
                    @endforeach
                    </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex flex-column h-100 justify-content-center text-center">
                <a href="#" class="choose-users"><i class="fas fa-2x fa-arrow-alt-circle-left"></i></a>
                <a href="#"><i class="fas fa-2x fa-arrow-alt-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Example multiple select</label>
                <select multiple class="form-control" id="exampleFormControlSelect2">

                </select>
            </div>
        </div>
    </div> --}}



    <div class="form-group row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-form-label">انتخاب سرگروه ها (با نگاه داشتن ctrl میتوانید به صورت چندتایی انتخاب کنید)</label>
                <select required class="form-control select2 select2-multiple" multiple="multiple" name="leaders[]">
                    
                    @foreach (\App\User::orderBy('fname')->get() as $item)
                    <option value="{{$item->id}}" {{isset($group) && $group->members->contains($item->id) && $group->members()->where('id',$item->id)->first()->pivot->leader == 1 ? 'selected' : ''}}>{{$item->fname . ' ' . $item->lname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-form-label">انتخاب اعضای گروه</label>
                <select required class="form-control select2 enable-tag select2-multiple" multiple="multiple" name="members[]">
                    @foreach (\App\User::orderBy('fname')->get() as $item)
                    <option value="{{$item->id}}" {{isset($group) && $group->members->contains($item->id) && $group->members()->where('id',$item->id)->first()->pivot->leader == 0 ? 'selected' : ''}}>{{$item->fname . ' ' . $item->lname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">عمومی یا اختصاصی</label>
                <select name="type" class="form-control" id="exampleFormControlSelect2">
                    <option selected value="public">عمومی</option>
                    <option value="private">اختصاصی</option>
                </select>
            </div>
        </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">ظرفیت گروه</label>
                <input type="number" name="capacity" class="form-control" value="{{$group->capacity ?? ''}}" required>
            </div>
        </div>
    </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                @isset($group)
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