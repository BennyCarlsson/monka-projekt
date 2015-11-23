<?php
require_once "DAL.php";

Class AddNewSerieModel{
	private $DAL;
	private $path = 'gallery/';
	public $serieId = "asd";
	public function __construct(){
		$this->DAL = new DAL();
		$this->serieId = "dsa";
	}
	public function addNewSerie($name,$titel,$text,$smallText,$isVimeoVideo,$thumbnailSize){
		//TODO CHECKS
		// fix position, visibility
        $isVimeoVideo = $this->convertBoolToInt($isVimeoVideo);
		$folderName = $this->getFolderName($name);
		$this->createFolder($folderName);
		$position = 1;
		$visibility = true;
		$this->serieId = $this->DAL->addNewSerieToDatabase($name,$titel,$text,$smallText,$folderName,$isVimeoVideo
			,$position,$visibility,$thumbnailSize);
		return $folderName;
	}
    private function convertBoolToInt($boolean){
        if($boolean){
            return 1;
        }
        return 0;
    }
	private function getFolderName($name){
		$folderName = $this->stripFolderName($name);
		$folderName = $this->getUniqueFolderName($folderName);
		return $folderName;
	}
	private function stripFolderName($name){
		$folderName = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
		return $folderName;
	}
	private function getUniqueFolderName($name){
		$counter = 1;
		$uniqueName = true;
		$newName = $name;
		while($uniqueName){
			$counter++;
			if(file_exists($this->path.$newName)){
				$newName = $name."(".$counter.")";
			}else{$uniqueName = false;}
		}
		return $newName;
	}
	private function createFolder($folderName){
		if (!file_exists($this->path.$folderName)) {
		    if(mkdir($this->path.$folderName, 0777, true)){
				mkdir($this->path.$folderName."/thumbnail", 0777, true);
		    }else{
		    	echo "failed to create folder";
		    }
		}
	}
    public function addVimeoThumbnailToDatabase($vimeoSrc,$serieId){
        $this->DAL->addVimeoThumbnailToDatabase($vimeoSrc,$serieId);
    }
    public function editVimeoThumbnail($vimeoSrc, $serieId){

    }
}
