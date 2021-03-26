$(document).ready(function () {
    //Ripple
    let $btnRipple = $('.btn--ripple'),
        $btnRippleInk, btnRippleH, btnRippleX, btnRippleY;
    $btnRipple.on('mouseenter', function (e) {
        let $t = $(this);
        if ($t.find(".btn--ripple-ink").length === 0) {
            $t.prepend("<span class='btn--ripple-ink'></span>");
        }

        $btnRippleInk = $t.find(".btn--ripple-ink");
        $btnRippleInk.removeClass("btn--ripple-animate");
        if (!$btnRippleInk.height() && !$btnRippleInk.width()) {
            btnRippleH = Math.max($t.outerWidth(), $t.outerHeight());
            $btnRippleInk.css({ height: btnRippleH, width: btnRippleH });
        }
        btnRippleX = e.pageX - $t.offset().left - $btnRippleInk.width() / 2;
        btnRippleY = e.pageY - $t.offset().top - $btnRippleInk.height() / 2;
        $btnRippleInk.css({ top: btnRippleY + 'px', left: btnRippleX + 'px' }).addClass("btn--ripple-animate");
    });
    //menu
    $('.menu-button .button').on('click', function () {
        if ($(this).hasClass('cross')) {
            $(this).removeClass('cross')
            $('header .right-nav .menu-button').css('width', '5.56rem')
            // $('header .right-nav .right-menu .right-Items a').css('padding','0.5rem 0')
            // $('header .right-nav .right-menu .right-Items a img').css('margin-left','1rem')
            $('header .right-nav .right-menu .right-Items a').css('padding-left', '0rem')
        } else {
            $(this).addClass('cross')
            $('header .right-nav .menu-button').css('width', '13.35rem')
            // $('header .right-nav .right-menu .right-Items a').css('padding','0.5rem 0 0.5rem 3rem')
            // $('header .right-nav .right-menu .right-Items a img').css('margin-left','2rem')
            $('header .right-nav .right-menu .right-Items a').css('padding-left', '7.8rem')
        }
        // $('header .right-nav .right-menu .right-Items a span').animate({width:'toggle'},100);
    })
    //select
    $('.select').on('click', function (prevent) {
        prevent.preventDefault()
        let status_show = $('.select_items')
        if (status_show.css('display') === 'none') {
            status_show.slideDown(300)
        } else {
            status_show.slideUp(300)
        }
    }).blur(function () {
        let status_show = $('.select_items')
        status_show.slideUp(300)
    })
    $('.select-option').on('click', function () {
        let get_txt = $(this).text()
        let get_Val = $(this).attr('id')
        console.log(get_txt)
        console.log(get_Val)
        $('.select .text').text(get_txt).css('color', '#000')
        $('#Evidence_type').val(get_Val)
    })
    $('.select-group').on('click', function (event) {
        event.preventDefault()
        let status_show = $('.select-menu')
        if (status_show.css('display') === 'none') {
            status_show.slideDown(300)
        } else {
            status_show.slideUp(300)
        }
    }).blur(function () {
        let status_show = $('.select-menu')
        status_show.slideUp(300)
    })
    $('.select-group .select-item').on('click', function () {
        let txt = $(this).text()
        console.log(txt)
        $('.select-group input').val(txt)
        $('.select-group .text').text(txt)
    })
    // chat
    $('.main-chat .profile-place .profile-box').on('click', function () {
        $('.main-chat .profile-place').css('display', 'none')
        $('.main-chat .chat-place').css('display', 'block')
    })
    $('.main-chat .chat-place .title .return').on('click', function () {
        $('.main-chat .profile-place').css('display', 'block')
        $('.main-chat .chat-place').css('display', 'none')
    })






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


   
})