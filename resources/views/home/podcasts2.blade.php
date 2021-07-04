@extends('layouts.home.master-home')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

</head>

<style>
@font-face {
font-family: "primary-font";
src: url("/assets/fonts/iran-sans-300.eot");
src: url("/assets/fonts/iran-sans-300.eot?#iefix") format("embedded-opentype"),
     url("/assets/fonts/iran-sans-300.woff2") format("woff2"),
     url("/assets/fonts/iran-sans-300.woff") format("woff"),
     url("/assets/fonts/iran-sans-300.ttf") format("truetype");
font-weight: 300;
}
body{
font-family: 'primary-font';
font-weight: 300;
overflow-x: hidden;
background-color: #fcfdfd;
}
.podcasts-header{
    background: linear-gradient( to bottom, rgb(28 60 114 / 40%), rgb(28 60 114) ), 
    url(/assets/imgs/microphone-podcast-radio-ss-1920.jpg);
    background-size: cover;
}
section {

    /* background-color: darkblue; */
    color: black;
}

.flex-column-center {
    display: flex;
    flex-direction: column;
    height: 100%;
    align-items: center;
    justify-content: center;

}

.min-height-300 {
    min-height: 300px;
}

.py-8 {
    padding-top: 4rem;
    padding-bottom: 4rem;
}

.w-70 {
    width: 70%;
}

.w-30 {
    width: 30%;
}

.categories-title h3 {
    position: relative;
    display: inline-block;
    padding-top: 8px;
    padding-right: 8px;
    padding-bottom: 8px;
    padding-left: 8px;

}

.categories-title h3::after,
.categories-title h3::before {
    content: "";
    position: absolute;
    top: calc(50% - ((.2px + .05em)/ 2));
    width: 400px;
    border-bottom: calc(.2px + .05em) solid #e5e5e5;
}

.categories-title h3::after {
    right: 100%;
    margin-right: calc(5px + .3em);
}

.categories-title h3::before {
    left: 100%;
    margin-left: calc(5px + .3em);
}

.category--item {
    display: inline-block;
}
.category-title {
    margin-top: 1rem;
    font-size: 1rem;
    color: #444444;
    text-align: right;
}

.fs-0-8{
    font-size: .8rem;
}

.category--item>div {
    padding: 1rem 2rem;
    display: flex;
    flex-direction: column;
    box-shadow: 0 5px 15px rgb(0 0 0 / 22%);

}

.swiper-container {
    padding: 2rem 0;
}

.swiper-scrollbar-drag {

    background: rgb(0 0 0 / 18%);

}

.tabs {
    display: flex;
    flex-wrap: wrap;
    margin-right: -20px;
    padding: 0;
    list-style: none;
    position: relative;
}

.tabs::before {
    content: "";
    position: absolute;
    bottom: 0;
    right: 20px;
    left: 0;
    border-bottom: 1px solid #e5e5e5;
}


.tabs>* {
    flex: none;
    padding-right: 20px;
    position: relative;
}

.tabs a {
    display: block;
    text-align: center;
    padding: 5px 10px;
    color: #999;
    border-bottom: 1px solid transparent;
    text-transform: uppercase;
    transition: color .1s ease-in-out;
}

li.link-active a {
    color: #0f6ecd;
    font-weight: bold;
    border-color: #0f6ecd;
}
.podcast-item{
    text-align: right;
    box-shadow: 0 5px 15px rgb(0 0 0 / 22%);
}
.podcast-item .content{
    padding: .7rem;
}

.btn_orange{
    text-align: center;
    
}

.podcast-search-results{
    background: #f1f1f1;
    border: 1px solid #d2d2d2;
    text-align: right;
    padding: .5rem;
    position: absolute;
    right: 0;
    margin: 0 15px;
    z-index: 1;
    left: 0;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    margin-top: .1rem;
}

@media (max-width:768px) {
    .categories-title h3::after,
.categories-title h3::before {
    content: none;
   
}
}
</style>
@endsection
@section('scripts')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 6,
            spaceBetween: 20,
            scrollbar: {
                el: ".swiper-scrollbar",
                hide: false,
            },
           // Responsive breakpoints   
   breakpoints: {  
   
   // when window width is <= 320px     
   320: {       
      slidesPerView: 2,
      spaceBetween: 10     
   },     
   // when window width is <= 480px     
   480: {       
      slidesPerView: 3,       
      spaceBetween: 10     
   },   

   // when window width is <= 640px     
   640: {       
      slidesPerView: 4,       
      spaceBetween: 10     
   } , 1100: {       
      slidesPerView: 6,       
      spaceBetween: 10     
   } ,

} ,
           
        });
    </script>
@endsection

@section('content')
    
<search-podcast-component></search-podcast-component>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center categories-title mb-3 mt-5">
                    <h3>دسته بندی پادکست ها</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="swiper-container mySwiper">
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                       @foreach (\App\Category::latest()->get() as $item)
                       <div class="swiper-slide">
                        <a href="{{ url('podcasts',['category'=>$item->slug]) }}" class="category--item">
                            <div>
                                <img src="{{ asset($item->picture) }}" style="width: 50px" alt="">
                                <span class="category-title">
                                    {{$item->title}}
                                </span>
                            </div>
                        </a>
                    </div>
                       @endforeach
                     

                    </div>
                    <div class="swiper-scrollbar"></div>
                </div>



            </div>
        </div>
    </div>
</section>


<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-md-12">
                <ul class="tabs">
                    
                    <li class="{{ $order == 'created_at' ? 'link-active' : ''  }}"><a href="{{ url('podcasts',['category'=>$category]) }}">جدیدترین</a></li>
                    <li class="{{ $order == 'views' ? 'link-active' : ''  }}"><a href="{{ url('podcasts',['category'=>$category]) }}?order=views">محبوبترین</a></li>
                </ul>
            </div>
           
        </div>
        <div class="row">
            @foreach ($posts as $item)
            <div class="col-md-3 mt-2 mb-5" >
                <div class="podcast-item">
                    <a href="">
                        <img class="w-100" src="{{$item->getPicture()}}" alt="">
                    </a>

                    <div class="content">
                        <audio controls="" preload="none" style="width: 100%;">
                            <source src="{{$item->getFileUrl()}}"
                                type="audio/mp3">
                        </audio>
                        <a href="{{route('post.show',['post'=>$item->slug])}}">{{ $item->title }}</a>
                        <div class="d-flex justify-content-between mt-3">
                            <span class="fs-0-8">{{ jalaliDate($item->created_at) }}</span>
                            <span class="fs-0-8"> 3 دیدگاه</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
         
        </div>
    </div>
</section>

@endsection