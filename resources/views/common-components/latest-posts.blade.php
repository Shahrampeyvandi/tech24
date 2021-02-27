<h1 class="font_size_2 text-bold black-text">{{$title}} </h1>
    <ul class="blue-list pr-4">
       @foreach ($posts as $post)
       <li><a href="{{ $post->url() }}">{{ $post->title }}</a></li>
     
       @endforeach
    </ul>