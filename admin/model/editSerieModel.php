<?php
require_once 'DAL.php';

Class EditSerieModel{
	private $DAL;
	private $path = "gallery/";

	public function __construct(){
		$this->DAL = new DAL();
	}
	
	public function editSerie($serieId,$newTitle,$newText,$newSmallText,
											$newVisibility,$newThumbnailSize){
	//TODO checks same in addNewSerieModel.php
	$this->DAL->editSerie($serieId,$newTitle,$newText,$newSmallText,
						  $newVisibility,$newThumbnailSize);
	}
	
	public function updateSeriePosition($newPositions){
		foreach($newPositions as $serieId => $position){
			$this->DAL->updateSeriePosition($serieId, $position);
		}
	}
	public function deleteSerie($serieId){
		$folderName = $this->DAL->getMapNameOnSerieId($serieId);
		if(!empty($folderName) || $folderName != ""){
			$this->deleteFolderAndContent($this->path.$folderName);
		}
		$this->DAL->deleteSerieOnId($serieId);
		header("Location: index.php");
	}
	private function deleteFolderAndContent($dir){
		echo $dir.", ";
		foreach(glob($dir . '/*') as $file) { 
		    if(is_dir($file)) $this->deleteFolderAndContent($file); else unlink($file); 
	    } 
	    rmdir($dir);
	}
    public function newImagePositions($imagePosition){
        foreach($imagePosition as $imgId => $imgPos){
            if(ctype_digit($imgPos) || is_int($imgPos)){
                $this->DAL->editImagePosition($imgId,$imgPos);
            }
        }
    }
		
}
