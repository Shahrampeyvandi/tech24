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
            <div class="card-header">
                <a href="{{ URL::route('sliders.create') }}" class="btn btn-primary float-right" >جدید <i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body">

                


                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان </th>
                            <th>توضیحات</th>
                            <th>دوره</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sliders as $key=>$slider)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$slider->title}}</td>
                            <td>{!! Str::limit(strip_tags($slider->description), 90, '...') !!}</td>
                            <td>{{$slider->post->title}}</td>

                            <td>
                                <div class="d-flex">
                                    <form class="form-inline" action="{{route('sliders.destroy',$slider->id)}}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا برای حذف {{$title}} مطمئن هستید؟')"
                                            class="btn btn-sm btn-danger waves-effect ">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                    <a href="{{route('sliders.edit',$slider->id)}}" class="btn btn-sm btn-info"><i
                                            class="mdi mdi-account-edit"></i></a>
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