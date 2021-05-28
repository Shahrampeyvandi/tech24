<div class="commentbox {{isset($child) && $child ? ' child-comment' : ''}}">
    <img src="{{asset('assets/imgs/icons8-male-user-100.png')}}" alt="" class="img-responsive , col-sm-1.2 , profileimg" >
    <div class="comment">
        <h5>{{$comment->getAutor()}} </h5>
        <p >{{$comment->getDate()}}</p>
        <br>
        <p class="text-muted">
            {!! $comment->comment !!}
        </p>
    </div>
    <button class="reply" onclick="addComment(event)" data-id="{{$comment->id}}"></button>
</div>
@foreach(\App\Comment::where(['parent_id'=>$comment->id,'approved'=>1])->latest()->get() as $comment)
    @include('common-components.comment-article',['comment'=>$comment,'child'=>true])
@endforeach

