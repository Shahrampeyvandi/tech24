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



                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان </th>
                            <th>فایل</th>
                     
                            <th>دوره یا درس مربوطه</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificates as $key=>$certificate)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$certificate->title}}</td>
                            <td><a href="{{URL::asset($certificate->cfile)}}" title="مشاهده"><i class="fas fa-file"></i></a></td>
                            <td></td>
                            <td>
                                <div class="d-flex">
                                    <form class="form-inline" action="{{route('certificates.destroy',$certificate->id)}}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا برای حذف {{$title}} مطمئن هستید؟')"
                                            class="btn btn-sm btn-danger waves-effect ">
                                            <i class="mdi mdi mdi-delete-alert"></i>
                                        </button>
                                    </form>
                                    <a href="{{route('certificates.edit',$certificate->id)}}" class="btn btn-sm btn-info"><i
                                            class="mdi mdi-pencil-box-multiple"></i></a>
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