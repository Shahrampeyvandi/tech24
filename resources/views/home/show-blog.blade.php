@extends('layouts.home.master-home')

@section('title')
{{$title}}
@endsection

@section('content')

@php
    $commentsCount = $blog->comments()->where(['approved'=>1])->count();
@endphp

<!--start product section-->
<section class="product my-5">
    {{-- @include('common-components.category-breadcrumb',['post'=>$blog,'post_type'=>'وبینار' , 'categories' => $blog->getImplodeCategories()]) --}}
    <div class="container px-3 py-2 product_container">
        <div class="row">
            <div class="col-md-12 text-center product_img">
                <img src="{{ $blog->getPicture() }}" class="w-100" alt="{{ $blog->title }}">
            </div>
            <div class="col-md-12 blog-description">
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

<div class="container">

    <div class=" width-res">
        <h4>دیدگاه ها
            @if ($commentsCount )
            <span class="badge badge-primary"> {{$commentsCount}}</span>

            @else
            <span class="badge badge-primary">هنوز دیدگاهی ثبت نشده است</span>
            @endif
        </h4>
        <button class="addcmbtn" onclick="addComment(event)">افزودن دیدگاه</button>
    </div>
    <div class="col-md-12 mt-5" style="float: none !important;">
        <form id="comment" action="{{route('comment.insert')}}" method="post"
            style="direction: rtl;text-align: right;{{$commentsCount ? 'display: none;' : ''}}">
            @csrf
            <input type="hidden" name="parent_id" value="0">
            <input type="hidden" name="blog_id" value="{{$blog->id}}">
            <textarea name="comment" id="" rows="5" class="form-control"></textarea>
            <button class="btn btn-primary mt-3">ارسال</button>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12 mb-5">
            @foreach($comments as $parentComment)
            @include('common-components.comment-article',['comment'=>$parentComment])
            @endforeach
            {{$comments->links()}}
        </div>
    </div>
</div>
</div>

@endsection