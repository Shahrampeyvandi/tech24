@extends('layouts.master')

@section('title') داشبورد @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') داشبورد @endslot
@slot('title_li') @endslot
@endcomponent

<div class="row">
    <div class="col-md-3">

        @component('common-components.dashboard-widget')

        @slot('title') دوره ها @endslot
        @slot('iconClass') mdi mdi-file-video-outline @endslot
        @slot('price') {{\App\Post::where('post_type','course')->count()}} @endslot

        @endcomponent
    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') وبینارها @endslot
        @slot('iconClass') mdi mdi-file-video-outline @endslot
        @slot('price') {{\App\Post::where('post_type','webinar')->count()}} @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') دانشجوها @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') {{\App\User::role('student')->count()}} @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') اساتید @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') {{\App\User::role('teacher')->count()}} @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') پادکست ها @endslot
        @slot('iconClass') mdi mdi-microphone-outline @endslot
        @slot('price') {{\App\Post::where('post_type','podcast')->count()}} @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') اطلاعیه ها @endslot
        @slot('iconClass') mdi mdi-bell @endslot
        @slot('price') {{\App\Notification::count()}} @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') وبلاگ ها @endslot
        @slot('iconClass') mdi mdi-rss @endslot
        @slot('price') {{\App\Blog::count()}} @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') New Item @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') 2,456 @endslot


        @endcomponent

    </div>


</div>
<!-- end row -->

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between mb-3">
            <h3>لیست اطلاعیه های اخیر</h3>
            <a href="{{route('notifications.create')}}" class="btn btn-primary">اطلاعیه جدید</a>
        </div>
    </div>
</div>

<div class="row">
    @forelse ($notifications as $item)
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{$item->title}}</span>
                <div class="d-flex">
                    <a href="{{route('notifications.edit',$item->id)}}" title="ویرایش"><i class="mdi mdi-file-edit-outline mdi-24px"></i></a>
                    <form class="form-inline" action="{{route('notifications.destroy',$item->id)}}"
                        method="post">
                        @csrf
                        @method('delete')
                        <button class="text-danger" type="submit" onclick="return confirm('آیا برای حذف اطلاعیه مطمئن هستید؟')"
                            >
                            <i class="mdi mdi-trash-can-outline mdi-24px"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div>
                    {!!$item->text!!}
                </div>
                <span class="text-right d-block font-size-11"> تاریخ انتشار: {{$item->created_at}} </span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            هیچ اطلاعیه ای ثبت نشده است
          </div>
        </div>
    </div>
    @endforelse

  
    
</div>
<div class="row">
    <div class="col-12">
        {{$notifications->links()}}
    </div>
</div>
@endsection

