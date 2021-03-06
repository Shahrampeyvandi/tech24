<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','تکوان | پنل کاربری')</title>


    <link rel="stylesheet" href="{{ asset('panel-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/Main.css') }}">
    @yield('css')
    <script src="{{ asset('panel-assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('panel-assets/js/bootstrap.min.js') }}"></script>

    <script>
        token = $('meta[name="csrf-token"]').attr('content')
        mainUrl = '{{route("baseurl")}}'
    </script>
    <script src="{{ asset('panel-assets/js/Main.js') }}"></script>


</head>

<style>
    ._alert {
        position: absolute !important;
        width: 6px !important;
        background: rgb(226, 68, 68);
        height: 6px !important;
        padding: 0 !important;
        border-radius: 2px;
        left: 10px !important;
        right: auto !important;
    }
</style>

<body>
    <img class="panel-bg" src="{{ asset('panel-assets/Images/Dashboard/1.png') }}" alt="">
    <header>
        <nav class="top-nav">
            <div class="top-menu">
                <div class="profile-user">
                    <img class="user-profile-img" src="{{ $user->getPicture() }}" alt="user image">
                    <span id="userNameProfile">{{$user->username}}</span>
                    <img src="{{ asset('panel-assets/Images/Dashboard/header/icon.png') }}" alt="icon">
                    <div class="detail-profile">
                        <a href="{{ route('member.profile',$user->username) }}">
                            <img src="{{ asset('panel-assets/Images/Dashboard/header/user-profile.png') }}" alt="">
                            <span>ویرایش پـروفـایل </span>
                        </a>
                        <a href="{{ url('/logout')}}">
                            <img src="{{ asset('panel-assets/Images/Dashboard/header/exit-profile.png') }}" alt="">
                            <span>خـروج </span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="right-nav">
            <div class="menu-button">
                <div class="button">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div>
            <ul class="right-menu">
                <li class="right-Items">
                    <a href="{{ route('member.profile',$user->username) }}">
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/user.png') }}" alt="">
                        <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/user-hover.png') }}"
                            alt="">
                        <span>پروفایل</span>
                    </a>
                </li>
                <li class="right-Items">
                    <a href="{{ route('member.dashboard',['user'=>$user->username]) }}">
                        @if (count(getUnreadedNotifications()))
                        <span class="_alert"></span>
                        @endif
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/notification.png') }}"
                            alt="">
                        <img class="hover"
                            src="{{ asset('panel-assets/Images/Dashboard/header/notification-hover.png') }}" alt="">
                        <span>اطلاعیه</span>
                    </a>
                </li>
                <li class="right-Items">
                    <a href="#">
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/pulse.png') }}" alt="">
                        <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/pulse-hover.png') }}"
                            alt="">
                        <span>فعالیت ها</span>
                    </a>
                </li>
                <li class="right-Items">
                    <a href="{{ route('member.posts',$user->username) }}?post_type=course">
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/storytelling.png') }}"
                            alt="">
                        <img class="hover"
                            src="{{ asset('panel-assets/Images/Dashboard/header/storytelling-hover.png') }}" alt="">
                        <span>دوره ها</span>
                    </a>
                </li>
                <li class="right-Items">
                    <a href="{{ route('member.posts',$user->username) }}?post_type=webinar">
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/video.png') }}" alt="">
                        <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/video-hover.png') }}"
                            alt="">
                        <span>وبینار ها</span>
                    </a>
                </li>
                <li class="right-Items">
                    <a href="#">
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/group.png') }}" alt="">
                        <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/group-hover.png') }}"
                            alt="">
                        <span>گروه ها</span>
                    </a>
                </li>
                <li class="right-Items">
                    <a href="#">
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/conversation.png') }}"
                            alt="">
                        <img class="hover"
                            src="{{ asset('panel-assets/Images/Dashboard/header/conversation-hover.png') }}" alt="">
                        <span>پیام ها</span>
                    </a>
                </li>
                <li class="right-Items">
                    <a href="{{ url('/logout') }}">
                        <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/exit.png') }}" alt="">
                        <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/exit-hover.png') }}"
                            alt="">
                        <span>خروج</span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    @yield('content')


    <script src="{{ URL::asset('assets/js/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}

    @yield('scripts')
</body>

</html>