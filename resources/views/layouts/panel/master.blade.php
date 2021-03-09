<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('panel-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel-assets/css/Main.css') }}">
    <script src="{{ asset('panel-assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('panel-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('panel-assets/js/Main.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<img class="panel-bg" src="{{ asset('panel-assets/Images/Dashboard/1.png') }}" alt="">
<header>
    <nav class="top-nav">
        <div class="top-menu">
            <div class="profile-user">
                <img class="user-profile-img" src="{{ asset('panel-assets/Images/Dashboard/header/bg.png') }}" alt="">
                <span id="userNameProfile">ابراهیم خالدی</span>
                <img src="{{ asset('panel-assets/Images/Dashboard/header/icon.png') }}" alt="">
                <div class="detail-profile">
                    <a href="#">
                        <img src="{{ asset('panel-assets/Images/Dashboard/header/user-profile.png') }}" alt="">
                        <span>ویرایش پـروفـایل </span>
                    </a>
                    <a href="#">
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
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/user.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/user-hover.png') }}" alt="">
                    <span>پروفایل</span>
                </a>
            </li>
            <li class="right-Items">
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/notification.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/notification-hover.png') }}" alt="">
                    <span>اطلاعیه</span>
                </a>
            </li>
            <li class="right-Items">
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/pulse.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/pulse-hover.png') }}" alt="">
                    <span>فعالیت ها</span>
                </a>
            </li>
            <li class="right-Items">
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/storytelling.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/storytelling-hover.png') }}" alt="">
                    <span>دوره ها</span>
                </a>
            </li>
            <li class="right-Items">
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/video.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/video-hover.png') }}" alt="">
                    <span>وبینار ها</span>
                </a>
            </li>
            <li class="right-Items">
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/group.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/group-hover.png') }}" alt="">
                    <span>گروه ها</span>
                </a>
            </li>
            <li class="right-Items">
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/conversation.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/conversation-hover.png') }}" alt="">
                    <span>پیام ها</span>
                </a>
            </li>
            <li class="right-Items">
                <a href="#">
                    <img class="img" src="{{ asset('panel-assets/Images/Dashboard/header/exit.png') }}" alt="">
                    <img class="hover" src="{{ asset('panel-assets/Images/Dashboard/header/exit-hover.png') }}" alt="">
                    <span>خروج</span>
                </a>
            </li>
        </ul>
    </nav>
</header>

@yield('content')


</body>
</html>