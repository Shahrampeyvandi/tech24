@extends('layouts.panel.master')

@section('content')
<div class="main-section">
    <div class="card-dashboard notification-place">
        <div class="top-content">
            <span class="title">اطلاعیه ها</span>
            <form action="#" class="input-place">
                <input type="text" id="search-notification" placeholder="جست جو در اطلاعیه ها" autocomplete="off"
                    required>
                <label for="search-notification">
                    <button type="submit">
                        <img src="assets/Images/Dashboard/notifications/magnifiying-glass.png" alt="">
                    </button>
                </label>
            </form>
            <div class="notification-nav">
                <div class="notification-item selected">
                    <a href="{{ route('member.dashboard',['user'=>$user->username]) }}">
                        همه
                        <i>{{$notifCounts['all']}}</i>
                    </a>
                </div>
                <div class="notification-item">
                    <a href="{{ route('member.dashboard',['user'=>$user->username,'q'=>'unread_notifications']) }}">
                        خوانده نشده ها
                        <i>{{$notifCounts['unreaded']}}</i>
                    </a>
                </div>
                <div class="notification-item">
                    <a href="{{ route('member.dashboard',['user'=>$user->username,'q'=>'readed_notifications']) }}">خوانده
                        شده ها
                        <i>{{$notifCounts['readed']}}</i>
                    </a>
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
                    {!! nl2br($notification->text) !!}
                </p>
            </div>
            <div class="notification-details">
                <div>
                    <img src="assets/Images/Dashboard/notifications/Forma1.png" alt="">
                    تاریخ ارسال:
                    <span class="date">{{jalaliDate($notification->created_at)}} </span>
                </div>
                @if (! $user->readedNotifications->contains($notification->id))
                    
                <a
                    href="{{ route('member.dashboard',['user'=>$user->username,'action'=>'read_notification','id'=>$notification->id]) }}">علامت
                    زدن به عنوان خوانده شده</a>
                @endif
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