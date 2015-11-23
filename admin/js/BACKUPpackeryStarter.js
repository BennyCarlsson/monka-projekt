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
			itemElem.querySelector("input").value = i;
			
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
            console.log("element:"+elem[i]+" h:"+height+" w:"+width);
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

/*
var $itemElems;
var $container;
var dragTimeout;
$( function() {
    $container = $('.packery');
    $container.packery({
        rowHeight: 100,
        columnHeight: 100,
        gutter: 0
    });
    // get item elements, jQuery-ify them
    $itemElems = $( $container.packery('getItemElements') );
    // make item elements draggable
    $itemElems
        .draggable({
            grid: [ 100, 100 ],
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
        })
        .resizable({
            grid: 100,
            handles: {
                'nw': '#nwgrip',
                'ne': '#negrip',
                'sw': '#swgrip',
                'se': '#segrip',
                'n': '#ngrip',
                'e': '#egrip',
                's': '#sgrip',
                'w': '#wgrip'
            },
            start: function(event,ui){
                if($(event.target).hasClass('item')){
                    $(event.target).css('z-index', 1000);
                }
            },
            resize: function(event,ui){
                $container.packery( 'fit', event.target, ui.position.left, ui.position.top );
            },
            cancel: '.stampitem',
            stop: function(event,ui){
                $(event.target).css('z-index','auto');
                $container.packery();
            },
            maxWidth:800,
            refreshPositions: true
        });
    // bind Draggable events to Packery
    $container.packery( 'bindUIDraggableEvents', $itemElems );

    $itemElems.on("dblclick",function(event){
        event.stopPropagation();
        var $target = $(event.target);
        if($target.hasClass('item')){
            $($target).addClass('stampitem').removeClass('item ui-draggable ui-resizable');
            $container.packery('stamp', event.target);
        }
        else{
            $($target).addClass('item ui-draggable ui-resizable').removeClass('stampitem');
            $container.packery('unstamp', event.target);
        }
    })

    $itemElems.not('.item').on('dragstart', function(event){return false;})

    $('.ui-resizable-handle').on('dblclick', function(event){return false;})
});
*/
































