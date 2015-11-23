function delete_confirm(){
	return confirm("Are you sure? All images,thumbnails and texts will be deleted");
}
function delete_tag_confirm(){
    return confirm("Do you want to remove this tag from all series?");
}

//http://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded
function handleFileSelect(evt) {
	document.getElementById('list').innerHTML = "";
    var files = evt.target.files;

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = 
          [
            '<img id="target" style="height: 75px; border: 1px solid #000; margin: 5px" src="', 
            e.target.result,
            '" title="', escape(theFile.name), 
            '"/>'
          ].join('');
          
          document.getElementById('list').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }
  document.getElementById('files').addEventListener('change', handleFileSelect, false);

//tags javascript
function addTagToInput(tagName){
    var tagValue =  document.getElementById('tagInput').value;
    if(tagValue.length === 0 || tagValue === "" || tagValue === " "){
        newtagValue = tagName;
    }else if(tagValue.length > 0){
        if(tagValue.charAt(tagValue.length-1) === ","){
            newtagValue = tagValue+tagName;
        }else{
            newtagValue = tagValue+","+tagName;
        }
    }else{
        newtagValue = tagValue;
    }
    document.getElementById('tagInput').value = newtagValue;
}