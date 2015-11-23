"use strict";

var app = app || {};

app.initPackery = function(){
	var $container = $('#container');

	// init packery
	$container.packery({
		itemSelector: '.item',
		"columnWidth": ".grid-sizer",
		"percentPosition": true,
		gutter: 0,
		"isOriginLeft": true,
		transitionDuration: "0.5s"
	});

	return $container;
};

app.showBoxSlider = function(that){

    //if(app.isExplorer() && document.querySelectorAll("#boxSlid").length <= 1){
       // doStuff();
    //}
	if(document.querySelectorAll("#boxSlid").length <= 0){
		doStuff();
	}

    function doStuff(){
        console.log("doStuff");
        var topPositionOfElement = window.getComputedStyle(that).top;
        var heightOfElement = window.getComputedStyle(that).height;

        var template = document.querySelector("#template").cloneNode(true);
        var boxSlidTemplate;

        boxSlidTemplate = template.querySelector("#boxSlid2");
        boxSlidTemplate.setAttribute("id", "boxSlid");
        boxSlidTemplate.querySelector(".bxslider2").setAttribute("class", "bxslider");
        boxSlidTemplate.style.top = parseInt(topPositionOfElement)+parseInt(heightOfElement)+"px";
        $(that).after(boxSlidTemplate);
    }
};

app.isExplorer = function(){
    return document.documentMode > 0;
};

app.packeryOnLayout = function(){
	if(app.isSlider){
		app.scrollToElement("#boxSlid", 1000, function(){
            app.displayMovingMenu = false;
            app.hideMenu();
            app.showCustomPager();
        });
		app.isSlider = false;
	}
};

app.packeryItemClick = function($container){
	// click on a packery item
	var prevElement;
	$container.on( 'click', '.item', function( event ) {
		if(this.id !== "boxSlid"){
			app.showBoxSlider(this);
			prevElement = this;
			app.isSlider = true;

			$container.packery('reloadItems');
			$container.packery();
			//app.disableScroll();

			// use app.getImages when site is live
			// app.getImages();
			app.boxSliderStarter($container, prevElement);
		}
	});

	$(document).keyup(function(e) {
		// esc key
     	if (e.keyCode === 27) {
        	app.removeBoxSlider(prevElement, $container);
	    }
	});

	// Trigger on layoutComplete
	$container.on( 'layoutComplete', app.packeryOnLayout );
};
