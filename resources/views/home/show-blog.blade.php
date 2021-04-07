@extends('layouts.home.master-home')
@section('title')
{{$title}}
@endsection

@section('content')

<!--start product section-->
<section class="product my-5">
    {{-- @include('common-components.category-breadcrumb',['post'=>$blog,'post_type'=>'وبینار' , 'categories' => $blog->getImplodeCategories()]) --}}
    <div class="container px-3 py-2 product_container">
        <div class="row">
            <div class="col-md-4 col-sm-12 text-center product_img">
                <img src="{{ $blog->getPicture() }}" class="w-100" alt="{{ $blog->title }}">
            </div>
            <div class="col-md-12">
                {!! $blog->description !!}
            </div>

        </div>
    </div>
</section>
<!--end product section-->
<br>
@include('common-components.cta-section')
<br><br>
@if (count($related_blogs))

<div class="container">
    <div class="posts_row">
        @foreach ($related_blogs as $item)
        @include('common-components.blog-item',['blog'=>$item])
        @endforeach
    </div>
</div>
@endif
@endsection