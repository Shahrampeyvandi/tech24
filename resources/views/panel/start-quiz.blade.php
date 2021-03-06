@extends('layouts.panel.master')

@section('css')
<link href="{{ URL::asset('/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<style>
   
#preloader {
    position: absolute;
    height: 100%;

    width: 100%;
    background-color: #fff;
    z-index: 9999;
}
.hidden{
    display: none;
}
.show{
    display: block;
}
#status {
  width: 40px;
  height: 40px;
  position: absolute;
  left: 50%;
  top: 50%;
  margin: -20px 0 0 -20px;
}

.spinner-chase {
  margin: 0 auto;
  width: 40px;
  height: 40px;
  position: relative;
  -webkit-animation: spinner-chase 2.5s infinite linear both;
          animation: spinner-chase 2.5s infinite linear both;
}

.chase-dot {
  width: 100%;
  height: 100%;
  position: absolute;
  left: 0;
  top: 0;
  -webkit-animation: chase-dot 2s infinite ease-in-out both;
          animation: chase-dot 2s infinite ease-in-out both;
}

.chase-dot:before {
  content: "";
  display: block;
  width: 25%;
  height: 25%;
  background-color: #3b5de7;
  border-radius: 100%;
  -webkit-animation: chase-dot-before 2s infinite ease-in-out both;
          animation: chase-dot-before 2s infinite ease-in-out both;
}

.chase-dot:nth-child(1) {
  -webkit-animation-delay: -1.1s;
          animation-delay: -1.1s;
}

.chase-dot:nth-child(1):before {
  -webkit-animation-delay: -1.1s;
          animation-delay: -1.1s;
}

.chase-dot:nth-child(2) {
  -webkit-animation-delay: -1s;
          animation-delay: -1s;
}

.chase-dot:nth-child(2):before {
  -webkit-animation-delay: -1s;
          animation-delay: -1s;
}

.chase-dot:nth-child(3) {
  -webkit-animation-delay: -0.9s;
          animation-delay: -0.9s;
}

.chase-dot:nth-child(3):before {
  -webkit-animation-delay: -0.9s;
          animation-delay: -0.9s;
}

.chase-dot:nth-child(4) {
  -webkit-animation-delay: -0.8s;
          animation-delay: -0.8s;
}

.chase-dot:nth-child(4):before {
  -webkit-animation-delay: -0.8s;
          animation-delay: -0.8s;
}

.chase-dot:nth-child(5) {
  -webkit-animation-delay: -0.7s;
          animation-delay: -0.7s;
}

.chase-dot:nth-child(5):before {
  -webkit-animation-delay: -0.7s;
          animation-delay: -0.7s;
}

.chase-dot:nth-child(6) {
  -webkit-animation-delay: -0.6s;
          animation-delay: -0.6s;
}

.chase-dot:nth-child(6):before {
  -webkit-animation-delay: -0.6s;
          animation-delay: -0.6s;
}

