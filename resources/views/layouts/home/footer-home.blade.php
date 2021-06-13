     <!--start footer-->
     <footer class="footer_wraper">
        <div class="container pt-4">
            <h3 class="text-bold text-center text-white font_size_2">عضویت در خبر نامه</h3>
            <div class="footer_rg">
                <input type="text" class="footer_field" placeholder="ایمیل یا نام کاربری">
                <button class="footer_rg_btn btn_orange">عضویت</button>
            </div>
            <div class="row text-right">
                <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 ml-auto">
                    <div class="d-flex align-items-center">
                        <img height="80px" src="imgs/Logo-white.png" class="ml-3" alt="">
                        <div>
                            <h2 class="footer_col_heading">درباره ما</h2>
                            <p class="footer-text">
                                {{\App\Setting::where('key',\App\Setting::About_us)->first()->value ?? 'سایت آموزشی تک وان 24 با هدف ارتقاء سطح علمی در زمینه امنیت اطلاعات راه اندازی شده است و در این سایت قصد داریم تا شما را با جدیدترین آسیب پذیری ها و روش های دفاعی مربوط به این آسیب پذیری ها و نیز روش های جرم شناسی در زمینه امنیت اطلاعات آشنا کنیم در این راستا با برگزاری وبینارهای آموزشی و نیز مقالات و پادکست ها و فیلم های آموزشی کنار شما خواهیم بود و برای رسیدن به این هدف از امکانات آموزشی لازم و مدرسین مجرب که چندین سال در زمینه امنیت سابقه دارند استفاده شده است .' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="footer_col_heading ">لینک ها</h2>
                    <ul class="pd-0">
                        <li class="orange_list"><a href="{{route('baseurl')}}">خانه</a></li>
                        <li class="orange_list"><a href="{{ url('blogs') }}">بلاگ</a></li>
                        @if (! Auth::check())
                        <li class="orange_list"><a href="{{ route('register') }}">ثبت نام</a></li>
                        @endif
                       
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="footer_col_heading">لینک ها</h2>
                    <ul class="pd-0">
                        {{-- <li class="orange_list"><a href="{{ url('courses') }}">دوره ها</a></li> --}}
                        {{-- <li class="orange_list"><a href="{{ url('webinars') }}">وبینار ها</a></li> --}}
                        <li class="orange_list"> <a href="{{ url('webinars') }}?q=archive">وبینار های گذشته</a></li>
                        <li class="orange_list"><a href="{{ url('webinars') }}">وبینار های پیش رو</a></li>
                        <li class="orange_list"><a href="{{ url('podcasts') }}">پادکست</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="footer_col_heading">راه های ارتباطی</h2>
                    <ul class="footer_socials pd-0" >
                        <li class="footer_social">
                            <a href="{{\App\Setting::where('key',\App\Setting::Instagram)->first()->value ?? 'https://instagram.com/techone24' }}"><i class="icon-instagram instagram"></i></a>
                        </li>
                        {{-- <li class="footer_social">
                            <a href="{{\App\Setting::where('key',\App\Setting::Twitter)->first()->value ?? '#' }}"><i class="icon-twitter twitter"></i></a>
                        </li> --}}
                        {{-- <li class="footer_social">
                            <a href="#"><i class="icon-google google"></i></a>
                        </li> --}}
                        <li class="footer_social ">
                            <a href="{{\App\Setting::where('key',\App\Setting::Facebook)->first()->value ?? 'https://t.me/techone24' }}"><i class="icon-facebook facebook"></i></a>
                        </li>
                    </ul>
                    <a href="tel:09195278589" class="text-white" style="font-family: sans-serif;">  {{\App\Setting::where('key',\App\Setting::Mobile)->first()->value ?? '09195278589' }}  </a>
                    <br>
                    <a class="text-white" style="font-family: sans-serif;" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=support@techone24.com" target="_blank">Support@techone24.com </a>
                </div>
            </div>
        </div>
    </footer>
    <!--end footer-->
