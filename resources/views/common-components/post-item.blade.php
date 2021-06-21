<div class="box_col">
    <div class="box_skin">
        <img src="{{$post->getPicture()}}" alt="{{ $post->title }}" class="box_img">
        <div class="box_overlay">
            <p class="box_overlay_item">شروع دوره :
                {{ \Morilog\Jalali\Jalalian::forge($post->start_date)->ago() }}</p>
            <p class="box_overlay_item">زمان برگزاری : {{ jalaliDate($post->start_date) }}</p>
            <a href="{{ route('post.show',$post->slug) }}" class="box_overlay_item box_overlay_btn">مطالعه بیشتر</a>
        </div>
    </div>
    <div class="box_content">
       <div>
        <h3 class="mb-2">
            <a href="#" style="color: var(--gray);">{{ $post->title }}</a></h3>
        <a href="#" class="box_desc">{!! Str::limit($post->short_description, 100, '...') !!}</a>
       </div>
        <small class="box_subtext"><i class="icon-user-o"></i> مدرس : {{ $post->getTeacher() }}</small>
    </div>
</div>