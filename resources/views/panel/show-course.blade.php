@extends('layouts.panel.master')

@section('content')
<div class="main-section">
    <div class="card-dashboard course-card">
        <div class="title-box">
            <span>
                {{$title}}
            </span>
            <form action="#" class="input-place">
                <input type="text" id="search-notification" placeholder="جست جو در {{$title}}" autocomplete="off" required>
                <label for="search-notification">
                    <button type="submit">
                        <img src="{{ asset('panel-assets/Images/Dashboard/notifications/magnifiying-glass.png') }}" alt="">
                    </button>
                </label>
            </form>
        </div>
        <div class="course-place">
           @foreach ($lessons as $item)
           <div class="course-box">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3 no-padding">
                        <div class="img-place">
                            <img src="{{ $item->getPicture() }}" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-6">
                        <div class="text-place">
                            <div class="title">
                                {{$item->title}}
                            </div>
                            <div class="detail">
                              
                                <div class="teacher-name">
                                    <img src="{{ asset('panel-assets/Images/Dashboard/course/time.png') }}" alt="">
                                    مدت زمان: 
                                    <span class="name">{{ $item->duration }} ساعت</span>
                                </div>
                            </div>
                            <p class="text">
                                {!! Str::limit(strip_tags($item->description), 70, '...') !!}
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 col-xl-3">
                        <div class="btn-place">
                            @if (! $item->quiz)
                            <span class="notquiz">آزمون ندارد</span>
                            @else 

                           
                            @if ($user->passed_quizz()->where('quiz_id',$item->quiz->id)->count())
                            <span class="passedquiz">آزمون پاس شده است </span>
                            @else 
                            <a href="{{ route('member.course.quiz.show',['user'=>$user->username,'id'=>$item->id]) }}" class="btn--ripple">
                                آزمون درس
                            </a>
                            @endif
                            @endif

                            <a href="{{ $user->checkAllowForSeeLesson($item->id) ? route('play',$post->slug).'?lesson='.$item->id.'' : '#'}}" class="btn--ripple {{ $user->checkAllowForSeeLesson($item->id) ? '' : ' disabled' }}">
                                مشاهده ویدئو
                            </a>
                           
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
           @endforeach
          
        </div>
    </div>
</div>
@endsection