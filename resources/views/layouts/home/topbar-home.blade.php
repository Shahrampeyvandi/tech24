<!--start topbar-->
<section class="topbar ">
    <div class="container container-fluid">
        <div class="topbar_row d-flex justify-content-sm-between align-items-center">
            <div class="d-flex justify-content-sm-between topbar_col">
                @auth

                <div class="dropdown social_icon" style="cursor: pointer">
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
                <a href="{{ route('login') }}" class="topbar_rigester">ثبت نام / ورود</a>
                @endauth
                <a href="{{\App\Setting::where('key',\App\Setting::Twitter)->first()->value ?? '#' }}"
                    class="social_icon"><i class="icon-twitter"></i></a>
                <a href="{{\App\Setting::where('key',\App\Setting::Facebook)->first()->value ?? '#' }}"
                    class="social_icon"><i class="icon-facebook"></i></a>
                <a href="{{\App\Setting::where('key',\App\Setting::Instagram)->first()->value ?? '#' }}"
                    class="social_icon"><i class="icon-instagram"></i></a>
                <a href="{{\App\Setting::where('key',\App\Setting::Youtube)->first()->value ?? '#' }}"
                    class="social_icon"><i class="icon-youtube-play"></i></a>
            </div>

            <div class="text-white topbar_col">
                <label for="searchbox_toggle" class="mx-3"><i class="icon-search"></i></label>
                <a href="#" class="text-white mr-4"><i class="icon-phone mr-1"></i>
                    {{\App\Setting::where('key',\App\Setting::Mobile)->first()->value ?? '' }}</a>
                <a href="#" class="text-white"><i class="icon-envelope mr-1"></i>
                    {{\App\Setting::where('key',\App\Setting::Email)->first()->value ?? '' }}</a>
            </div>
        </div>
    </div>
</section>
<!--end top bar-->