@extends('layouts.home.master-home')

@section('title','تکوان | صفحه اصلی')

@section('content')

<!--start banner-->
<section class="banner banner_carousel">
    <div id="bannerCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($sliders as $key=>$slider)
            <div class="carousel-item text-right {{$key == 0 ? ' active' : ''}}">

                <div class="banner_content">
                    <h1 class="banner_title">{{$slider->title}}</h1>
                    <div class="banner_border"></div>
                    <p class="banner_desc">
                        {!! Str::limit($slider->description, 300, '...') !!}</p>
                    <a href="{{ route('post.show',$slider->post->slug) }}" class="banner_btn btn_orange btn btn-lg mb-2">مشاهده ادامه مطالب</a>
                    {{-- <a href="#" class="banner_btn btn btn-lg">ثبت نام در وبینار</a> --}}
                </div>
                <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                <div
                    style="position: absolute;right:0;left:0;top:0;bottom:0;background: linear-gradient(270deg, rgba(28,60,114,1) 0%, rgba(28,60,114,0.8211659663865546) 30%, rgba(255,255,255,0) 100%);">
                </div>
            </div>
            @endforeach


        </div>
        <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

        <ol class="carousel-indicators">
            <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#bannerCarousel" data-slide-to="1"></li>
            <li data-target="#bannerCarousel" data-slide-to="2"></li>
        </ol>
    </div>
</section>
<!--end banner-->
<br><br>
@include('common-components.cta-section')
<br><br>
@if (isset($webinars) && count($webinars))
<!--start webinar section-->
<section class="webinar">
    <div class="container">
        <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
            <h1 class="section_heading">وبینار های <span>تک وان 24</span></h1>
            <div class="divider"></div>
            <menu class="dropdown">
                <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown">
                لیست
                </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-item"><a href="{{ url('webinars') }}">جدیدترین وبینار ها</a></li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item"><a href="{{ url('webinars') }}">پرفروش ترین وبینار ها</a></li>
                </ul>
            </menu>
        </div>
        <!--BOX ROW-->
        <div class="box_row">
            @foreach ($webinars as $webinar)
                @include('common-components.post-item',['post'=>$webinar])
            @endforeach
        </div>
    </div>
