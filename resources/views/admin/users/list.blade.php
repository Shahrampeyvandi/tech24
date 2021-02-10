@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title')کاربران @endslot
@slot('li_1') لیست @endslot
@endcomponent



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

              {{-- <div class="text-right">
                <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('users.create')}}">تعریف</a>
             </div> --}}

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام </th>
                            <th>نام خانوادگی</th>
                            <th>نام کاربری</th>
                            <th>شماره موبایل</th>
                            <th>ایمیل</th>
                            <th>توانایی</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $key=>$user)
                            <tr>
                                <td>{{($key+1)}}</td>
                                <td>{{$user->fname}}</td>
                                <td>{{$user->lname}}</td>
                                <td></td>
                                <td>{{$user->mobile}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <a href="#" onclick="changeAbility(event,'{{$user->id}}')" 
                                        class="btn btn-{{$user->group == 'teacher' ? 'success':'light'}} waves-effect group">
                                        {{$user->group}}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <form class="form-inline" action="{{route('users.destroy',$user->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button onclick="return confirm('آیا برای حذف کاربر مطمئن هستید؟')" class="btn btn-sm btn-danger waves-effect ">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </button>
                                        </form>
                                        <button href="#" class="btn btn-sm btn-info"><i class="mdi mdi-account-edit"></i></button>
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

<script>
    
    function changeAbility(event,id){
        event.preventDefault()
        $.ajax({
        type: 'POST',
        url: '{{route("users.changegroup")}}',
        data: JSON.stringify ({id: id,_token:token}),
        success: function(data) { 
            $(event.target).html(data.res)
            if(data.res == 'teacher'){
                $(event.target).removeClass('btn-light').addClass('btn-success')
            }else{
                $(event.target).removeClass('btn-success').addClass('btn-light')
            }
         },
        contentType: "application/json",
        dataType: 'json'
        });
    }
</script>

@endsection