
    function confirmMobile(event){
    event.preventDefault()
    let mobile = $('input[name="mobile"]').val()

        pattern = /^[0][1-9]\d{9}$|^[1-9]\d{9}$/;
    if(! pattern.test(mobile)) {
        $(event.target).prev().find('.form-control').next().remove()
        $(event.target).prev().find('.form-control').after(`
                            <label for="usermobile" generated="true" class="error">موبایل دارای فرمت نامعتبر می باشد</label>
                   `)

        return;
    }
    // console.log(question)
    if (mobile) {
    var request = $.post(mainUrl + '/check-mobile', {  mobile: mobile, _token: token });
    request.fail(function (err) {
    $(event.target).prev().find('.form-control').next().remove()
    $.each(err.responseJSON.errors,function (k,v) {
    $(event.target).prev().find('.form-control').addClass('is-invalid')
    $(event.target).prev().find('.form-control').after(`
                        <label for="usermobile" generated="true" class="error">${v}</label>
                   `)
})
});
    request.done(function (res) {
    $(event.target).prev().find('.form-control').next().remove()
    $(event.target).html('ارسال مجدد کد <span id="cd-minutes">02</span>:<span id="cd-seconds">00</span>')
    $(event.target).attr('disabled','true')
    timer(new Date(res.timer));
});
}else{

    alert('شماره موبایل خود را وارد نمایید')
}
}

    let activeBtn = function() {
    $('.sms-btn').html('تایید موبایل')
    $('.sms-btn').attr('disabled','false')
}


    let timer = function (date) {
    let mm = date.getMinutes();
    let ss = date.getSeconds();
    var interval = setInterval(function () {
    if (mm == 0 && ss == 0) {
    clearInterval(timer)
    activeBtn()
}
    if (ss == 0) {
    ss = 59;
    mm--;
}
    ss--;
    if (mm.toString().length < 2) mm = "0" + mm;
    if (ss.toString().length < 2) ss = "0" + ss;
    document.getElementById('cd-minutes').innerHTML = mm;
    document.getElementById('cd-seconds').innerHTML = ss;
}, 1000)
}

    $.validator.addMethod(
    "regex",
    function(value, element, regexp) {
    return this.optional(element) || regexp.test(value);
},
    "Please check your input."
    );
    $(".register--form").validate({
    rules: {
    fname: "required",
    lname: "required",
    mobile: {
    required: true,
    regex: /^[0][1-9]\d{9}$|^[1-9]\d{9}$/
},
    email: {
    required: true,
    email:true
},
    username: {
    required: true,
    minlength: 5,
    regex: /^[a-zA-Z]+[a-zA-Z\d]*$/
},
    password: {
    required: true,
    minlength: 6
},
    password_confirmation: {
    required: true,
    equalTo: "#password"
},
},
    messages: {
    fname: "لطفا نام خود را وارد نمایید",
    lname: "لطفا نام خانوادگی خود را وارد نمایید",
    password: {
    required: "رمز عبور خود را وارد نمایید",

},
    mobile:{
    required:"شماره موبایل خود را وارد نمایید",
    regex:"موبایل دارای فرمت نامعتبر می باشد"
},
    email:{
    required:"ایمیل خود را وارد نمایید",
    email:"ایمیل وارد شده صحیح نمیباشد"
},
    username: {
    required: "لطفا یک نام کاربری وارد نمایید",
    minlength: "نام کابری حداقل 5 کاراکتر دارد",
    regex:"نام کاربری تنها شامل حروف لاتین میباشد و نمی تواند با عدد شروع شود"
},
    password: {
    required: "رمز عبور دا وارد نمایید",
    minlength: "رمز عبور بایستی حداقل 6 کاراکتر باشد"
},
    password_confirmation: {
    required: "رمز عبور را وارد نمایید",
    equalTo: "رمز عبور وارد شده مطابقت ندارد"
}
}
});

    $(".login--form").validate({
        rules: {
            mobile: {
                required: true,
                regex: /^[0][1-9]\d{9}$|^[1-9]\d{9}$/
            },
            password: {
                required: true,

            },
        },
        messages: {
            password: {
                required: "رمز عبور خود را وارد نمایید",

            },
            mobile:{
                required:"شماره موبایل خود را وارد نمایید",
                regex:"موبایل دارای فرمت نامعتبر می باشد"
            }
        }
    });
