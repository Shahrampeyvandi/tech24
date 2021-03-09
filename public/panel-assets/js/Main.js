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
            $btnRippleInk.css({height: btnRippleH, width: btnRippleH});
        }
        btnRippleX = e.pageX - $t.offset().left - $btnRippleInk.width() / 2;
        btnRippleY = e.pageY - $t.offset().top - $btnRippleInk.height() / 2;
        $btnRippleInk.css({top: btnRippleY + 'px', left: btnRippleX + 'px'}).addClass("btn--ripple-animate");
    });
    //menu
    $('.menu-button .button').on('click',function () {
        if ($(this).hasClass('cross')){
            $(this).removeClass('cross')
            $('header .right-nav .menu-button').css('width','5.56rem')
            // $('header .right-nav .right-menu .right-Items a').css('padding','0.5rem 0')
            // $('header .right-nav .right-menu .right-Items a img').css('margin-left','1rem')
            $('header .right-nav .right-menu .right-Items a').css('padding-left','0rem')
        }else {
            $(this).addClass('cross')
            $('header .right-nav .menu-button').css('width','13.35rem')
            // $('header .right-nav .right-menu .right-Items a').css('padding','0.5rem 0 0.5rem 3rem')
            // $('header .right-nav .right-menu .right-Items a img').css('margin-left','2rem')
            $('header .right-nav .right-menu .right-Items a').css('padding-left','7.8rem')
        }
        // $('header .right-nav .right-menu .right-Items a span').animate({width:'toggle'},100);
    })
    //select
    $('.select').on('click',function (prevent) {
        prevent.preventDefault()
        let status_show = $('.select_items')
        if (status_show.css('display') === 'none'){
            status_show.slideDown(300)
        }else {
            status_show.slideUp(300)
        }
    }).blur(function () {
        let status_show = $('.select_items')
        status_show.slideUp(300)
    })
    $('.select-option').on('click',function () {
        let get_txt = $(this).text()
        let get_Val = $(this).attr('id')
        console.log(get_txt)
        console.log(get_Val)
        $('.select .text').text(get_txt).css('color','#000')
        $('#Evidence_type').val(get_Val)
    })
    $('.select-group').on('click',function (event) {
        event.preventDefault()
        let status_show = $('.select-menu')
        if (status_show.css('display') === 'none'){
            status_show.slideDown(300)
        }else {
            status_show.slideUp(300)
        }
    }).blur(function () {
        let status_show = $('.select-menu')
        status_show.slideUp(300)
    })
    $('.select-group .select-item').on('click',function () {
        let txt = $(this).text()
        console.log(txt)
        $('.select-group input').val(txt)
        $('.select-group .text').text(txt)
    })
    // chat
    $('.main-chat .profile-place .profile-box').on('click',function () {
        $('.main-chat .profile-place').css('display','none')
        $('.main-chat .chat-place').css('display','block')
    })
    $('.main-chat .chat-place .title .return').on('click',function () {
        $('.main-chat .profile-place').css('display','block')
        $('.main-chat .chat-place').css('display','none')
    })
})