</section>
<!--end webinar section-->
<br><br>
@endif
<!--start suggestion-->
<section class="suggestion">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 text-center sg_img">
                <img src="assets/imgs/suggestion_man.jpg" alt="">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 text-right sg-content">
                {{-- <h2 class="sg_heading">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                </h2>
                <div class="sg_sub_heading">
                    <small><i class="icon-user"></i> مدرس : ابراهیم خالدی</small>
                    <small><i class="icon-calander"></i> زمان برگزاری : 1399/10/30</small>
                    <small><i class="icon-clock"></i>طول دوره : 52 ساعت</small>
                </div> --}}
        <div style="display: flex;align-items: center;height: 100%;">
            <p class="sg_text" style="line-height: 2.3rem;text-align: justify;">
                سایت آموزشی تک وان 24 با هدف ارتقاء سطح علمی در زمینه امنیت اطلاعات راه اندازی شده است و در این سایت قصد داریم تا شما را با جدیدترین آسیب پذیری ها و روش های دفاعی مربوط به این آسیب پذیری ها و نیز روش های جرم شناسی در زمینه امنیت اطلاعات آشنا کنیم در این راستا با برگزاری وبینارهای آموزشی و نیز مقالات و پادکست ها و فیلم های آموزشی کنار شما خواهیم بود و برای رسیدن به این هدف  از امکانات آموزشی لازم و مدرسین مجرب که چندین سال در زمینه امنیت سابقه دارند استفاده شده است .               
                 </p>
        </div>
                {{-- <div class="sg_details row">
                    <div class="col-6 col-xs-12">
                        <ul>
                            <li class="orange_list"> این یک تن نمونه می باشد و با متن اصلی جایگزین میشود.</li>
                            <li class="orange_list"> این یک تن نمونه می باشد و با متن اصلی جایگزین میشود.</li>
                            <li class="orange_list"> این یک تن نمونه می باشد و با متن اصلی جایگزین میشود.</li>
                        </ul>
                    </div>
                    <div class="col-6 col-xs-12">
                        <ul>
                            <li class="orange_list"> این یک تن نمونه می باشد و با متن اصلی جایگزین میشود.</li>
                            <li class="orange_list"> این یک تن نمونه می باشد و با متن اصلی جایگزین میشود.</li>
                            <li class="orange_list"> این یک تن نمونه می باشد و با متن اصلی جایگزین میشود.</li>
                        </ul>
                    </div>
                </div> --}}
                <br>
                {{-- <div class="sg_details float-left">
                    <div class="cost d-flex align-items-center">
                        <div class="cost_icon">
                            <img src="assets/imgs/wallet.png" alt="">
                        </div>
                        <div class="cost_detail mr-3">
                            <h6>قیمت :</h6>
                            <b>400 هزار تومان</b>
                        </div>
                        <a href="#" class="btn btn-lg btn_orange mr-4 mt-2">ثبت نام در دوره</a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</section>
<!--end suggestion-->
<br>

<!--start courses-->
<section>
    <h1 class="text-center font_size_3 text-bold">دوره های آموزشی ما</h1>
    <br>
    <div class="container">
        <div class="d-flex align-items-center flex-wrap justify-content-sm-between">
            <div class="course-item">
                <img src="assets/imgs/linux.png" class="dark_img" alt="linux">
            </div>
            <div class="course-item">
                <img src="assets/imgs/microsoft_b.png" class="dark_img" alt="linux">
            </div>
        
            <div class="course-item">
                <img src="assets/imgs/sans_black.png" class="dark_img" alt="linux">
            </div>
           
           
            <div class="course-item">
                <img src="assets/imgs/cisco_black_0.png" class="dark_img" alt="linux">
            </div>
          
        </div>
    </div>
</section>

<br><br>
@if (isset($courses) && count($courses))
<!--COURSES CARD-->
<section class="courses">
    <div class="container">
        <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
            <h1 class="section_heading">دوره های <span>تک وان 24</span></h1>
            <div class="divider"></div>
            <menu class="dropdown">
                <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown">
                    لیست
                </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-item"><a href="{{ url('courses') }}">جدیدترین دوره ها</a></li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item"><a href="{{ url('courses') }}?order=sell_count">پرفروش ترین دوره ها</a></li>
                </ul>
            </menu>
        </div>

        <!--BOX ROW-->
        <div class="box_row">
            @foreach ($courses as $course)
             @include('common-components.post-item',['post'=>$course])
            @endforeach
        </div>
    </div>
</section>
<!--end courses-->
<br><br>
@endif
@if (isset($teachers) && count($teachers))
<!--start teacher section-->
<section class="teacher_section">
    <div class="container">
        <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
            <h1 class="section_heading">اساتید نمونه <span>تک وان 24</span></h1>
            <div class="divider"></div>
            <a class="btn btn-md btn-gray">مشاهده همه موارد</a>
        </div>
        <div class="teacher_row">
            @foreach ($teachers as $teacher)
            <div class="teacher_card">
                <div class="teacher_card_img">
                    <img class="teacher_img" src="{{ asset($teacher->avatar) }}" alt="{{ fullName($teacher->id) }}">
                    <div class="techone_logo"></div>
                </div>
                <div class="teacher_card_content">
                    <p class="teacher_name">{{ fullName($teacher->id) }}</p>
                    <p class="teacher_info">مدرس {{ $teacher->ability }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
<!--end teacher section-->
<br><br><br>
@endif
<!--start blogs section-->
<section class="posts">
    <div class="container">
        <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
            <h1 class="section_heading">آخرین اخبار وبلاگ</h1>
            <div class="divider"></div>
            <a href="{{ url('blogs') }}" class="btn btn-md btn-gray">مشاهده همه موارد</a>
        </div>
        <div class="posts_row">
            @foreach ($blogs as $blog)
                @include('common-components.blog-item',['blog'=>$blog])
            @endforeach

        </div>
    </div>
</section>
<!--end blogs section-->
<br><br>
@endsection