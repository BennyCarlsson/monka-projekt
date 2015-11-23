var jcrop_api;
var thumbnailSize;
/*
 * TODO if press choose file but then not choosing will keep preview but not upload anthing!
 */
function jcropStart(){	
	jQuery(function($) {
	    $('#thumbnailPreview').Jcrop({
	    	onChange: showPreview,
			onSelect: showPreview,
	    	aspectRatio: thumbnailSize,
	    	onSelect: updateCoords,
	    	boxWidth: 500,
	    	addClass: 'jcrop-light'
	    },function(){
        	jcrop_api = this;
        	//alert(jQuery( 'input[name=newThumbnailSize]:checked' ).val());
        	var number = jQuery( 'input[name=newThumbnailSize]:checked' ).val();
    		switch(number){
				case "1":
					 jcrop_api.setOptions({aspectRatio: 141/100});
				     jcrop_api.focus();
					break;
				case "2":
					jcrop_api.setOptions({aspectRatio: 71/100});
				     jcrop_api.focus();
					break;
				case "3":
					jcrop_api.setOptions({aspectRatio: 141/100});
				     jcrop_api.focus();
					break;
			}
      });
	});
}
function showPreview(coords)
{
	var rx = 100 / coords.w;
	var ry = 100 / coords.h;

	$('#preview').css({
		width: Math.round(rx * 500) + 'px',
		height: Math.round(ry * 370) + 'px',
		marginLeft: '-' + Math.round(rx * coords.x) + 'px',
		marginTop: '-' + Math.round(ry * coords.y) + 'px'
	});
}
  function updateCoords(c)
  {
    $('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
	alert('Please select a crop region then press submit.');
    return false;
  };


function getCurrentThumbnailAsPreview(path){
    $('#thumbnailPreview').attr('src',path);
    jcropStart();

    //jcrop_api might not had the time to be defined so checks if it is!
    if(typeof jcrop_api === 'undefined'){
        var myInterval = setInterval(function(){
            if(typeof jcrop_api !== 'undefined'){
                jcrop_api.setImage(path);
                clearInterval(myInterval);
            }
        },1000);
    }else{
        jcrop_api.setImage('gallery/'+mapName+'/thumbnail/original.jpg');
    }

}
 //for preview on upload
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#thumbnailPreview').attr('src', e.target.result);
            jcropStart();
            jcrop_api.setImage(e.target.result);
        }
		
        reader.readAsDataURL(input.files[0]);
        /*
		 * TODO if press choose file but then not choosing will keep preview but not upload anthing!
		 */
    }
}

$("#imgInp").change(function(){
    readURL(this);
})

$('#thumbNailSize1RadioOption').change(function(e) {
      jcrop_api.setOptions(this.checked?
        { aspectRatio: 141/100 }: { aspectRatio: 0 });
      jcrop_api.focus();
});
$('#thumbNailSize2RadioOption').change(function(e) {
      jcrop_api.setOptions(this.checked?
        { aspectRatio: 71/100 }: { aspectRatio: 0 });
      jcrop_api.focus();
});
$('#thumbNailSize3RadioOption').change(function(e) {
      jcrop_api.setOptions(this.checked?
        { aspectRatio: 141/100 }: { aspectRatio: 0 });
      jcrop_api.focus();
});





















