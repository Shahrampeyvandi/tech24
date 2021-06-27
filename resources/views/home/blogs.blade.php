@extends('layouts.home.master-home')

@section('title') {{ $page_title }} @endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
@endsection

@section('content')
    <!--start prodocts section-->
    <section class="container product my-5">
        <div class="row text-right">
            <div class="col-lg-12">
                <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
                    <h1 class="section_heading font_size_2">{{$title}} های <span>تک وان 24</span></h1>
                    <div class="archive_options">
                        {{-- <a class="cats_group_link" href="archive.html"><i class="icon-view_comfy"></i></a>
                        <a class="cats_group_link active" href="products.html"><i class="icon-view_list"></i></a> --}}
                        <menu class="dropdown mr-2">
                            <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown"> جدیدترین {{$title}} ها </button>
                            <ul class="dropdown-menu">
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" ><a href="{{ url('blogs') }}">جدیدترین {{$title}} ها</a></li>
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" ><a href="{{ url('blogs') }}?order=views">پربازدید {{$title}} ها</a></li>
                            </ul>
                        </menu>
                    </div>
                </div>
                    @foreach ($blogs as $blog)
                    <div class="product_box product text-right row" style="width: auto">
                        <div class="col-xl-2 col-lg-12 col-sm-12 col-xs-12 product_img">
                            <a href="{{ $blog->url() }}" >
                                <img src="{{ $blog->getPicture() }}" alt="{{ $blog->title }}">
                            </a>
                        </div>
                        <div class="col-xl-10 col-lg-12 col-sm-12 col-xs-12 py-3 text-right product-content">
                            <h2 class="product_heading">{{ $blog->title }}</h2>
                           
                            <p class="product_text">
  
                                {!! Str::limit($blog->short_description, 400, '...') !!}
                            </p>
                            <br>
                            <div class="text-left">
                                <a href="{{ $blog->url() }}" class="py-2 px-5 btn_orange mr-4 mt-2">
                                    ادامه مطلب
                                  </a>
                            </div>
                            
                        </div>
                    </div>
                    @endforeach

               
                {{ $blogs->links() }}
              
            </div>
    </section>
    <!--end products section-->
@endsection