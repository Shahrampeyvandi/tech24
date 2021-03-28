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
            <div class="col-lg-6 col-md-6 col-sm-12 text-center product_img">
                <img src="{{ URL::asset($blog->picture) }}" class="w-100" alt="{{ $blog->title }}">
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

@foreach ($related_blogs as $item)
    @include('common-components.blog-item',['blog'=>$item])
@endforeach
@endsection