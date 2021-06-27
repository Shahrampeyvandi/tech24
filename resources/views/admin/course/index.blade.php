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
                            <th>خصوصی یا عمومی</th>
                            <th>دسته بندی</th>
                            <th>نام استاد(ها)</th>
                            <th>تعداد دانشجویان </th>
                            @if ($post_type == 'webinar')
                            <th>تاریخ شروع </th>
                            <th>مدت زمان</th>
                            @endif
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($posts as $key=>$post)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->private == 1 ? 'خصوصی' : 'عمومی'}}</td>
                            <td>{{$post->category->title}}</td>
                            <td>{{$post->teacher_name()}}</td>
                            <td>
                                {{count($post->registered)}}
                            </td>
                            @if ($post_type == 'webinar')
                            <td>
                                {{\Morilog\Jalali\Jalalian::forge($post->start_date)->format('Y-m-d')}}
                            </td>
                            <td>
                                {{$post->duration}}
                            </td>
                            @endif

                            <td>
                                <div class="d-flex">
                                    <form class="form-inline" action="{{route('posts.destroy',$post->id)}}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا برای حذف {{$title}} مطمئن هستید؟')"
                                            class="btn btn-sm btn-danger waves-effect ">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                    <a title="ویرایش" href="{{route('posts.edit',$post->id)}}?post_type={{$post_type}}"
                                        class="btn btn-sm btn-info ml-1">
                                        <i class="mdi mdi-file-edit-outline "></i></a>
                                    <a title="کاربران" href="{{route('posts.users',$post->id)}}?post_type={{$post_type}}"
                                        class="btn btn-sm btn-primary ml-1">
                                        <i class="mdi mdi-group "></i></a>
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