@extends('layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') {{$page_title}} @endslot
@slot('li_1') جدید @endslot
@endcomponent

@section('css')

@endsection

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('common-components.admin-errors')
                <div class="text-right">
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('certificates.index')}}">لیست
                        {{$page_title}}
                        ها</a>
                </div>
                <form action="{{URL::route('certificates.store')}}{{isset($certificate) ? '?action=edit' : ''}}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($certificate)
                    <input type="hidden" name="group_id" value="{{$certificate->id}}">
                    @endisset
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="example-text-input" class=" col-form-label">نام {{$page_title}}</label>
                            <input class="form-control" type="text" name="title" value="{{$certificate->title ?? ''}}"
                                required id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">انتخاب فایل</label>
                        <div class="custom-file row col-md-6">
                            <input type="file" class="custom-file-input" accept="application/pdf" pattern=".+\.pdf$"
                                placeholder="Must include .pdf file extension" name="file" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            @isset($certificate)
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