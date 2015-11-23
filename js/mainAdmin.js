"use strict";

var app = app || {};

app.init = function(){
	app.divResize(".image-1", 1, 1);
    app.divResize(".image-2", 2, 1);
    app.divResize(".image-3", 2, 2);
    app.masonry();
};


app.height;
app.masonry = function(){
	var firstElement = document.querySelector(".image-1");
	app.height = firstElement.getBoundingClientRect().height;

	var $container = $('#container');

	$container.packery({
		itemSelector: '.item',
		"columnWidth": ".grid-sizer",
		"percentPosition": true,
		gutter: 0,
		"isOriginLeft": true,
		"rowHeight": app.height
	});

	$container.find('.item').each( function( i, itemElem ) {
    	// make element draggable with Draggabilly
    	var draggie = new Draggabilly( itemElem );
    	// bind Draggabilly events to Packery
    	$container.packery( 'bindDraggabillyEvents', draggie );
  	});

	window.onresize = function(){
		var firstElement = document.querySelector(".image-1");
		app.height = firstElement.getBoundingClientRect().height;

		$container.packery({itemSelector: '.item',
			"columnWidth": ".grid-sizer",
			"percentPosition": true,
			gutter: 0,
			"isOriginLeft": true,
			"rowHeight": app.height
		});

		app.divResize(".image-1", 1, 1);
	    app.divResize(".image-2", 2, 1);
	    app.divResize(".image-3", 2, 2);
	}
};

window.onload = app.init;

app.divResize = function(element, h, w){
	var firstElement = document.querySelector(".image-1");

	var height = firstElement.getBoundingClientRect().height;
	var width = firstElement.getBoundingClientRect().width;
	var elem = document.querySelectorAll(element);
	for (var i = 0; i < elem.length; i++) {
		if(element !== ".image-1" || i !== 0){
			elem[i].style.height = (height*h)+"px";
			elem[i].style.width =  (width*w)+"px";
		}
    }
}


window.onload= app.init
