"use strict";

var slide;
var nav;
var timer;

function init() {
    slide = document.querySelector(".slide1");
    slide.style.display = "flex";
    nav = document.querySelector(".nav:first-child");
    nav.classList.add("active");
    timer = setInterval(setNextSlide, 3000);
}

function setNextSlide() {
    var nextSlide = slide.nextElementSibling;
    var nextNav = nav.nextElementSibling;
    nav.classList.remove("active");
    slide.style.display = "none";
    if(nextNav !== null){
        nextNav.classList.add("active");
        nextSlide.style.display = "flex";
    } else {
        nextSlide = document.querySelector(".slide:first-child");
        nextSlide.style.display = "flex";
        nextNav = document.querySelector(".nav:first-child");
        nextNav.classList.add("active");
    }
    slide = nextSlide;
    nav = nextNav;
}

document.querySelector(".slider-nav").addEventListener("click", function () {
    var selectNav = event.target;
    if(selectNav.classList.contains("nav")) {
        setSlide(selectNav);
    }
});

function setSlide(navNew) {
    clearInterval(timer);
    var oldSlide = document.querySelectorAll('.reviev-slider > .slide');
    for(var i = 0; i < oldSlide.length; i++) {
        oldSlide[i].style.display = "none";
    }
    var newSlide = document.querySelector(".slide" + navNew.dataset.slide);
    newSlide.style.display = "flex";
    document.querySelector(".slider-nav > .active").classList.remove("active");
    navNew.classList.add("active");
    slide = newSlide;
    nav = navNew;
    timer = setInterval(setNextSlide, 3000);
}

window.onload = init();