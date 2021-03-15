@extends('layouts.home.master-home')

@section('title') {{ $page_title }} @endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
@endsection

@section('content')
    <!--start prodocts section-->
    <section class="container product my-5">
        <div class="row text-right">
            @component('common-components.category-list',['latest_posts'=>$latest_posts,'post_type'=>$post_type])
            @endcomponent
            <div class="col-lg-9">
                <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
                    <h1 class="section_heading font_size_2">{{$title}} های <span>تک وان 24</span></h1>
                    <div class="archive_options">
                        <a class="cats_group_link" href="archive.html"><i class="icon-view_comfy"></i></a>
                        <a class="cats_group_link active" href="products.html"><i class="icon-view_list"></i></a>
                        <menu class="dropdown mr-2">
                            <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown"> جدیدترین {{$title}} ها </button>
                            <ul class="dropdown-menu">
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" onclick="showCategory('new')">جدیدترین {{$title}} ها</li>
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" onclick="showCategory('popular')">پرفروش ترین ها</li>
                            </ul>
                        </menu>
                    </div>
                </div>
                <!--PRODUCT BOX-->
                <div class="row mr-1">

                    @foreach ($posts as $post)
                        <!--PRODUCT BOX-->
                    <div class="product_box product text-right row">
                      <div class="col-xl-4 col-lg-12 col-sm-12 col-xs-12 product_img">
                          <img src="{{ asset($post->picture) }}" alt="{{ $post->title }}">
                      </div>
                      @include('common-components.post-details',['post'=> $post,'showbtn'=>true,'showmore'=>true])
                  </div>
                    @endforeach

               
                </div>
                {{ $posts->links() }}
              
            </div>
    </section>
    <!--end products section-->
@endsection