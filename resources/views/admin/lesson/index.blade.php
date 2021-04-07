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
                            <th>دوره مربوطه</th>
                            <th>رایگان یا غیر رایگان</th>
                            <th>آزمون پایان درس</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($lessons as $key=>$lesson)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$lesson->title}}</td>
                            <td>{{$lesson->post->title}}</td> 
                            <td>{{$lesson->private == 1 ? 'خصوصی' : 'عمومی'}}</td>
                            <td>{{$lesson->quiz ? 'دارد' : 'ندارد'}}</td> 
                          

                            <td>
                                <div class="d-flex">
                                    <form class="form-inline" action="{{route('lessons.destroy',$lesson->id)}}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا برای حذف {{$title}} مطمئن هستید؟')"
                                            class="btn btn-sm btn-danger waves-effect ">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                    <a href="{{route('lessons.edit',$lesson->id)}}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-file-edit-outline "></i></a>
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