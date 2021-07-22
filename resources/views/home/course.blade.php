@extends('layouts.home.master-home')
@section('title')
{{$title}}
@endsection

@section('css')
<link href="https://vjs.zencdn.net/7.7.6/video-js.css" rel="stylesheet" />
<style>
    .expand-btn{
        bottom: 0;
        display: flex;
        justify-content: center;
        position: absolute;
    width: 100%;
    background: linear-gradient(
0deg
,#f7f7f7,#f3f3f3 50%,hsl(0deg 0% 100% / 15%));
    }
    .expanded {
        max-height: none !important;
    }
</style>
@endsection
@section('scripts')
<script src="https://vjs.zencdn.net/7.7.6/video.js"></script>
<script>

function expandDescription(e) {
    e.preventDefault()
    $(e.target).parents('.expand-btn').remove()
    $('.description-wrapper').addClass('expanded')
}
</script>

@endsection
@section('content')
<div class="container">
    <div class="row">
        @isset ($lesson)
            <div class="col-md-10 mx-auto">
                <section id="play" class=" position-relative w-100 mt-5">
                        <video class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" 
                        data-setup='{}' controls preload="auto"
                            id="player" controls>
                            <source src="{{ $lesson->getFileUrl() }}" type='video/mp4' label='' />
                        </video>
                </section>
        </div>
            
        @endif
<div class="col-md-12 text-right">
    <div>
        <h3 class="p-3">آموزش Html</h3>
    </div>
    <div class="row justify-content-around">
        


        <div class="col-md-8 col-lg-9">
            <div class="bg-white border-radius box-shadow">
                <div class="d-flex mx-3 mx-sm-4 flex-col-mobile">
                    <a href="" class="py-2 py-sm-4 px-2 text-dark text-bold text-decoration-none yellow-border border-warning">توضیحات</a>
                    <div class=" my-2 my-sm-4 px-2">
                    <a href="#course-lessons" class="py-2 py-sm-4  mx-4 mx-md-0 text-dark text-bold text-decoration-none">جلسات دوره</a>
                    <div class="d-inline mx-1 px-1 bg-warning border rounded border-warning">{{count($post->lessons)}}</div>
                </div>
                    <div class=" my-2 my-sm-4 px-2">
                        <a href="#comments" class="text-dark text-bold text-decoration-none">دیدگاه و پرسش</a>
                        <div class="d-inline mx-1 px-1 bg-warning border rounded border-warning">{{count($comments)}}</div>
                    </div>
                </div>

                <div class="light-line"></div>

                <div class="description-wrapper">
                   <div>
                       @isset($lesson)
                       {!! $lesson->description !!}
                        @else 
                        {!! $post->description !!}  
                       @endisset
                   </div>
                   @php
                   $current = isset($lesson) ? $lesson : $post;
                      $descriptionLen =  strlen(strip_tags($current->description));
                   @endphp
                   @if ($descriptionLen > 600)
                   <div class="expand-btn">
                   
                    <button 
                    onclick="expandDescription(event)"
                    class="mt-4 text-light d-flex justify-content-center align-self-center border-radius hover-light continuation-btn">
                        <img src="/shapes/down-arrow-light.png" alt="" class="my-3 mx-2 icons-width">
                        <p class="my-3 mx-2">مشاهده ادامه مطلب</p>
                    </button>
                </div>
                   @endif
                   
                </div>
               
               

               @if (!request('lesson'))
               <div id="accordion" class="mx-4 mt-5">
                @if (count($post->faq_s))
                <h4 class="my-4">سوالات متداول</h4>
                    @foreach ($post->faq_s as $key=>$item)
                   
                    <div class="mb-2">
                        <div class="mx-0 d-flex flex-column border-radius">
                            <button class="p-3 d-flex justify-content-between align-items-center bg-lightgray border-radius {{$key == 0 ? '' : 'collapsed'}}"
                            data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="{{$key == 0 ? 'true' : 'false'}}" aria-controls="collapseOne"
                            >
                                <p class="m-0">{{$item->question}}</p>
                                <img src="/shapes/down-arrow-black.png" alt="" class="sm-icons">
                            </button>
                            <p class="p-3 collapse {{$key == 0 ? 'show' : ''}}" id="collapse{{$key}}">
                             {{$item->answer}}
                         </p>
                        </div>
                    </div>
                   
                    @endforeach
                @endif
                 
                 <div class="light-line"></div>
                 <div class="footer-icons flex-col-mobile">
                     <div class="d-flex align-items-baseline">
                         <button class="bg-white border-none">
                             <i class="icon-heart"></i>
                         </button>
                         <p class="text-small margin-left">597</p>
                         <button class="bg-white border-none">
                            <i class="icon-comments"></i>
                         </button>
                         <p class="text-small margin-left">۲۲۲</p>
                        
                     </div>
                     <div>
                         <button class="bg-white border-none">
                             <i class="icon-telegram"></i>
                         </button>
                         <button class="bg-white border-none">
                             <i class="icon-instagram"></i>
                         </button>
                     </div>
                 </div>
             </div>
               @endif
            </div>

            
           

            <h4 id="course-lessons" class="my-4">جلسات دوره</h4>
            <div class="bg-white border-radius box-shadow">
                @foreach ($post->lessons as $lesson)
                <section class="px-3 px-sm-5 py-4 d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        @if ($lesson->getLink()['status'] == 'danger')
                        <div class="bg-danger danger-border px-2" style="line-height: 2.1;
                        width: 40px;
                        height: 40px;
                        text-align: center;">
                        <i class="icon-lock"></i>
                        </div>
                         @else 
                         <div class="bg-{{$lesson->getLink()['status']}} gray-border px-2">{{ $lesson->number }}</div>
                        @endif
                        
                        <a href="{{ $lesson->getLink()['url']}}" class="mx-2 my-0">{{ $lesson->title }}</a>
                    </div>
                    <div class="d-flex items-center space-x-reverse space-x-1">
                        <span class=" text-sm p-1 px-2 rounded font-medium bg-gray-300 text-gray-600 border-green-700">{{$lesson->getLink()['label']}}</span>
                        <span class=" text-sm p-1 px-2 rounded font-medium bg-gray-500 border-gray-400 ">{{$lesson->duration}}</span>
                        </div>
                </section>
                <div class="light-line"></div>
                @endforeach
               
            </div>


            <div id="comments" class="d-flex justify-content-between my-4  flex-col">
                <h4>دیدگاه ها و پرسش ها</h4>
                <div>
                    <button class="py-2 px-3 border-radius text-light hover-black" onclick="addComment(event)">ارسال دیدگاه</button>
                </div>
            </div>
            <div class="col-md-12 mb-2" style="float: none !important;">
                <form action="{{route('comment.insert')}}" method="post"
                    style="direction: rtl;text-align: right;{{count($comments) ? 'display: none;' : ''}}">
                    @csrf
                    <input type="hidden" name="parent_id" value="0">
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    @isset($lesson)
                    <input type="hidden" name="lesson_id" value="{{$lesson->id}}">
                    @endisset
                    <textarea name="comment" id="" rows="5" class="form-control"></textarea>
                    <button class="btn btn-primary mt-3">ارسال</button>
                </form>
            </div>

           @forelse ($comments as $comment)
           <div class="bg-white border-radius box-shadow p-4 r-position my-1">
            <div class="d-flex align-items-baseline">
                
                
                <button class="liked" > </button>
                <button class="reply" onclick="addComment(event)" data-id="{{$comment->id}}"></button>
            </div>
            <div class="d-flex">
                <img src="/shapes/icons8-male-user-100.png" alt="" class="gray-border profile-pic">
                <div>
                    <p class="text-primary text-bold mb-1 mt-3">{{$comment->getAutor()}}</p>
                    <p class="text-secondary font_size_0_6">{{$comment->getDate()}}</p>
                </div>
            </div>
            <p class="mt-4">
                {!! $comment->comment !!}
            </p>
          
        </div>
        @empty
        <div class="alert alert-info">
            شما اولین نفری باشید که دیدگاه ارسال میکنید
        </div>
           @endforelse
           
            
           {{$comments->appends(request()->query())->links('vendor.pagination.default')}}
         
        </div>
        
        
        <div class="col-md-4 col-lg-3">
            <div class="mb-2 border-radius box-shadow bg-pattern ">
                <div class="border-radius box-shadow  dark-overlay">
                    <div class="d-flex justify-content-between mx-3 my-4 text-white">
                        <p class="mb-0">قیمت دوره</p>
                        <p class="mb-0">{{$post->getPrice()}}</p>
                    </div>
                    <div class="d-flex justify-content-between mx-3 my-4 text-white">
                        <p class="mb-0">وضعیت دوره</p>
                        <div class="bg-warning text-dark px-1 border rounded border-warning">در حال تکمیل</div>
                    </div>
                    <div class="d-flex justify-content-between mx-3 my-4 text-white">
                        <p class="mb-0">زمان کل دوره</p>
                        <p class="mb-0">۰۳:۱۳:۲۲</p>
                    </div>
                    <div class="d-flex justify-content-between mx-3 my-4 text-white">
                        <p class="mb-0">تعداد قسمت ها</p>
                        <p class="mb-0">{{ count($post->lessons) }}</p>
                    </div>
                  
                   
                    <div class=""></div>
                    @if ($post->cash == 'money')
                        @auth
                        @if(Auth::user()->posts->contains($post->id))
                        <div class="my-2 mx-3 py-3 border-radius text-center text-small text-bold bg-white hover-dark">شما این دوره را خریداری کرده اید</div>
                        @else 
                        <a href="{{ route('pay') }}?id={{$post->id}}" 
                            class="d-block text-white my-2 mx-3 py-3 border-radius text-center text-small text-bold bg-success hover-dark">
                           پرداخت آنلاین
                       </a>   
                        @endif
                        @else 
                        <a href="{{ route('pay') }}?id={{$post->id}}" 
                            class="d-block text-white my-2 mx-3 py-3 border-radius text-center text-small text-bold bg-success hover-dark">
                           پرداخت آنلاین
                       </a>
                        @endauth
                       
                        <div class="my-2 mx-3 p-2 bg-warning border-radius border-warning text-small text-bold">این دوره یک دوره غیر رایگان است و بایستی خریداری شود</div>
                    @else    
                    <div class="my-2 mx-3 py-3 border-radius text-center text-small text-bold bg-white hover-dark">این دوره رایگان است</div>
                    <div class="my-2 mx-3 p-2 bg-warning border-radius border-warning text-small text-bold">تا زمانی که این دوره رایگان باشد، شما بصورت کامل به این دوره دسترسی دارید.</div>
                    @endif
                    
                    
                    
                </div>
            </div>
            

            <div class="mb-2 border-radius box-shadow">
                <div class="m-0 profilebox bg-pattern">
                    <div class="m-0 px-2 py-4 row profilebox light-overlay">
                        <img src="https://static.roocket.ir/images/avatar/2021/4/17/iq5eICsbaGqWVbTH9xKlkkdWFdKVPh5dCEqZQw8r.png" alt="" class="col-2 col-md-4 px-0 mx-2 border rounded-circle">
                        <div class="col-9 col-md-7 align-self-center">
                            <h6>مدرس دوره</h6>
                            <p>{{$post->getTeacher()['name']}}</p>
                        </div>
                    </div>
                </div>
                <div class="m-3 text-small text-gray">
                    {!!$post->getTeacher()['bio']!!}
                </div>
                <button class="p-3 w-100 text-light d-flex justify-content-between align-items-center hover-light" id="view-pro-btn">
                    <p class="m-0">مشاهده پروفایل {{$post->getTeacher()['name']}}</p>
                    <img src="/shapes/left-arrow-white.png" alt="" class="icons-width">
                </button>
            </div>


            


            <div class="bg-white py-4 px-3 border-radius box-shadow ">
                <h6 class="mb-3">دوره های پیشنهادی</h6>
                @forelse ($related_posts as $item)
                <div class="row mx-0 py-3 border-top">
                    
                    <div class="px-0 col-2 col-sm-1 col-md-3 align-self-center gray-border pic-items">
                      <img src="{{ asset('shapes/bootstrap-1.png') }}" class="w-100" alt="">
                    </div>
                      <div class="col-10 col-sm-11 col-md-9">
                          <a href="" class="text-small text-dark text-bold under-hover">آموزش طراحی وبسایت</a>
                          <p class="text-smaller">در طول دوره آموزش طراحی وب سایت به شما در قالب یک پروژه کامل آموزش می‌دهیم که چطور ظاهر یک وبسایت را از صفر تا ۱۰۰ به شکل کامل پیاده‌‌سازی کنیم.</p>
                      </div>
                  </div>
                @empty
                <div class="row mx-0 py-3 border-top">
                    
                  دوره پیشنهادی برای شما وجود ندارد
                  </div>
                    
                @endforelse
                
            </div>
        
        </div>
    </div>
</div>
    </div>
</div>
@endsection
