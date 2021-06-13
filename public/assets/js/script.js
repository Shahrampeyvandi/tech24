
const nav = document.querySelector(".navbar_wraper");
window.addEventListener("scroll", () => {
    addSticky(window.innerHeight / 3);
    backTop(window.innerHeight / 3);
});
const addSticky = (currentOffset) => {
    if (window.scrollY > currentOffset) {
        nav.classList.add("sticky");
    } else {
        nav.classList.remove("sticky");
    }
}
const backTopBtn = document.getElementById("back_to_top");
const backTop = (currentOffset) => {
    if (document.body.scrollTop > currentOffset || document.documentElement.scrollTop > currentOffset) {
        backTopBtn.style.display = "block";
    } else {
        backTopBtn.style.display = "none";
    }
}
backTopBtn.addEventListener("click", () => {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
})

const searchboxToggleBtn = document.getElementById("searchbox_toggle_btn");
const addBtnSearch = (currentWide) => {
    if (window.innerWidth < currentWide) {
        searchboxToggleBtn.style.display = "block"
    } else {
        searchboxToggleBtn.style.display = "none";
    }
}
window.addEventListener("DOMContentLoaded", () => {
    preLoader();
    addBtnSearch(1200);
});
window.addEventListener("resize", () => {
    addBtnSearch(1200);
})
let tabs = document.querySelectorAll(".tab");
const showAll = () => {
    tabs.forEach(tab => {
        tab.classList.add("show_tab");
    })
}
const showCategory = (category) => {
    tabs.forEach(tab => {
        if (tab.classList.contains(category)) {
            tab.classList.add("show_tab");
        } else {
            tab.classList.remove("show_tab");
        }
    })
}
showAll();
const preLoader = () => {
    const prevLoader = document.querySelector(".prevloader");
    // prevLoader.className = "prevloader";
    // prevLoader.innerHTML = `<div class="preloader">`;
    // document.body.appendChild(prevLoader);
    // document.documentElement.appendChild(prevLoader);
    setTimeout(() => {
        prevLoader.style.display = "none";
    }, 1500)
}
let categoryItems = document.querySelectorAll(".category_box_content");

const showCategoryContent = (item) => {
    categoryItems.forEach(categoryItem => {
        if (categoryItem.classList.contains(item)) {
            categoryItem.classList.toggle("active");
        } else {
            categoryItem.classList.remove("active");
        }
    })
}
const CategoryBoxBtns = document.querySelectorAll(".category_box_btn");
CategoryBoxBtns.forEach(CategoryBoxBtn => {
    CategoryBoxBtn.addEventListener("click", () => {
        CategoryBoxBtn.classList.toggle("active");
    })
})

let addComment = event => {
    // console.log($("form textarea").offset().top)
    let commentId = $(event.target).data('id')
    if (commentId) {
        $('form').find('input[name="parent_id"]').val(commentId)
    }
    $('form').slideDown()
    $('form textarea').focus()
    $([document.documentElement, document.body]).animate({
        scrollTop: $("form textarea").offset().top - 100
    }, 500);
}




var typingTimer;
var doneTypingInterval = 1500;

$('.search_box_field').on('keyup', function (e) {
    event.preventDefault()
    clearTimeout(typingTimer);
    typingTimer = setTimeout(typing, doneTypingInterval);
})

$('.search_box_field').on('keydown', function () {
    clearTimeout(typingTimer);
});

function typing(e) {
    let key = $('.search_box_field').val();
    let url = mainUrl + '/search';
    if(key.length < 2) return
    $.ajax({
        url: url,
        type: 'POST',
        data: { word: key, _token: token },
        success: function (res) {
            let list = '';
            if (res.results.length) {
                $.each(res.results, function (index, item) {
                    list += `<li><a href="${mainUrl + '/' + item.slug}">${item.title}</a></li>`
                })
            } else {
                list += '<li><a href="#">موردی یافت نشد</a></li>';
            }

            $('.results').html(`
                        <h5>نتایج جست و جو:</h5>
                        <ul >
                         ${list}
                        </ul>
                        `)
            request = false;
        }, error: function (error) {

        }
    })
}