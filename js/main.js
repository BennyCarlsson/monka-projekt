"use strict";

var app = app || {};

app.init = function(){
	app.divResize(".image-1", 1, 1);
    app.divResize(".image-2", 2, 1);
    app.divResize(".image-3", 2, 2);

	app.introImage();
	app.menu();
	var $packery = app.initPackery();

	app.packeryItemClick($packery);
	app.lightSwitch();

	//if(app.isMobile()){
		app.mobileMenu();
	//}
    //TODO randomIntroImage on phone images
    app.randomIntroImage();
};

app.isSlider = false;

// prevent from using thes keys on disableScroll
app.keys = {37: 1, 38: 1, 39: 1, 40: 1};

app.preventDefault = function(e){
	e = e || window.event;
	if (e.preventDefault)
		e.preventDefault();
	e.returnValue = false;
};

app.preventDefaultForScrollKeys = function(e){
	if (app.keys[e.keyCode]) {
		app.preventDefault(e);
		return false;
	}
};

app.disableScroll = function(){
	if (window.addEventListener){ // older FF
		window.addEventListener('DOMMouseScroll', app.preventDefault, false);
	}
	window.onwheel = app.preventDefault; // modern standard
	window.onmousewheel = document.onmousewheel = app.preventDefault; // older browsers, IE
	window.ontouchmove  = app.preventDefault; // mobile
	document.onkeydown  = app.preventDefaultForScrollKeys;
};

app.enableScroll = function(){
	if (window.removeEventListener){
		window.removeEventListener('DOMMouseScroll', app.preventDefault, false);
	}
	window.onmousewheel = document.onmousewheel = null;
	window.onwheel = null;
	window.ontouchmove = null;
	document.onkeydown = null;
};

app.scrollToElement = function(element, animateTime, callback){
	animateTime = animateTime || 1500;
	$("html, body").animate(
	{
		scrollTop: $( $(element) ).offset().top
	},
	{
		duration : animateTime,
		easing   : 'swing',
		complete : function(){
			callback = callback || function(){};
			callback();
		}
	});
};

app.divResize = function(element, h, w){
	var firstElement = document.querySelector(".image-1");
	var height = firstElement.getBoundingClientRect().height;
	var width = firstElement.getBoundingClientRect().width;

	var elem = document.querySelectorAll(element);
	for (var i = 0; i < elem.length; i++) {
		if(element !== ".image-1" || i !== 0){
			if(elem[i].tagName === "VIDEO"){
				elem[i].setAttribute("height", (height*h)+"px");
				elem[i].setAttribute("width", (width*w)+"px");
			}else{
				elem[i].style.height = (height*h)+"px";
				elem[i].style.width =  (width*w)+"px";
			}

		}
    }
};

app.isMobile = function(){
	var isMobile = window.matchMedia("only screen and (min-device-width : 320px) and (max-device-width : 480px)");
    return isMobile.matches;
};

app.randomIntroImage = function(){
    var number = Math.floor((Math.random() * 5) + 1);
    var imgSrc = "../monka/css/introImages/intro_lax.jpg";
    switch(number){
        case 1: imgSrc = "../monka/css/introImages/intro_lax.jpg";
            break;
        case 2: imgSrc = "../monka/css/introImages/intro_brakfest_1.jpg";
            break;
        case 3: imgSrc = "../monka/css/introImages/intro_lip.jpg";
            break;
        case 4: imgSrc = "../monka/css/introImages/intro_spaceman.jpg";
            break;
        case 5: imgSrc = "../monka/css/introImages/intro_splash.jpg";
            break;
        default: imgSrc = "../monka/css/introImages/intro_lax.jpg";
            break;
    }
    $('.introImage').css('background-image', 'url('+imgSrc+')');
};
window.onresize = function(e){
	/*if(window.innerWidth < 600){
		app.mobileMenu();
	}*/
	/*if(!app.isSlider){
		app.scrollToElement("#boxSlid", 0);
	}*/
	app.divResize(".image-1", 1, 1);
	app.divResize(".image-2", 2, 1);
	app.divResize(".image-3", 2, 2);
};

window.onload = app.init;
