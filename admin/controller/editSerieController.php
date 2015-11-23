<?php
require_once 'view/editSerieView.php';
require_once 'view/cropView.php';
require_once "model/authenticationModel.php";
require_once 'model/getSeries.php';
require_once 'model/uploadModel.php';
require_once 'model/editSerieModel.php';
require_once 'model/getImagesModel.php';
require_once 'thumbnailController.php';
require_once 'tagsController.php';


Class EditSerieController{
	private $authenticationModel;
	private $getSeries;
	private $editSerieView;
	private $uploadModel;
	private $editSerieModel;
	private $thumbnailController;
	private $getImagesModel;
	private $cropView;
    private $tagsController;

	public function __construct(){
		$this->authenticationModel = new AuthenticationModel();
		$this->getSeries = new GetSeries();
		$this->editSerieView = new EditSerieView();
		$this->uploadModel = new UploadModel();
		$this->editSerieModel = new EditSerieModel();
		$this->thumbnailController = new ThumbnailController();
		$this->getImagesModel = new GetImagesModel();
        $this->cropView = new CropView();
        $this->tagsController = new TagsController();
    }
	
	public function getEditControllerHTML($serieId){
		$HTML = "";
		if($this->checkIfLoggedIn()){
			$this->ifEditSerie();
			$this->ifDeleteSerie();
			$this->ifDeleteImageFromSerie($serieId);
			$HTML .= $this->editSerieHTML($serieId);
		}
		return $HTML;
	}
	private function checkIfLoggedIn(){
		if($this->authenticationModel->checkIfLoggedIn()){
			return true;
		}
		return false;
	}
	private function editSerieHTML($serieId){
		$serie = $this->getSeries->getSpecificSerie($serieId);
		$HTML = $this->editSerieView->getEditViewHTML($serie);
		//$images = $this->getImagesModel->getAllImagesInFolder($serie->mapName);
		$imageObject = $this->getImagesModel->getImageObjectFromDatabaseOnSerieId($serieId);
        $HTML .= $this->editSerieView->getImagesForSerie($imageObject);
		return $HTML;
	}
	private function ifEditSerie(){	
		if($this->editSerieView->checkEditButton()){
			$serieId = $this->editSerieView->getSerieId();
			$folderName = $this->getSeries->getMapNameOnSerieId($serieId);
			$this->ifUploadingFiles($folderName,$serieId);
			$this->editSerie($serieId);
			$this->newThumbnail($folderName,$serieId);
            $this->newTags($serieId);
            $this->editPosition();
		}
	}
    private function editPosition(){
        $imagePosition = $this->editSerieView->getImagesPosition();
        if($imagePosition != null)
        $this->editSerieModel->newImagePositions($imagePosition);
    }
	private function ifDeleteImageFromSerie($serieId){
		if($this->editSerieView->checkDeleteImageButton()){
			$imageDir = $this->editSerieView->getDeleteImageDir();
			$this->uploadModel->deleteImageFromSerie($imageDir,$serieId);
		}
	}
	private function ifUploadingFiles($folderName,$serieId){
			//if choosen files to upload
		if($this->editSerieView->checkIfUploadingFiles()){
			$files = $this->editSerieView->getNewFiles();
			$this->uploadModel->uploadFilesToSerie($files, $folderName,$serieId);
		}
	}
	private function newThumbnail($folderName,$serieId){
        if($this->thumbnailController->checkIfThumbnailForNewSerieIsVimeoVideo()){
            $vimeoLink = $this->thumbnailController->getVimeoSrcForThumbnail();
            $this->uploadModel->editOrCreateNewVimeoThumbnail($serieId);
        }else{
            $this->thumbnailController->cropThumbnailForNewSerie($folderName);
        }
	}
    private function newTags($serieId){
        $this->tagsController->ifEditTags($serieId);
    }
	private function editSerie($serieId){
		$newTitle = $this->editSerieView->getNewTitle();
		$newText = $this->editSerieView->getNewText();
		$newSmallText = $this->editSerieView->getNewSmallText();
		$newVisibility = $this->editSerieView->getNewVisibility();
		$newThumbnailSize = $this->cropView->getNewThumbnailSize();
		$this->editSerieModel->editSerie($serieId,$newTitle,$newText,$newSmallText,
		$newVisibility,$newThumbnailSize);
	}
	private function ifDeleteSerie(){
		if($this->editSerieView->checkDeleteButton()){
			$serieId = $this->editSerieView->getSerieId();
			$this->editSerieModel->deleteSerie($serieId);
		}
	}
}





















