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
                <img src="{{ $post->getPicture() }}" class="w-100" alt="{{ $post->title }}">
            </div>
            @include('common-components.post-details',['post'=>$post,'showbtn'=>true])
        </div>
    </div>
</section>
<!--end product section-->
<br>
@include('common-components.cta-section')
<br><br>
@include('common-components.related_posts',['title_section' => 'وبینار های <span>تک وان 24</span>' ,'title'=> 'وبینار', 'related_posts' => $related_posts])
@endsection