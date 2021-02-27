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
            <h1 class="font_size_5 text-bold black-text">تماس با ما</h1>
            <a href="#" class="banner_subtext">خانه/تماس با ما</a>
        </div>
    </div>
</section>
<!--end banner-->
<br><br>
<!--start contact us section-->
<section class="contact_us">
    <div class="container">
        <div class="row text-right black-text align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <h1 class="font_size_3  text-bold mb-3">اطلاعات تماس <span class="orange-text">تک وان 24</span></h1>
                <b class="text-black mb-3"><i class="icon-phone ml-2"></i> شماره تلفن :</b>
                <p class="mb-4">{{\App\Setting::where('key',\App\Setting::Mobile)->first()->value ?? '' }}</p>
                <b class="text-black mb-3"><i class="icon-fax ml-2"></i> فاکس :</b>
                <p class="mb-4">{{\App\Setting::where('key',\App\Setting::Fax)->first()->value ?? '' }}</p>
                <b class="text-black mb-3"><i class="icon-envelope ml-2"></i> ایمیل:</b>
                <p class="mb-4">{{\App\Setting::where('key',\App\Setting::Email)->first()->value ?? '' }}</p>
                <b class="text-black mb-3"><i class="icon-map-marker ml-2"></i> آدرس :</b>
                <p class="mb-4">{{\App\Setting::where('key',\App\Setting::Address)->first()->value ?? '' }}</p>
                <b class="text-black mb-3"><i class="icon-home ml-2"></i> کد پستی :</b>
                <p class="mb-4">{{\App\Setting::where('key',\App\Setting::Postalcode)->first()->value ?? '' }}</p>
                <div class="contact_socials">
                    <a href="#" class="contact_social"><i class="icon-twitter"></i></a>
                    <a href="#" class="contact_social"><i class="icon-facebook"></i></a>
                    <a href="#" class="contact_social"><i class="icon-instagram"></i></a>
                    <a href="#" class="contact_social"><i class="icon-youtube-play"></i></a>
                </div>

            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 my-5 contact_us_form_wraper">
                <form action="{{ route('ticket.store') }}" method="POST" class="contact_us_form">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <label>نام </label>
                            <input type="text" name="firstname" value="{{ old('firstname') }}" required class="form-control">
                        </div>
                        <div class="col-6">
                            <label>نام خانوادگی</label>
                            <input type="text" name="lastname" value="{{ old('lastname') }}" required class="form-control">
                        </div>
                        <div class="col-12">
                            <label>ایمیل</label>
                            <input type="email" name="email" value="{{ old('email') }}"  class="form-control">
                        </div>
                        <div class="col-12">
                            <label>شماره تلفن</label>
                            <input type="number" name="mobile" value="{{ old('mobile') }}"  required class="form-control">
                        </div>
                        <div class="col-12">
                            <label>متن : </label>
                            <textarea required name="content" class="form-control no-resize"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="contact_us_btn btn_orange">ارسال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--end contact us -->
<br><br>
<!--start map-->
<iframe class="google_map" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d27261.877523233234!2d48.67366058786623!3d31.33869940089554!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fc3df1b208ad869%3A0x9fd64eaece9c90aa!2sKianpars%2C%20Ahvaz%2C%20Khuzestan%20Province!5e0!3m2!1sen!2s!4v1610809589989!5m2!1sen!2s"
    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
<!--end map-->
<br><br>
@endsection