@extends('layouts.home.master-home')
@section('title')
{{$title}}
@endsection

@section('css')
<link href="https://vjs.zencdn.net/7.7.6/video-js.css" rel="stylesheet" />
<style>
    .lesson-content {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .lesson-content .links {
        text-align: left;
    }

    .lesson-content .links.disabled a {
    color: #a0b9e5;
    }

    .lesson-content .links a {
        color: #234175;
    width: 30px;
    background: #e6e9ef;
    text-align: center;
    align-items: center;
    vertical-align: middle;
    padding: .5rem;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: inline-block;
    }
    .lesson-content .links a i{
        font-size: 1.5rem;
    }
</style>
@endsection
@section('scripts')
<script src="https://vjs.zencdn.net/7.7.6/video.js"></script>
<script>
    // var video = videojs('player');
    // video.responsive(true);
    
  
    
</script>

@endsection
@section('content')
<!--start product section-->
<section class="product my-5">
    @include('common-components.category-breadcrumb',['post'=>$post,'post_type'=>'دوره' , 'categories' =>
    $post->getImplodeCategories()])
    <div class="container px-3 py-2 product_container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 text-center product_img">
                <img src="{{ URL::asset($post->picture) }}" class="w-100" alt="{{ $post->title }}">
            </div>
            @include('common-components.post-details',['post'=>$post,'showbtn'=>true])
        </div>
    </div>
</section>
<!--end product section-->
<br>
@include('common-components.cta-section')
<br><br>
<!--start lessons section-->
<div class="row">
    <div class="col-md-12">
        <div class="container">
            <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
                <h1 class="section_heading font_size_2">لیست درسهای دوره</span></h1>
              
            </div>
            @forelse ($post->lessons()->orderBy('number','asc')->get() as $lesson)
            <div class="product_box product text-right row mb-5">
                <div class="col-lg-4 col-sm-12 col-xs-12 product_img">
                    {{-- <section id="play" class=" position-relative w-100">
                        <video class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" data-setup='{}' controls preload="auto"
                            id="player" controls>

                            <source src="{{$lesson->getFileUrl()}}" type='video/mp4' label='' />
                        </video>
                    </section> --}}

                    <img src="{{ $lesson->getPicture() }}" alt="{{ $lesson->title }}" class="img-fluid" style="height: 250px;object-fit: cover">
                </div>
                <div class=" col-lg-8 col-sm-12 col-xs-12 py-2 text-right product-content">
                    <div class="lesson-content">
                        <div>
                            <h3 class="product_heading">{{ $lesson->title }}</h3>

                            <p class="product_text">

                                {!! Str::limit($lesson->description, 400, '...') !!}
                            </p>
                        </div>

                        <div class="links {{ Auth::check() && getCurrentUser()->checkAllowForSeeLesson($lesson->id) ? '' :' disabled'}}">
                            <a href="#"><i class="icon-cloud_download"></i></a>
                            <a href="{{ Auth::check() && getCurrentUser()->checkAllowForSeeLesson($lesson->id) ? ''.route('play',$post->slug).'?lesson='.$lesson->id.'' :'#'}}"><i class="icon-play_circle_outline"></i></a>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div>
                <h4 class="font_size_2 text-right">هیچ درسی یافت نشد</h4>
            </div>
            @endforelse
            
          
        </div>
    </div>
</div>
<!--end lessons section-->

<br><br>
@if (count($related_posts))
@include('common-components.related_posts',['related_posts'=>$related_posts,'title'=>'دوره','title_section'=>'دوره های مرتبط'])
@endif
@endsection