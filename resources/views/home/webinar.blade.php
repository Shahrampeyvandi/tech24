@extends('layouts.home.master-home')
@section('title')
{{$title}}
@endsection
@section('content')
<!--start product section-->
<section class="product my-5">
    @include('common-components.category-breadcrumb',['post'=>$post,'post_type'=>'وبینار' , 'categories' => $post->getImplodeCategories()])
    <div class="container px-3 py-2 product_container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 text-center product_img">
                <img src="{{ URL::asset($post->picture) }}" class="w-100" alt="{{ $post->title }}">
            </div>
            @include('common-components.webinar-details',['webinar'=>$post])
        </div>
    </div>
</section>
<!--end product section-->
<br>
@include('common-components.cta-section')
<br><br>
<!--start webinar section-->
<section class="webinar mb-5">
    <div class="container">
        <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
            <h1 class="section_heading">وبینار های <span>تک وان 24</span></h1>
            <div class="divider"></div>
            <menu class="dropdown">
                <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown"> همه وبینار ها </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-item" onclick="showCategory('all')"> همه وبینار ها </li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item" onclick="showCategory('new')">جدیدترین وبینار ها</li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item" onclick="showCategory('popular')">پرفروش ترین ها</li>
                </ul>
            </menu>
        </div>
        <!--BOX ROW-->
        <div class="box_row">

        @foreach ($all_webinars as $item)
        @include('common-components.post-item',['post'=>$item])
        @endforeach
           
        </div>
    </div>
</section>
<!--end webinar section-->
@endsection