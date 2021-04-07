     <!--start footer-->
     <footer class="footer_wraper">
        <div class="container pt-4">
            <h3 class="text-bold text-center text-white font_size_2">عضویت در خبر نامه</h3>
            <div class="footer_rg">
                <input type="text" class="footer_field" placeholder="ایمیل یا نام کاربری">
                <button class="footer_rg_btn btn_orange">عضویت</button>
            </div>
            <div class="row text-right">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="d-flex align-items-center">
                        <img height="80px" src="imgs/Logo-white.png" class="ml-3" alt="">
                        <div>
                            <h2 class="footer_col_heading">درباره ما</h2>
                            <p class="footer-text">
                                {{\App\Setting::where('key',\App\Setting::About_us)->first()->value ?? 'این متن را تغییر دهید' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="footer_col_heading ">لینک ها</h2>
                    <ul class="pd-0">
                        <li class="orange_list"><a href="{{route('baseurl')}}">خانه</a></li>
                        <li class="orange_list"><a href="#">بلاگ</a></li>
                        @if (! Auth::check())
                        <li class="orange_list"><a href="{{ route('register') }}">ثبت نام</a></li>
                        @endif
                       
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="footer_col_heading">لینک ها</h2>
                    <ul class="pd-0">
                        <li class="orange_list"><a href="{{ url('courses') }}">دوره ها</a></li>
                        <li class="orange_list"><a href="{{ url('webinars') }}">وبینار ها</a></li>
                        <li class="orange_list"> <a href="{{ url('webinars') }}?q=archive">وبینار های گذشته</a></li>
                        <li class="orange_list"><a href="{{ url('webinars') }}">وبینار های پیش رو</a></li>
                        <li class="orange_list"><a href="#">پادکست</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="footer_col_heading">راه های ارتباطی</h2>
                    <ul class="footer_socials pd-0">
                        <li class="footer_social">
                            <a href="{{\App\Setting::where('key',\App\Setting::Instagram)->first()->value ?? '#' }}"><i class="icon-instagram instagram"></i></a>
                        </li>
                        <li class="footer_social">
                            <a href="{{\App\Setting::where('key',\App\Setting::Twitter)->first()->value ?? '#' }}"><i class="icon-twitter twitter"></i></a>
                        </li>
                        <li class="footer_social">
                            <a href="#"><i class="icon-google google"></i></a>
                        </li>
                        <li class="footer_social ">
                            <a href="{{\App\Setting::where('key',\App\Setting::Facebook)->first()->value ?? '#' }}"><i class="icon-facebook facebook"></i></a>
                        </li>
                    </ul>
                    <a href="#" class="text-white"><i class="icon-phone"></i> {{\App\Setting::where('key',\App\Setting::Mobile)->first()->value ?? '' }}</a>
                    <br>
                    <a href="#" class="text-white">{{\App\Setting::where('key',\App\Setting::Email)->first()->value ?? '' }} <i class="icon-envelope"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!--end footer-->
