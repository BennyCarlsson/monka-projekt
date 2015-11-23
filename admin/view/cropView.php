<?php

Class CropView{
    private static $newThumbnailSize = "newThumbnailSize";
	public function getXCropValue(){
		if(isset($_POST['x']))
		return $_POST['x'];
	}
	public function getYCropValue(){
		if(isset($_POST['y']))
		return $_POST['y'];
	}
	public function getWCropValue(){
		if(isset($_POST['w']))
		return $_POST['w'];
	}
	public function getHCropValue(){
		if(isset($_POST['h']))
		return $_POST['h'];
	}
	public function getThumbnailFile(){
		if(isset( $_FILES['image_file'])){
			return $_FILES['image_file'];	
		}
    }
    public function getNewThumbnailSize(){
        if(isset($_POST[self::$newThumbnailSize])){
            return $_POST[self::$newThumbnailSize];
        }
    }
    public function checkIfThumbnailIsVimeoVideo(){
        if($_POST["thumbnailFormat"] == "vimeoThumbnail"){
            return true;
        }
        return false;
    }
    public function getVimeoLinkForThumbnail(){
        if(isset($_POST["vimeoLinkForThumbnail"])){
            return $_POST["vimeoLinkForThumbnail"];
        }
    }
    public function getCurrentThumbnailForEditSerie($folderName,$format){
        $originalThumbnailPath = "gallery/$folderName/thumbnail/original.$format";
        $HTML='<img id="currentThumbnail" onClick="getCurrentThumbnailAsPreview(\''.$originalThumbnailPath.'\')"
        src="gallery/'.$folderName.'/thumbnail/thumbnail.'.$format.'?randV='.rand(1,1000).'" alt="current thumbnail"
        width="150"/>';
        return $HTML;
    }
    public function getCropFormPart(){
        $HTML = '
                <input type="radio" name="thumbnailFormat" value="vimeoThumbnail">Vimeo video
                <input type="radio" name="thumbnailFormat" value="imageThumbnail" checked>Image
                </br>
                Vimeo link:<input type="text" id="vimeoLinkForThumbnail" name="vimeoLinkForThumbnail"/>
                </br>
				<input type="file" name="image_file" id="imgInp"/>
				<img id="thumbnailPreview" src="#" alt="thumbnail preview"/>
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
				';
		return $HTML;
	}

    public function getThumbnailSizeFormHTMLForNew(){
        $HTML ="ThumbnailSize:
				Liten<input id='thumbNailSize1RadioOption' type='radio' value='1' name='".self::$newThumbnailSize."' checked/>
				Mellan<input id='thumbNailSize2RadioOption' type='radio' value='2' name='".self::$newThumbnailSize."'/>
				Stor<input id='thumbNailSize3RadioOption' type='radio' value='3' name='".self::$newThumbnailSize."'/>";
        return $HTML;
    }
    public function getThumbnailSizeFormHTML($thumbnailSize){
        $HTML = "</br>";
        if($thumbnailSize == 1){
            $HTML .="ThumbnailSize:
				Liten<input id='thumbNailSize1RadioOption' type='radio' value='1' name='".self::$newThumbnailSize."' checked/>
				Mellan<input id='thumbNailSize2RadioOption' type='radio' value='2' name='".self::$newThumbnailSize."'/>
				Stor<input id='thumbNailSize3RadioOption' type='radio' value='3' name='".self::$newThumbnailSize."'/>";
        }
        else if($thumbnailSize == 2){
            $HTML .="ThumbnailSize:
				Liten<input id='thumbNailSize1RadioOption' type='radio' value='1' name='".self::$newThumbnailSize."' />
				Mellan<input id='thumbNailSize2RadioOption' type='radio' value='2' name='".self::$newThumbnailSize."'checked/>
				Stor<input id='thumbNailSize3RadioOption' type='radio' value='3' name='".self::$newThumbnailSize."'/>";
        }
        else {
            $HTML .="ThumbnailSize:
				Liten<input id='thumbNailSize1RadioOption' type='radio' value='1' name='".self::$newThumbnailSize."'/>
				Mellan<input id='thumbNailSize2RadioOption' type='radio' value='2' name='".self::$newThumbnailSize."'/>
				Stor<input id='thumbNailSize3RadioOption' type='radio' value='3' name='".self::$newThumbnailSize."' checked/>";
        }
        return $HTML;
    }
}
 
