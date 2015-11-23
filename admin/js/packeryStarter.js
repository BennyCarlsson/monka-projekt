"use strict";

var app = app || {};

app.init = function(){
	app.divResize(".image-1", 1, 1);
    app.divResize(".image-2", 2, 1);
    app.divResize(".image-3", 2, 2);
    app.masonry();
};


var $itemElems;
var $container;
var dragTimeout;

//http://codepen.io/anon/pen/JdQaRZ
app.height;
app.masonry = function(){
	var firstElement = document.querySelector(".image-1");
	app.height = firstElement.getBoundingClientRect().height;

    $container = $('#container');
    $container.packery({
        "columnWidth": ".grid-sizer",
        "percentPosition": true,
        gutter: 0,
        "isOriginLeft": true,
        "rowHeight": app.height
    });
    // get item elements, jQuery-ify them
    $itemElems = $( $container.packery('getItemElements') );
    // make item elements draggable
    $itemElems
        .draggable({
            start: function(event,ui){
                if(!$(event.target).hasClass('item'))
                    return false;
            },
            cancel: '.stampitem',
            stop: function(event,ui){
                if ( dragTimeout ) {
                    clearTimeout( dragTimeout );
                }
                dragTimeout = setTimeout( function() {
                    $container.packery();
                }, 500 );
            }
        });
    // bind Draggable events to Packery
    $container.packery( 'bindUIDraggableEvents', $itemElems );

    $itemElems.on("dblclick", function(event){
        event.stopPropagation();
        console.log(event);
        var $target = $(event.currentTarget);
        if($target.hasClass('ui-draggable')){
            $($target).addClass('stampitem').removeClass('ui-draggable');
            $container.packery('stamp', event.currentTarget);
        }
        else{
            $($target).addClass('ui-draggable').removeClass('stampitem');
            $container.packery('unstamp', event.currentTarget);
        }
    });
    $itemElems.not('.item').on('dragstart', function(event){return false;})
    //$('.ui-resizable-handle').on('dblclick', function(event){return false;})
//stops here

    //richards resize
	window.onresize = function(){
		var firstElement = document.querySelector(".image-1");
		app.height = firstElement.getBoundingClientRect().height;

		$container.packery({
            itemSelector: '.item',
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

	
	function getOrder (){
		var itemElems = $container.packery('getItemElements');
		$( itemElems ).each( function( i, itemElem ) {
			//$(itemElem).text( i + 1 );
            if(i > 0){ //eftersom den tar upp grid-sizer div som tydligen måste
            //// vara där så får den null värde alltså hoppa över den
                itemElem.querySelector("input").value = i;
            }
		});
	}
	$container.packery( 'on', 'layoutComplete', getOrder );
	$container.packery( 'on', 'dragItemPositioned', getOrder );
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
			} else{
				elem[i].style.height = (height*h)+"px";
				elem[i].style.width =  (width*w)+"px";	
			}
			
		}
		
    }
}
window.onload = app.init
































