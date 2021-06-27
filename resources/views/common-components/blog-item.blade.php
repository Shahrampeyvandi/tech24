<article class="post_box">
    <div class="post_skin">
        <img src="{{ $blog->getPicture() }}" alt="" class="post_img">
    </div>
    <div class="post_box_content">
        <h1 class="post_box_title">{{ $blog->getTitle() }}</h1>
        <p class="post_box_desc">{!! Str::limit($blog->short_description, 150, '...') !!}</p>
    </div>
    <a href="{{ $blog->url() }}" class="post_box_link">ادامه مطلب</a>
</article>