@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title'){{$title}} @endslot
@slot('li_1') لیست @endslot
@endcomponent



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="text-right">
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('upload.media')}}">جدید
                        </a>
                </div>

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام </th>
                          
                            <th>آدرس</th>
                            <th>رسانه</th>
                            <td></td>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($medias as $key=>$media)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$media->name}}</td>
                            <td>{{$media->url}}</td>
                            <td>تصویر</td>
                            <td>
                                @if ($media->media == 'image')
                                    <img src="{{ $media->url }}" alt="" style="width: 150px">
                                @endif
                            </td>
                           

                            <td>
                                <div class="d-flex">
                                   
                                        <button 
                                            class="btn btn-sm btn-danger waves-effect ">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                  
                                 
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection

@section('script')

<!-- Required datatable js -->
<script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
<script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('/js/pages/datatables.init.js')}}"></script>

@endsection