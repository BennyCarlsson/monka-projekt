"use strict";

var app = app || {};

app.menuStill = true;
app.menuMoving = false;
app.menuRemove = false;
app.displayMovingMenu = true;
app.animateMenuAfterHide = false;
app.showingIntroImage = true;

var nav;
var navHomeY;
var firstElement;
var navDisappearY;

app.menu = function(){
    app.changeWhenMenuDisapear();
    window.addEventListener('resize', function(event){
        app.changeWhenMenuDisapear();
    });

   var $w = $(window);
   $w.scroll(function(e) {
       var scrollTop = $w.scrollTop();
       var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed) {
            if(scrollTop > (navDisappearY + nav.height())){
                if(app.menuRemove){
                    app.hideMenu();
                    app.introImageRemover();
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
   }else if(app.getScroll() >= navDisappearY){
       app.hideMenu();
       app.introImageRemover();
   }

};
app.introImageRemover = function(){
    if(app.showingIntroImage){
        //remove introImage
        var height = $('#introImageAndMeny').height();
        $(document).scrollTop($(document).scrollTop() - height);
        $('#introImageAndMeny').remove();
        app.showingIntroImage = false;
        app.changeWhenMenuDisapear();
    };
};
app.changeWhenMenuDisapear = function(){
    if(app.showingIntroImage){
        nav = $('#nav');
        navHomeY = nav.offset().top;
        firstElement = document.querySelector(".image-1");
        navDisappearY = nav.offset().top + (parseInt(firstElement.getBoundingClientRect().height)*2);

    }else{
        nav = $('#nav');
        navHomeY = 0;
        firstElement = document.querySelector(".image-1");
        navDisappearY = (parseInt(firstElement.getBoundingClientRect().height)*2);
    }
}
app.standingStillMenu = function(){
    $('#nav').removeClass("overlayNavHideAnimation");
    $('#nav').removeClass("overlayNav");
    $('.borderBottom').css({
        "border": "none"
    });
    $('.menuRight').css({
        "margin-right": "0px"
    })
    $(".mobileMenuWrap").css({
        "margin-right": "0px"
    });
    app.menuStill = false;
    app.menuMoving = true;
};

app.displayMenu = function(){

    $('#nav').removeClass("overlayNavHideAnimation");
    $('#nav').addClass("overlayNav");
    $('.borderBottom').css({
        "border-bottom": "1px solid black",
        "border-color": "black"
    });
    $('.menuRight').css({
        "margin-right": "20px"
    });
    $(".mobileMenuWrap").css({
        "margin-right": "20px"
    });

    if(app.animateMenuAfterHide){
        $('#nav').css({
            "transition": "height 0.3s"
        });
       // $('#nav').height("initial");
        app.animateMenuAfterHide = false;
    }

    app.menuMoving = false;
    app.menuRemove = true;
    app.menuStill = true;
};
app.hideMenu = function(){
    //$('#nav').height($('#nav').height());
    $('#nav').addClass("overlayNavHideAnimation");
    $('#nav').removeClass("overlayNav");

    $('.menuRight').css({
        "margin-right": "20px"
    })
    $(".mobileMenuWrap").css({
        "margin-right": "20px"
    });
    app.menuRemove = false;
    app.menuMoving = true;
    app.animateMenuAfterHide = true;
};

app.lightSwitch = function($container){

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
            switchColor("#fff" , "#000", "#6C6C6C");
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
                app.disableScroll();
                app.scrollToElement("header", 1500, function () {
                    //app.removeIntroImage();
                    app.displayMenuItems();
                    clearTimeout(timer);
                    app.enableScroll();
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
            app.disableScroll();
            app.scrollToElement("header", 1500, function () {
    		    //app.removeIntroImage();
                app.displayMenuItems();
                app.enableScroll();
    		});
            scroll = false;
        }
    }, 3000);

    // move on arrow click
	arrowImg.addEventListener("click", function(){
        scroll = false;
		app.scrollToElement("header", 1500, function () {
		    //app.removeIntroImage();
            app.displayMenuItems();
            clearTimeout(timer);
		});
	});
};

app.displayMenuItems = function(){
    var menuHeader = document.querySelector("header");
    var menuNav = document.querySelector("#putBorderBottomHereInsteadOfOnNav");
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
    //var menuHolder = document.querySelector(".left");
    var menu = document.querySelector(".menuItems");

    var menuButton = document.querySelector(".mobileMenuWrap");
    // show hide menu
    var showMenu = false;
    menuButton.addEventListener("click", function(){
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
