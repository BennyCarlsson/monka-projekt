<?php
require_once 'DAL.php';
Class UploadModel{
	/*TODO: 
	 * ALOT
	 * Rename
	 * remove åäö etc
	 * check if name already exists
	 * add to a serie
	 * remove/delete image
	 * decide aloud formats png,jpg,PNG,JPEG, mp3 etc..
	 * decide max size current 5gb
	 * support wmv?
	 */
    private $DAL;
	private $valid_formats = array("jpg","jpeg", "png", "gif", "bmp", "wmv","mp4");
	private $max_file_size = 5000000000;//max 5gb

    public function __construct(){
        $this->DAL = new DAL();
    }

	//just uploads to the map "uploads" probably won't be needed later
	public function uploadFilesToNewSerie($files,$folderName,$serieId){
		$path = "gallery/".$folderName."/";
		$this->uploadImages($files, $path,$serieId);
	}
	public function uploadFileForThumbnail($file,$folderName){
		$path = "gallery/".$folderName."/thumbnail/";
		$this->uploadOriginalForThumbnailImage($file,$path);
		return $path."original.".pathinfo($file["name"], PATHINFO_EXTENSION);
	}
	private function uploadOriginalForThumbnailImage($file, $path){
		$name = $file["name"];
	  	if ($file['error'] == 4) {
	    	echo"error";
	    }	       
	    if ($file['error'] == 0) {	           
	         if ($file['size'] > $this->max_file_size) {
				echo"to large ";
				var_dump($file['size']);
	        }
			else if( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $this->valid_formats) ){
				echo"not valid";
			}
	        else{ // No error found! Move uploaded files
				if(pathinfo($name, PATHINFO_EXTENSION) == "mp4"){
                    move_uploaded_file($file["tmp_name"], $path."thumbnail.".pathinfo($name, PATHINFO_EXTENSION));
                }else{
	                move_uploaded_file($file["tmp_name"], $path."original.".pathinfo($name, PATHINFO_EXTENSION));
                }
            }
	    }
	}
	public function uploadFilesToSerie($files, $mapName,$serieId){
		$path = "gallery/".$mapName."/";
		$this->uploadImages($files,$path,$serieId);
	}
	private function uploadImages($files, $path,$serieId){
        $count = $this->DAL->getImageCountOnSerieId($serieId) + 1;
		foreach ($files['name'] as $f => $name) {   
		    if ($files['error'][$f] == 4) {
		        continue; // Skip file if any error found
		    }	       
		    if ($files['error'][$f] == 0) {	           
		         if ($files['size'][$f] > $this->max_file_size) {
					echo"to large file";
		            continue; // Skip large files
		        }
				else if( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $this->valid_formats) ){
					echo"not valid format";
					continue; // Skip invalid file formats
				}
		        else{ // No error found! Move uploaded files
                    $newName =  $path.time().$count.".".pathinfo($name, PATHINFO_EXTENSION);
		            move_uploaded_file($files["tmp_name"][$f], $newName);
                    $this->DAL->addImage($serieId,$newName,$count);
		        }
		    }
            $count++;
		}
	}
	public function deleteImageFromSerie($imageDir,$serieId){
		if(file_exists($imageDir)){
			unlink($imageDir);
            $this->DAL->removeImageOnPath($imageDir);
            $this->DAL->fixImgPosition($serieId);
		}
	}
	public function editOrCreateNewVimeoThumbnail($serieId,$vimeoSrc){
        if($this->DAL->vimeoThumbnailExistOnSerieId($serieId)){
            //$this->DAL->editVimeoThumbnailToDatabase($serieId,$vimeoSrc);
        }else{
            $this->DAL->addVimeoThumbnailToDatabase($vimeoSrc,$serieId);
        }
    }
}
