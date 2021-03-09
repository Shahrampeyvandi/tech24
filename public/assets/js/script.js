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