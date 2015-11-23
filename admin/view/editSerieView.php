<?php

Class EditSerieView{
	private static $newFiles = "newFiles";
	private static $editButton = "editButton";
	private static $serieId = "serieIdForm";
	private static $newTitle = "newTitel";
	private static $newText = "newText";
	private static $newSmallText = "newSmallText";
	private static $newVisibility = "newVisibility";
	private static $deleteButton = "deleteButton";
	private static $deleteImageButton = "deleteImageButton";
	private static $imageDir = "imageDir";
	private $cropView;
    private $tagView;
	
	public function __construct(){
		$this->cropView = new CropView();	
	    $this->tagView = new TagView();
    }
	public function checkEditButton(){
		if(isset($_POST[self::$editButton])){
			return true;
		}
		return false;
	}
	public function getNewFiles(){
		if(isset($_FILES[self::$newFiles])){
			return $_FILES[self::$newFiles];	
		}
	}
	public function checkIfUploadingFiles(){
		if($_FILES[self::$newFiles]['error'][0] == 0){
			return true;
		}
		return false;
	}
	public function getSerieId(){
		return $_POST[self::$serieId];
	}
	public function getNewTitle(){
		if(isset($_POST[self::$newTitle])){
			return $_POST[self::$newTitle];	
		}
	}
	public function getNewText(){
		if(isset($_POST[self::$newText])){
			return $_POST[self::$newText];	
		}
	}
	public function getNewSmallText(){
		if(isset($_POST[self::$newSmallText])){
			return $_POST[self::$newSmallText];	
		}
	}
	public function getNewVisibility(){
		if(isset($_POST[self::$newVisibility])){
			return $_POST[self::$newVisibility];	
		}
	}
	public function checkDeleteButton(){
		if(isset($_POST[self::$deleteButton])){
			return true;
		}
		return false;
	}
	public function getEditViewHTML($serie){
		$tags = $this->tagView->getTagForEditViewForm($serie->serieId);
        $HTML = "
				<a href='index.php'><--Tillbaka</a>
				<form method='post' enctype='multipart/form-data'>
					Titel: <input type='text' value='$serie->titel' name='".self::$newTitle."'/>
					</br>
					Text: <input type='text' value='$serie->text' name='".self::$newText."'/>
					</br>
					SmallText: <input type='text' value='$serie->smallText' name='".self::$newSmallText."'/>
					</br>
					MapName: $serie->mapName
					</br>
                    $tags
					</br>
					Position: $serie->position
					</br>";
		$HTML .= $this->getVisibilityHTML($serie->visibility); 
		$HTML.=	 "<p>
					<input id='files' name='".self::$newFiles.'[]'."' type='file' multiple>
					<input type='submit' name='".self::$editButton."' value='Edit'>
					<input type='hidden' name='".self::$serieId."' value='$serie->serieId'>
					<output id='list'></output>
				  </p>";
	  	$HTML .= $this->cropView->getThumbnailSizeFormHTML($serie->thumbnailSize);
        $format = $this->getThumbnailFormatOnFolderName($serie->mapName);
        $HTML .= $this->cropView->getCurrentThumbnailForEditSerie($serie->mapName,$format);
	    $HTML.= $this->cropView->getCropFormPart();
		$HTML.=	 "</br><input type='submit' value='DELETE' name='".self::$deleteButton."' onclick=' return delete_confirm()'/>
				";
		return $HTML;
	}
	private function getVisibilityHTML($visibility){
		if($visibility == 1){
			$HTML = "Visa: <input type='radio' name='".self::$newVisibility."' value='1' checked>
			Göm: <input type='radio' name='".self::$newVisibility."' value='0'>";
		}else{
			$HTML = "Visa: <input type='radio' name='".self::$newVisibility."' value='1'>
			Göm: <input type='radio' name='".self::$newVisibility."' value='0' checked>";
		}
		return $HTML;
	}
	public function checkDeleteImageButton(){
		if(isset($_POST[self::$deleteImageButton])){
			return true;
		}
		return false;
	}
	public function getDeleteImageDir(){
		return $_POST[self::$imageDir];
	}
    public function getImagesPosition(){
        return $_POST["imgPosition"];
    }
	public function getImagesForSerie($imageObject){
		$HTML = "<div id='imageFormEditWrapper'> ";
        foreach($imageObject as $imgObject){
            $HTML .="
                    <div class='imageFormEdit'>
                    <img src='$imgObject->src' alt='image' width='250'>
                    <input type='text' value='$imgObject->position' class='imgEditPosition' name='imgPosition[$imgObject->imageId]'>
                        <form method='post'>
                            <input type='hidden' value='$imgObject->src' name='".self::$imageDir."' />
                            <input type='submit' value='X' class='deleteImageEditButton' name='".self::$deleteImageButton."' />
                        </form>
					</div>
					";
        }
        $HTML .="</div>
            </form>"; //start getEditViewHTML();
		return $HTML;
	}
    public function getCurrentThumbnailOriginalPath($folderName){
        $format = $this->getThumbnailFormatOnFolderName($folderName);
        $path = "gallery/$folderName/thumbnail/original.$format";
        return $path;
    }
    private function getThumbnailFormatOnFolderName($mapName){
        $filePath = "gallery/$mapName/thumbnail/original.";
        if(file_exists($filePath."jpg")){
            return "jpg";
        }else if(file_exists($filePath."png")){
            return "png";
        }else if(file_exists($filePath."jpeg")){
            return "jpeg";
        }
    }
}


























