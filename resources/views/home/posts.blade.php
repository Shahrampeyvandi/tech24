@extends('layouts.home.master-home')

@section('title') {{ $page_title }} @endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
@endsection

@section('content')
<!--start prodocts section-->
<section class="container product my-5">
    <div class="row text-right">
        @component('common-components.category-list',['latest_posts'=>$latest_posts,'post_type'=>$post_type,'title'=>$title])
        @endcomponent
        <div class="col-lg-9">
            <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
                <h1 class="section_heading font_size_2">{{$title}} های <span>تک وان 24</span></h1>
                    <div class="archive_options">
                        {{-- <a class="cats_group_link" href="archive.html"><i class="icon-view_comfy"></i></a>
                        <a class="cats_group_link active" href="products.html"><i class="icon-view_list"></i></a> --}}
                        <menu class="dropdown mr-2">
                            <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown"> جدیدترین {{$title}} ها </button>
                            <ul class="dropdown-menu">
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" ><a href="{{ url($post_type . 's') }}">جدیدترین {{$title}} ها</a></li>
                                <div class="dropdown-divider"></div>
                                <li class="dropdown-item" ><a href="{{ url($post_type . 's') }}?order=views">پربازدید {{$title}} ها</a></li>
                            </ul>
                        </menu>
                    </div>
            </div>
            <!--PRODUCT BOX-->
            <div class="row mr-1">

                @if (count($posts))
                @foreach ($posts as $post)
                <!--PRODUCT BOX-->

                <div class="product_box product text-right row">
                    <div class="col-xl-4 col-lg-12 col-sm-12 col-xs-12 product_img">
                        <img src="{{ $post->getPicture() }}" alt="{{ $post->title }}">
                    </div>
                    
                    <div class="col-lg-8 col-md-8 col-sm-12 mt-3 text-right product-content">
                        <h2 class="product_heading">{{$post->title}}</h2>
                        <div class="product_sub_heading">
                          <small><i class="icon-user"></i> مدرس : {{ $post->getTeacher() }}</small> |
                          <small><i class="icon-calander"></i> زمان برگزاری : {{ jalaliDate($post->start_date) }}</small> |
                          <small><i class="icon-clock"></i>طول دوره : {{ $post->duration }}</small>
                        </div>
                        <p class="product_text">
                      
                          {!! Str::limit($post->short_description, 300, '...') !!}
                        </p>
                        <br>
                        <div class="product_details float-left ml-2">
                          <div class="cost d-flex align-items-center">
                            <div class="cost_icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="31" viewBox="0 0 495.983 512">
                                <g id="wallet_black" transform="translate(-8.008 0)">
                                  <g id="Group_2" data-name="Group 2">
                                    <g id="Group_1" data-name="Group 1">
                                      <path id="Path_1" data-name="Path 1"
                                        d="M487.59,299.894h-7.662V230.879A32.4,32.4,0,0,0,466.185,204.4V195a24.748,24.748,0,0,0-24.72-24.72h-5.721l21.889-32.12a23.657,23.657,0,0,0-6.219-32.833L302.883,4.111a23.629,23.629,0,0,0-32.833,6.22l-128.2,188.123H106.174l8.607-87.13a2.584,2.584,0,0,1,1.625-2.168,55.464,55.464,0,0,0,27.059-21.985,2.567,2.567,0,0,1,2.424-1.138l55.955,5.528a7.3,7.3,0,1,0,1.434-14.52l-55.955-5.528a17.075,17.075,0,0,0-16.169,7.825,40.776,40.776,0,0,1-19.9,16.164,17.053,17.053,0,0,0-11,14.387l-8.748,88.564h-9.3l13.612-137.8a9.04,9.04,0,0,1,9.883-8.107l113.074,11.17a7.3,7.3,0,1,0,1.434-14.52L107.138,38.022A23.659,23.659,0,0,0,81.3,59.214L70.328,170.284H51.643A24.748,24.748,0,0,0,26.923,195v6.41A32.462,32.462,0,0,0,8.008,230.879v248.7A32.463,32.463,0,0,0,40.435,512H447.5a32.462,32.462,0,0,0,32.426-32.426V410.56h7.662a16.419,16.419,0,0,0,16.4-16.4V316.3A16.418,16.418,0,0,0,487.59,299.894ZM441.465,184.876h0a10.139,10.139,0,0,1,10.129,10.129v3.717a32.513,32.513,0,0,0-4.092-.267H416.547l9.253-13.579ZM282.107,18.547a8.984,8.984,0,0,1,5.787-3.791,9.171,9.171,0,0,1,1.7-.161,8.979,8.979,0,0,1,5.071,1.572L443.2,117.387a9.05,9.05,0,0,1,2.38,12.559l-46.686,68.506h-11.2l22.889-33.587a17.055,17.055,0,0,0,.8-18.092,40.773,40.773,0,0,1-4.888-25.166,17.062,17.062,0,0,0-7.38-16.375l-77-52.472a17.062,17.062,0,0,0-17.941-.879,40.783,40.783,0,0,1-25.208,4.655,17.271,17.271,0,0,0-16.548,7.357l-91.7,134.56h-11.2Zm3.213,123.891a60.2,60.2,0,0,0-59.976,56.015H188.365l86.1-126.343h0a2.6,2.6,0,0,1,2.133-1.147,2.485,2.485,0,0,1,.333.023,55.469,55.469,0,0,0,34.285-6.331,2.574,2.574,0,0,1,2.672.163l77,52.473a2.58,2.58,0,0,1,1.129,2.426,55.451,55.451,0,0,0,6.648,34.225,2.59,2.59,0,0,1-.144,2.706l-28.488,41.8H345.3A60.2,60.2,0,0,0,285.32,142.438Zm45.348,56.016h-90.7a45.533,45.533,0,0,1,90.7,0ZM41.514,195a10.14,10.14,0,0,1,10.129-10.13H68.887l-1.341,13.579H41.514ZM22.6,230.879a17.856,17.856,0,0,1,17.836-17.835H447.5a17.855,17.855,0,0,1,17.835,17.835v20.244H22.6Zm442.738,248.7A17.855,17.855,0,0,1,447.5,497.409H40.435A17.856,17.856,0,0,1,22.6,479.574V459.33H61.941a7.3,7.3,0,0,0,0-14.59H22.6V265.714H465.337v34.18H395.97A55.4,55.4,0,0,0,346.2,331.075c-.03.062-.064.122-.1.184-.076.157-.142.32-.216.478a55.014,55.014,0,0,0-2.757,7.054l-.006.02a55.348,55.348,0,0,0,52.846,71.749h69.367v34.18H108.655a7.3,7.3,0,0,0,0,14.59H465.337ZM489.4,394.159a1.812,1.812,0,0,1-1.811,1.81H395.972a40.778,40.778,0,0,1-35.818-21.338q-.471-.865-.9-1.756-.859-1.781-1.547-3.654a40.784,40.784,0,0,1,0-27.988q.687-1.871,1.547-3.654.43-.889.9-1.756a40.778,40.778,0,0,1,35.818-21.338H487.59a1.813,1.813,0,0,1,1.811,1.81v77.864Z" />
                                    </g>
                                  </g>
                                  <g id="Group_4" data-name="Group 4">
                                    <g id="Group_3" data-name="Group 3">
                                      <path id="Path_2" data-name="Path 2"
                                        d="M397.681,325.627a29.6,29.6,0,1,0,29.6,29.6A29.634,29.634,0,0,0,397.681,325.627Zm0,44.608a15.008,15.008,0,1,1,15.009-15.008A15.026,15.026,0,0,1,397.681,370.235Z" />
                                    </g>
                                  </g>
                                </g>
                              </svg>
                      
                            </div>
                            <div class="cost_detail mr-3">
                              <h6>قیمت :</h6>
                              <b class="blue-text font_size_0_8">{{ $post->getPrice() }}</b>
                            </div>
                      
                           
                                <a href="{{ route('post.show',$post->slug) }}" class="py-2 px-5 btn_orange mr-4 mt-2">
                                  مشاهده
                                </a>
                             
                          </div>
                        </div>
                      </div>
                </div>
                @endforeach
                @else
                <div class="alert alert-primary w-100" role="alert">
                    هیچ {{$title}} برای نمایش وجود ندارد
                </div>
                @endif


            </div>
            {{ $posts->links() }}

        </div>
</section>
<!--end products section-->
@endsection