<?php
require_once 'view/cropView.php';
require_once 'view/editSerieView.php';
require_once 'model/cropImagesModel.php';
require_once 'model/uploadModel.php';

Class ThumbnailController{
	private $cropView;
	private $cropImagesModel;
	private $uploadModel;
    private $editSerieView;
	
	public function __construct(){
		$this->cropView = new CropView();
		$this->cropImagesModel = new CropImagesModel();	
		$this->uploadModel = new UploadModel();
        $this->editSerieView = new EditSerieView();
	}
	
	public function cropThumbnailForNewSerie($folderName){
		$file = $this->cropView->getThumbnailFile();
		if(!empty($file['name']) || $file['name'] = ""){
			$x = $this->cropView->getXCropValue();
			$y = $this->cropView->getYCropValue();
			$w = $this->cropView->getWCropValue();
			$h = $this->cropView->getHCropValue();
			$fileName = $this->uploadModel->uploadFileForThumbnail($file,$folderName);
			$this->cropImagesModel->cropImage($x,$y,$w,$h,$fileName,$folderName);
		}else{
            $x = $this->cropView->getXCropValue();
            $y = $this->cropView->getYCropValue();
            $w = $this->cropView->getWCropValue();
            $h = $this->cropView->getHCropValue();
            if($x != "" || $y != "" || $w != "" || $h != ""){
                $path = $this->editSerieView->getCurrentThumbnailOriginalPath($folderName);
                $this->cropImagesModel->cropImage($x,$y,$w,$h,$path,$folderName);
            }
        }
	}
    public function checkIfThumbnailForNewSerieIsVimeoVideo(){
        return $this->cropView->checkIfThumbnailIsVimeoVideo();
    }
    public function getVimeoSrcForThumbnail(){
        return $this->cropView->getVimeoLinkForThumbnail();
    }
}
