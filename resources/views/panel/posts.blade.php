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
           @foreach ($posts as $item)
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
                                    <img src="{{ asset('panel-assets/Images/Dashboard/course/user.png') }}" alt="">
                                    مدرس:
                                    <span class="name">{{ $item->getTeacher() }}</span>
                                </div>
                                <div class="teacher-name">
                                    <img src="{{ asset('panel-assets/Images/Dashboard/course/cal.png') }}" alt="">
                                    زمان برگذاری:
                                    <span class="name">{{ jalaliDate($item->start_date) }}</span>
                                </div>
                                <div class="teacher-name">
                                    <img src="{{ asset('panel-assets/Images/Dashboard/course/time.png') }}" alt="">
                                    مدت زمان: 
                                    <span class="name">{{ $item->duration }} </span>
                                </div>
                            </div>
                            <p class="text">
                                {!! Str::limit(strip_tags($item->description), 400, '...') !!}
                            </p>
                        </div>
                    </div>
                    @if ($item->post_type == 'course')
                    <div class="col-12 col-lg-12 col-xl-3">
                        <div class="btn-place">
                            <a href="{{ route('member.course.lessons',['user'=>$user->username,'id'=>$item->id]) }}" class="btn--ripple">
                                ورود به صفحه دوره
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
           @endforeach
          
        </div>
    </div>
</div>
@endsection