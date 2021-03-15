@extends('layouts.panel.master')

@section('content')
<div class="main-section">
    <div class="card-dashboard notification-place">
        <div class="top-content">
            <span class="title">اطلاعیه ها</span>
            <form action="#" class="input-place">
                <input type="text" id="search-notification" placeholder="جست جو در اطلاعیه ها" autocomplete="off" required>
                <label for="search-notification">
                    <button type="submit">
                        <img src="assets/Images/Dashboard/notifications/magnifiying-glass.png" alt="">
                    </button>
                </label>
            </form>
            <div class="notification-nav">
                <div class="notification-item selected">
                    <span>همه</span>
                </div>
                <div class="notification-item">
                    <span> خوانده نشده ها</span>
                </div>
                <div class="notification-item">
                    <span>خوانده شده ها</span>
                </div>
            </div>
        </div>
        @forelse ($notifications as $notification)
        <div class="notification-box green-border">
            <div class="text-place">
                <p class="title">
                {{$notification->title}}
                </p>
                <p class="text">
                    {!! $notification->text !!}
                </p>
            </div>
            <div class="notification-details">
                <div>
                    <img src="assets/Images/Dashboard/notifications/Forma1.png" alt="">
                تاریخ ارسال:
                <span class="date">{{jalaliDate($notification->created_at)}} </span>
                </div>
                <a href="{{ route('member.dashboard',['user'=>$user->username,'action'=>'read_notification','q'=>$notification->id]) }}">علامت زدن به عنوان خوانده شده</a>
            </div>
        </div>
        @empty
        <div class="notification-box green-border">
            <div class="text-place">
                <p class="title">
                    در حال حاضر هیچ اطلاعیه ای ثبت نشده است
                </p>
              
        </div>
        @endforelse
       
      
    </div>
</div>
@endsection