@-webkit-keyframes spinner-chase {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes spinner-chase {
  100% {
    transform: rotate(360deg);
  }
}

@-webkit-keyframes chase-dot {
  80%, 100% {
    transform: rotate(360deg);
  }
}

@keyframes chase-dot {
  80%, 100% {
    transform: rotate(360deg);
  }
}

@-webkit-keyframes chase-dot-before {
  50% {
    transform: scale(0.4);
  }

  100%, 0% {
    transform: scale(1);
  }
}

@keyframes chase-dot-before {
  50% {
    transform: scale(0.4);
  }

  100%, 0% {
    transform: scale(1);
  }
}


</style>
@endsection

@section('content')

<div class="main-section">
    <div class="card-dashboard course-card">
        <div class="title-box d-flex justify-content-between">
            <span>
                {{$title}}
            </span>
           <span class="badge badge-info">
               زمان باقیمانده: 
            <time id="countdown"><span id="cd-minutes">00</span>:<span id="cd-seconds">00</span></time>
        </span>
      


        </div>
        <div class="course-place">

            <div class="row">
                <div class="col-md-12">
                   <div class="question-item position-relative">
                    <div id="preloader" class="preloader hidden" >
                        <div id="status" >
                            <div class="spinner-chase">
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                            </div>
                        </div>
                    </div>
                        <h3 class="question-title"> {{$question->title}} </h3>
                        <div class="p-2 bg-light raduis-2 answers">
                            
                            <h4>پاسخ ها</h4>
                            <div class="row">
                                <div  class="col-md-4">گزینه </div>
                                <div class="col-md-12">
                                    <h4>{{ $question->option_one }}</h4>
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="question" id="exampleRadios2"
                                        value="option_one">
                                    <label class="form-check-label mr-3" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div  class="col-md-4">گزینه </div>
                                <div class="col-md-12">
                                    <h4>{{ $question->option_two }}</h4>
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="question" id="exampleRadios2"
                                        value="option_two"> <label class="form-check-label mr-3" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div  class="col-md-4">گزینه </div>
                                <div class="col-md-12">
                                    <h4>{{ $question->option_three }}</h4>
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="question" id="exampleRadios2"
                                        value="option_three"> <label class="form-check-label mr-3" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div  class="col-md-4">گزینه </div>
                                <div class="col-md-12">
                                    <h4>{{ $question->option_four }}</h4>
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="question" id="exampleRadios2"
                                        value="option_four"> <label class="form-check-label mr-3" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                        
                        </div>   
                        <input type="hidden" name="time" value="{{date('Y/m/d H:i:s',strtotime($quiz->countdown))}}">
                        <input type="hidden" name="id" value="{{$question->id}}">
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <a href="#" class="btn btn-primary next-question" data-time="">
                                    بعدی
                                </a>
                            </div>
                          
                        </div>
                   </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Sweet Alerts js -->
<script src="{{ URL::asset('/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
  
  $('.next-question').click(function (e) {
        e.preventDefault()
        let answer = $('input[name="question"]:checked').val()
        let question = $('input[name="id"]').val()
        // console.log(question)
        if (answer != undefined) {
            $('.preloader').removeClass('hidden').addClass('show')
            var request = $.post(mainUrl + '/panel/quiz/answer/submit', { question: question, answer: answer, _token: token });
            request.done(function (res) {

                $('.preloader').removeClass('show').addClass('hidden')

                if(res.ended) {
                    Swal.fire({
                        title: '',
                        text: res.message,
                        type: res.success,
                        confirmButtonColor: '#3b5de7',
                        confirmButtonText: "تایید"
                    });
                   setTimeout(function() {
                        window.location.href = res.url;
                   },500)
                    return;
                }

                if (res.timeover == true) {
                    Swal.fire({
                        title: '',
                        text: res.message,
                        type: res.success,
                        confirmButtonColor: '#3b5de7',
                        confirmButtonText: "تایید"
                    });
                   setTimeout(function() {
                        window.location.href = res.url;
                   },500)
                    return;
                }

                $('.question-item').find('.question-title').text(res.question.title)
                var answers = '';
                arr = [res.question.option_one,res.question.option_two,res.question.option_three,res.question.option_four]
                val = ['option_one','option_two','option_three','option_four']
                for (let index = 0; index < arr.length; index++) {
                    answers += `<div class="row">
                    <div  class="col-md-4">گزینه </div>
                    <div class="col-md-12">
                        <h4>${arr[index]}</h4>
                    </div>
                    <div class="form-check col-md-2">
                        <input class="form-check-input" type="radio" required name="question" id="exampleRadios2"
                            value="${val[index]}">
                        <label class="form-check-label mr-3" for="exampleRadios2">
                            پاسخ درست
                        </label>
                    </div>
                </div>`;

                    
                }
                $('.question-item').find('.answers').html(answers)

                // console.log(res.question.id)
                $('input[name="id"]').val(res.question.id)

            })
        }
    })

    let timer = function (date) {

        let mm = date.getMinutes();
        let ss = date.getSeconds();

        var interval = setInterval(function () {
            if (mm == 0 && ss == 0) {

                clearInterval(interval);
                Swal.fire({
                    title: '',
                    text: 'زمان شما به پایان رسیده است',
                    type: 'error',
                    confirmButtonColor: '#3b5de7',
                    confirmButtonText: "پایان"
                })

            }
            if (ss == 0) {
                ss = 59;
                mm--;
                if (mm == 0) {
                    mm = 59;
                    hr--;
                }
            }
            ss--;
            if (mm.toString().length < 2) mm = "0" + mm;
            if (ss.toString().length < 2) ss = "0" + ss;
            document.getElementById('cd-minutes').innerHTML = mm;
            document.getElementById('cd-seconds').innerHTML = ss;

        }, 1000)
    }


    timer(new Date($('input[name="time"]').val()));
</script>
@endsection
