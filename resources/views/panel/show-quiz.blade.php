@extends('layouts.panel.master')

@section('content')

<div class="main-section">
    <div class="card-dashboard course-card">
        <div class="title-box">
            <span>
                {{$title}}
            </span>
            <form action="#" class="input-place">
                <input type="text" id="search-notification" placeholder="جست جو در {{$title}}" autocomplete="off"
                    required>
                <label for="search-notification">
                    <button type="submit">
                        <img src="{{ asset('panel-assets/Images/Dashboard/notifications/magnifiying-glass.png') }}"
                            alt="">
                    </button>
                </label>
            </form>
        </div>
        <div class="course-place">

            <div class="row">
                <div class="col-md-12">
                    <h2>{{$quiz->title}}</h2>
                    <br>
                    <ul class="pr-2">
                        <li>مدت زمان آزمون : {{ $quiz->countdown }}</li>
                        <li>تعداد سوال : {{ $quiz->questionscount }}</li>
                        <li>توضیحات : {{ $quiz->description }}</li>

                    </ul>


                    <div class="btn-place">
                        <a href="{{ route('member.course.quiz.start',['user'=>$user->username,'id'=>$lesson->id]) }}" class="btn btn-primary">
                            شروع آزمون 
                        </a>
                      
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection