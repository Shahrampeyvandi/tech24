@extends('layouts.home.master-home')
@section('title') تکوان | درباره ما @endsection

@section('css')
<link rel="stylesheet" href="assets/css/style.css">
@endsection

@section('content')
    <!--start banner-->
    <section class="banner">
        <div class="container text-center">
            <div class="banner_content">
                <h1 class="font_size_5 text-bold black-text">درباره ما</h1>
                <a href="#" class="banner_subtext">خانه/درباره ما</a>
            </div>
        </div>
    </section>
    <!--end banner-->
    <br><br>
    <!--start about us section-->
    <section class="about_us">
        <div class="container">
            <div class="row text-right align-items-center">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <img src="assets/imgs/researcher.jpg" class="img_cover">
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12 pt-3">
                    <p style="    line-height: 2rem;
                    text-align: justify;">
                        سایت آموزشی تک وان 24 با هدف ارتقاء سطح علمی در زمینه امنیت اطلاعات راه اندازی شده است و در این سایت قصد داریم تا شما را با جدیدترین آسیب پذیری ها و روش های دفاعی مربوط به این آسیب پذیری ها و نیز روش های جرم شناسی در زمینه امنیت اطلاعات آشنا کنیم در این راستا با برگزاری وبینارهای آموزشی و نیز مقالات و پادکست ها و فیلم های آموزشی کنار شما خواهیم بود و برای رسیدن به این هدف  از امکانات آموزشی لازم و مدرسین مجرب که چندین سال در زمینه امنیت سابقه دارند استفاده شده است .

                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--end about us section content-->
  
    <!--end-->
    <br><br>
@endsection