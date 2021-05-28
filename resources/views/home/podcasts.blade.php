@extends('layouts.home.master-home')

@section('title') {{ $page_title }} @endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
@endsection

@section('content')
    <!--start prodocts section-->
    <section class="container archive my-5">
        <div class="row text-right">

            <div class="col-lg-12">
                <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
                    <h1 class="section_heading font_size_3">پادکست های <span>تک وان 24</span></h1>
                    <div class="d-flex justify-content-center">
                        <button class="all-cats" onclick="showCategory('all')"><i class="icon-view_comfy"></i></button>
                        <menu class="dropdown mr-3">
                            <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown"> جدیدترین پادکست ها </button>
                            <ul class="dropdown-menu">
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" onclick="showCategory('new')">جدیدترین پادکست ها</li>
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" onclick="showCategory('popular')">پربازدیدترین پادکست ها</li>
                            </ul>
                        </menu>
                    </div>
                </div>
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="box_col tab all new">
                                <div class="box_skin">
                                    <img src="{{$post->getPicture()}}" alt="" class="box_img">
                                    <div class="img-overlay"></div>
                                </div>
                                <div class="box_content">
                                    <h2 class="mb-3 black-text text-bold font_size_2">
                                        <a href="{{route('post.show',['post'=>$post->slug])}}">
                                            {{$post->title}}
                                        </a>
                                    </h2>
                                    <p class="font_size_0_8">{{$post->short_description}}</p>
                                </div>
                                <div class="box-footer">

                                    <div>
                                    <span>
                                        10:00 <img src="{{asset('assets/imgs/iconfinder_10_171505.png')}}" alt="">
                                    </span>
                                    </div>
                                    <div>
                                    <span>
                                        199 <img src="{{asset('assets/imgs/iconfinder_view-show_3671905.png')}}" alt="">
                                    </span>
                                        <span>
                                        10 <img src="{{asset('assets/imgs/iconfinder_icons_Message_1564513.png')}}" alt="">
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                  {{ $posts->links() }}

            </div>
        </div>
    </section>
    <!--end products section-->
@endsection
