    <!--start navbar-->
    <nav class="navbar_wraper" id="navbar">
        <div class="container navbar_inner container-fluid d-flex justify-content-sm-between align-items-center">
            <label for="navListToggle" class="open_navbar"><i class="icon-bars"></i></label>
            <input type="checkbox" class="d-none" name="" id="navListToggle">

            <ul class="nav_list">
                <label for="navListToggle" class="close_navbar"><i class="icon-close"></i></label>
                <li class="nav_item ">
                    <a href="{{ URL::route('baseurl') }}" class="nav_link">خانه</a>
                </li>
                <li class="nav_item">
                    <a href="{{ url('podcasts') }}" class="nav_link">پادکست</a>
                </li>
                <li class="nav_item">
                    <a href="{{ url('webinars') }}?q=archive" class="nav_link">آرشیو وبینار های گذشته</a>
                </li>
                <li class="nav_item">
                    <a href="{{ url('webinars') }}" class="nav_link">وبینار های پیشرو</a>
                </li>
                {{-- <li class=" nav_item">
                    <a href="{{ url('courses') }}" class="nav_link">دوره ها </a>
                 
                </li> --}}

                <li class="nav_item">
                    <a href="{{ url('blogs') }}" class="nav_link">بلاگ</a>
                </li>
                <li class="nav_item">
                    <a href="{{ URL::route('aboutus') }}" class="nav_link">درباره ما</a>
                </li>
                <li class="nav_item">
                    <a href="{{ URL::route('contactus') }}" class="nav_link">تماس با ما</a>
                </li>
                @if (Auth::check())
                <li class="nav_item d-block d-md-none">
                    <a href="{{ URL::route('member.dashboard',Auth::user()->username) }}" class="nav_link">پنل کاربری</a>
                </li>
                 @else   
                 <li class="nav_item d-block d-md-none">
                     <a href="{{ URL::route('login') }}" class="nav_link">ورود</a>
                 </li>
                @endif
            </ul>
        </div>
    </nav>
    <!--end nvabar-->