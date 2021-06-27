<h1 class="font_size_2 text-bold black-text">{{$title}} </h1>
    <ul class="blue-list pr-4">
    
       @foreach ($posts as $post)
       <li><a href="{{ route('post.show',$post->slug) }}">{{ $post->title }}</a></li>
       @endforeach
</ul>