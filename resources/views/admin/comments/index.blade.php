@extends('layouts.master')

@section('title') لیست دیدگاه ها @endsection
@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title')لیست دیدگاه ها @endslot
@slot('li_1') لیست @endslot
@endcomponent


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-justified" role="tablist">
                  
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{ \Request::query('q') == 'approved' ? ' active' : '' }}" href="{{ route('comments.index') }}?q=approved">
                            
                            <span class="">تایید شده <span>{{ $count['approvedComments'] }} </span></span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link {{ \Request::query('q') == 'unapproved' ? ' active' : '' }}" href="{{ route('comments.index') }}?q=unapproved">
                            
                            <span class="">تایید نشده <span>{{ $count['unapprovedComments'] }} </span></span>
                        </a>
                    </li>
                   

                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>دیدگاه</th>
                            <th>مشاهده در صفحه</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($comments as $key=>$comment)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$comment->getAutor() ?? '--'}}</td>
                            <td>{!! $comment->comment !!}</td>
                            <td>
                            <a href="{{ route('post.show',['post'=>$comment->commentable->slug]) }}">{{ $comment->commentable->title }}</a>    
                            </td>
                            
                            
                            <td>{{$comment->getDate()}}</td>

                            <td>
                                <div class="d-flex">
                                    @if (\Request::query('q') == 'unapproved')
                                    <a href="{{ route('comments.edit',['comment'=>$comment]) }}" 
                                        title="جزئیات"
                                        class="btn btn-sm btn-info">
                                        مشاهده و تایید
                                    </a>
                                    @endif
                                   
                                       
                                    <form class="form-inline" action="{{route('comments.destroy',$comment)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا برای حذف دیدگاه مطمئن هستید؟')" class="btn btn-sm btn-danger waves-effect ">
                                            حذف دیدگاه
                                        </button>
                                    </form>
                                   
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