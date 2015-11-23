<?php
require_once 'tagView.php';
Class NewSerieView{	
	private static $serieNameForm = "serieNameForm";
	private static $serieTitelForm = "serieTitelForm";
	private static $serieTextForm = "serieTextForm";
	private static $serieSmallTextForm = "serieSmallTextForm";
	private static $newSerieButton = "newSerieButton";
	private static $files = "files";
	private $cropView;
	private $tagView;
	
	public function __construct(){
		$this->cropView = new CropView();	
		$this->tagView = new TagView();
	}
	public function getSerieNameForm(){
		return $_POST[self::$serieNameForm];
	}
	public function getSerieTitelForm(){
		return $_POST[self::$serieTitelForm];
	}
	public function getSerieTextForm(){
		return $_POST[self::$serieTextForm];
	}
	public function getSerieSmallTextForm(){
		return $_POST[self::$serieSmallTextForm];
	}
	public function checkNewSerieButton(){
		if(isset($_POST[self::$newSerieButton])){
			return true;
		}
		return false;
	}
	public function checkUploadingFiles(){
		if($_FILES[self::$files]['error'][0] == 0){
			return true;
		}
		return false;
	}
	public function getTheFiles(){
		if(isset($_FILES[self::$files])){
			return $_FILES[self::$files];
		}
	}
	public function addNewSerieHTML(){;
		$HTML = "
					<form method='post' enctype='multipart/form-data'>
						<input id='files' name='".self::$files.'[]'."' type='file' multiple>
						</br>
						Serie Name: <input type='text' name='".self::$serieNameForm."'/>
						Titel: <input type='text' name='".self::$serieTitelForm."'/>
						Text: <input type='text' name='".self::$serieTextForm."'/>
						Small Text: <input type='text' name='".self::$serieSmallTextForm."'/>
						<input type='submit' name='".self::$newSerieButton."' value='Ny Serie'>
						</br>
						";
		$HTML .= $this->tagView->getTagHTMLForForm();
        $HTML .= "</br>";
        $HTML .= $this->cropView->getThumbnailSizeFormHTMLForNew();
		$HTML .= "<br/>";
		$HTML .= $this->cropView->getCropFormPart();
		$HTML .="			</form>
						<output id='list'></output>
				";
		return $HTML;
	}
}
