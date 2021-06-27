@php
    $commentsCount = $post->comments()->where(['approved'=>1])->count();
@endphp

@extends('layouts.home.master-home')


@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
<style>
    .plyr--audio {
        display: block;
        width: 100%;
    }

    .plyr--audio .plyr__controls {
        background: #22375a;
        color: white;
    }
</style>
@endsection


@section('content')
<header class=" text-right , headerstyle , overlay">
    <div id="overlay">
        <div class="container">
            <h3 class="text-right">مثلث امنیت</h3>
            <img src="{{asset('assets/imgs/iconfinder_10_171505.png')}}" alt="" class="timeicon">
            <p class="col-sm-1 , text-right , time">02:55</p>
        </div>
    </div>

</header>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="playerbox">
                <audio controls id="player" class="player">
                    <source src="{{$post->getFileUrl()}}" type="audio/mpeg">

                </audio>
            </div>
        </div>
        <div class="col-md-12">
            <div class="definition">
                <p class="">در این پادکست با بررسی مثلث امنیت یا <span dir="rtl">CIA</span> همراه شما هستیم. مثلث <span
                        dir="rtl">CIA</span> مخفف <span dir="rtl">Confidentiality، integraty و Availability </span>
                    میباشد که به آن مثلث امنیت نیز می گویند. <span dir="rtl">CIA</span> یک مدل طراحی شده برای برقراری
                    امنیت اطلاعات سازمان است.عناصر سه گاانه ای که این مثلث را تشکیل می دهند سه جزء مهم امنیتی محسوب
                    میشوند.</p>

            </div>
        </div>
    </div>



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

    <div class="col-md-12 my-5" style="float: none !important;">
        <form action="{{route('comment.insert')}}" method="post"
            style="direction: rtl;text-align: right;{{$commentsCount ? 'display: none;' : ''}}">
            @csrf
            <input type="hidden" name="parent_id" value="0">
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <textarea name="comment" id="" rows="5" class="form-control"></textarea>
            <button class="btn btn-primary mt-3">ارسال</button>
        </form>
    </div>

    @foreach($comments as $parentComment)
    @include('common-components.comment-article',['comment'=>$parentComment])
    @endforeach


    {{$comments->links()}}
</div>
</div>
</div>
<br><br><br>
@endsection


@section('scripts')
<script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
<script>
    const player = new Plyr('#player');
</script>
@endsection