<?php

require_once "DAL.php";

Class GetImagesModel{
	/*TODO
	 * only supports jpg,png,jpeg,JPG,PNG
	 */
    private $DAL;
    public function __construct(){
        $this->DAL = new DAL();
    }
	public function getAllImagesInFolder($folderName){
		$directory = "gallery/".$folderName."/";
		//$directory = "../myImages/clocks/";
		$fileNameArray = [];
		$images = glob($directory . "*.{jpg,png,jpeg,JPG,PNG}",GLOB_BRACE);
		
		foreach($images as $image)
		{
		  array_push($fileNameArray,$image);
		}
		return $fileNameArray;
	}

    public function getImageObjectFromDatabaseOnSerieId($serieId){
        $imagesObject =  $this->DAL->getImagesOnSerieId($serieId);

        return $imagesObject;
    }
}
