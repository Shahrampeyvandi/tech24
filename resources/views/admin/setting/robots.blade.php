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
               
                <form action="{{URL::route('robots.create')}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                   
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="example-text-input" class=" col-form-label">محتوای فایل Robots.txt </label>
                            <textarea class="form-control" rows="10" type="text" name="robots"  dir="ltr"
                                required id="example-text-input">{{ file_get_contents(public_path('robots.txt')) }}</textarea>
                        </div>
                    </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                
                ویرایش
                
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

