"use strict";

var app = app || {};

app.menuStill = true;
app.menuMoving = false;
app.menuRemove = false;
app.displayMovingMenu = true;

app.menu = function(){
   var nav = $('#nav');
   var navHomeY = nav.offset().top;

   var firstElement = document.querySelector(".image-1");
   var navDisappearY = nav.offset().top + (parseInt(firstElement.getBoundingClientRect().height)*2);

   var $w = $(window);
   $w.scroll(function(e) {
       var scrollTop = $w.scrollTop();
       var shouldBeFixed = scrollTop > navHomeY;

        if (shouldBeFixed) {
            if(scrollTop > navDisappearY) {
                if(app.menuRemove){
                    app.hideMenu();
                }
            } else {
                if(app.menuMoving){
                    if(app.displayMovingMenu){
                        app.displayMenu();
                    }
                }
            }
        } else if (!shouldBeFixed) {
            if(app.menuStill){
                app.standingStillMenu();
            }
        }
   });

   if(app.getScroll() > navHomeY && app.getScroll() < navDisappearY){
       app.displayMenu();
   }else{
       app.hideMenu();
   }
};

app.standingStillMenu = function(){
    $('#nav').css({
        position: 'static'
    });
    app.menuStill = false;
    app.menuMoving = true;
};

app.displayMenu = function(){
    $('#nav').css({
        position: 'fixed',
        zIndex: "50",
        top: 0,
        display: "initial",
        height: "70px",
        transition: "height 0.3s",
        borderBottom: "1px solid",
        borderColor: "black",
        overflow: "hidden",
        width: "97.9%"
    });

    app.menuMoving = false;
    app.menuRemove = true;
    app.menuStill = true;
};

app.hideMenu = function(){
    $('#nav').css({
        // TODO: animate removal
        //display: "none"
        height: "0px",
        border: "none"
    });
    app.menuRemove = false;
    app.menuMoving = true;

};

app.lightSwitch = function(){
    var isSwitched = false;
    var lightSwitch = document.querySelector(".lightSwitch");

    // background
    var body = document.querySelector("body");
    var imgPadding = document.querySelectorAll(".item .portfolioName"); // border color
    var menuStill = document.querySelector("header");
    var menuMoving = document.querySelector("#nav");

    // font
    var menuText = document.querySelectorAll(".menuItems a");

    function switchColor(backColor, miscColor, font){
        body.style.backgroundColor = backColor;
        menuStill.style.backgroundColor = backColor;
        menuStill.style.borderColor = miscColor;
        menuMoving.style.backgroundColor = backColor;
        menuMoving.style.borderColor = miscColor;

        for (var i = 0; i < imgPadding.length; i++) {
            imgPadding[i].style.borderColor = backColor;
        }
        for (var i = 0; i < menuText.length; i++) {
            menuText[i].style.color = font;
        }
    }

    lightSwitch.addEventListener("click", function(e){
        e.preventDefault();

        if(isSwitched){
            switchColor("#fff" , "#000", "#6C6C6C")
            isSwitched = false;
        }else{
            switchColor("#222222", "#7C7C7C", "#fff");
            isSwitched = true;
        }

    }, false);
};

app.introImage = function(){
	var scroll = true;
    var arrowImg = document.querySelector(".introImageArrow");

    // move on scroll
    var scrollPos = app.getScroll();
    if(scrollPos <= 0 && scroll){

        window.onscroll = function(){
            if(scroll){
                app.scrollToElement("header", 1500, function () {
                    app.removeIntroImage();
                    app.displayMenuItems();
                    clearTimeout(timer);
                });
            }
            scroll = false;
        };
    }else{
        app.displayMenuItems();
        clearTimeout(timer);
        scroll = false;
    }

    // move on timer
    var timer = setTimeout(function(){
        if(scroll){
            app.scrollToElement("header", 1500, function () {
    		    app.removeIntroImage();
                app.displayMenuItems();
    		});
            scroll = false;
        }
    }, 3000);

    // move on arrow click
	arrowImg.addEventListener("click", function(){
        scroll = false;
		app.scrollToElement("header", 1500, function () {
		    app.removeIntroImage();
            app.displayMenuItems();
            clearTimeout(timer);
		});
	});
};

// TODO: fix this!
app.removeIntroImage = function(){
    var body = document.querySelector("body");
    var introImage = document.querySelector(".introImage");
    try {
        //body.removeChild(introImage);
        //introImage.style.height = "0px";
    } catch (e) {

    }
    /*
        var introImageHeight = parseInt(window.getComputedStyle(introImage).height);

    */
};

app.displayMenuItems = function(){
    var menuHeader = document.querySelector("header");
    var menuNav = document.querySelector("#nav");
    var menuText = document.querySelector(".menuItems");
    var introImageArrow = document.querySelector(".introImageArrowWrap");

    menuText.style.opacity = 1;
    menuHeader.setAttribute("class", "borderBottomHeader");
    menuNav.setAttribute("class", "borderBottom");
    introImageArrow.style.display="none";
};

app.getScroll = function(){
    return window.pageYOffset;
};

// makes mobile menu
app.mobileMenu = function(){
    var header = document.querySelector("header");
    var menuHolder = document.querySelector(".left");
    var menu = document.querySelector(".menuItems");

    var displayMenu = document.createElement("div");
    displayMenu.setAttribute("class", "mobileMenuWrap");

    // make menu lines
    var span;
    for (var i = 0; i < 3; i++) {
        span = document.createElement("span");
        span.setAttribute("class", "mobileMenuLine");
        displayMenu.appendChild(span);
    }
    menuHolder.appendChild(displayMenu);

    // show hide menu
    var showMenu = false;
    displayMenu.addEventListener("click", function(){
        if(showMenu){
            header.style.height = "58px"
            menu.style.display = "none";
            showMenu = false;
        }else{
            header.style.height = "initial";
            menu.style.display = "initial";
            showMenu = true;
        }

    }, false);

};
