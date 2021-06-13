<!--start topbar-->
<section class="topbar ">
    <div class="container container-fluid">
        <div class="topbar_row d-flex justify-content-sm-between align-items-center">
            <div class="topbar_right">
                @auth
                <div class="dropdown " style="cursor: pointer;margin-left: 1rem;">
                    <a class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ getCurrentUser()->username }}
                        <i class="icon-user"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('member.dashboard',getCurrentUser()->username) }}">پنل
                            کاربری</a>
                        <a class="dropdown-item" href="{{ route('logout') }}">خروج</a>

                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="topbar_rigester">
                    <i class="icon-lock ml-1"></i>
                    ورود
                
                </a>
                <a href="{{ route('register') }}" class="topbar_rigester">
                    <i class="icon-user ml-1"></i>
                    ثبت نام</a>
   
                @endauth
                |
                <a href="{{ url('/search') }}" class="searchbox_toggle mx-3" style="cursor: pointer" >
                    <i class="icon-search"></i>
                </a>
                {{-- <a href="{{\App\Setting::where('key',\App\Setting::Twitter)->first()->value ?? '#' }}"
                    class="social_icon"><i class="icon-twitter"></i></a> --}}
                {{-- <a target="_blank" href="{{\App\Setting::where('key',\App\Setting::Facebook)->first()->value ?? 'https://t.me/techone24' }}"
                    class="social_icon"><i class="icon-facebook"></i></a>
                <a target="_blank" href="{{\App\Setting::where('key',\App\Setting::Instagram)->first()->value ?? 'https://instagram.com/techone24' }}"
                    class="social_icon"><i class="icon-instagram"></i></a> --}}
                {{-- <a href="{{\App\Setting::where('key',\App\Setting::Youtube)->first()->value ?? '#' }}"
                    class="social_icon"><i class="icon-youtube-play"></i></a> --}}
            </div>

            
                <a href="{{ URL::route('baseurl') }}">
                    <img src="{{ URL::asset('assets/imgs/Logo.png') }}" class="w-p-100" alt="Tech-one">
                </a>

                {{-- <a href="#" class=" mr-4"><i class="icon-phone mr-1"></i>
                    {{\App\Setting::where('key',\App\Setting::Mobile)->first()->value ?? '' }}</a>
                <a href="#" class=""><i class="icon-envelope mr-1"></i>
                    {{\App\Setting::where('key',\App\Setting::Email)->first()->value ?? '' }}</a> --}}
            
        </div>
    </div>
</section>
<!--end top bar-->