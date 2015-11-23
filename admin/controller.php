<?php
require_once "view/loginFormView.php";
require_once 'view/adminPage.php';
require_once 'view/standardHTML.php';
require_once 'view/newSerieView.php';
require_once 'view/cropView.php';
require_once 'model/uploadModel.php';
require_once "model/authenticationModel.php";
require_once 'model/addNewSerieModel.php';
require_once 'model/getSeries.php';
require_once 'model/editSerieModel.php';
require_once 'controller/editSerieController.php';
require_once 'controller/thumbnailController.php';
require_once 'controller/tagsController.php';

Class Controller{
	private $authenticationModel;
	private $loginFormView;
	private $adminPage;
	private $standardHTML;
	private $uploadModel;
	private $newSerieView;
	private $addNewSerieModel;
	private $getSeries;
	private $editSerieController;
	private $editSerieModel;
	private $thumbnailController;
	private $cropView;
    private $tagsController;

	public function __construct(){
		$this->authenticationModel = new AuthenticationModel();
		$this->loginFormView = new LoginFormView();
		$this->adminPage = new AdminPage();
		$this->standardHTML = new StandardHTML();
		$this->uploadModel = new UploadModel();
		$this->newSerieView = new NewSerieView();
		$this->addNewSerieModel = new AddNewSerieModel();
		$this->getSeries = new GetSeries();
		$this->editSerieController = new EditSerieController();
		$this->editSerieModel = new EditSerieModel();
		$this->thumbnailController = new ThumbnailController();
	    $this->cropView = new CropView();
        $this->tagsController = new TagsController();
    }
	
	public function getHTML(){
		$HTML = "";
		$HTML .= $this->standardHTML->getHeadHTML();
		if($this->logOut()){
			$HTML .= $this->getLoginFormHTML();
		}
		else if($this->checkIfLoggedIn() || $this->tryLogin()){
			$HTML .= $this->getLoggedInHTML();
		}
		else{
			$HTML .= $this->getLoginFormHTML();
		}
		return $HTML;
	}
	private function checkIfLoggedIn(){
		if($this->authenticationModel->checkIfLoggedIn()){
			return true;
		}
		return false;
	}
	private function tryLogin(){
		if($this->loginFormView->checkLoginButton()){
			$username = $this->loginFormView->getUsername();
			$password = $this->loginFormView->getPassword();
			if($this->authenticationModel->compareUsernameAndPassword($username,$password)){
				return true;	
			}	
		}
		return false;
	}
	private function logOut(){
		if($this->checkIfLoggedIn() && $this->adminPage->checkLogOutButton()){
			$this->authenticationModel->logOut();
			return true;
		}
		return false;
	}
	private function getLoginFormHTML(){
		$message = $this->authenticationModel->messageForLoginForm;
		$loginFormHTML = $this->loginFormView->getLoginFormHTML($message);
		$loginFormHTML .= $this->standardHTML->getCloserHTML();
		return $loginFormHTML;
	}
	private function getLoggedInHTML(){
		if($this->ifEditSerie()){
			$serieId = $this->adminPage->getEditSerieId();
			$HTML = $this->editSerieController->getEditControllerHTML($serieId);
			$HTML .= $this->standardHTML->getCloserEditSerieHTML();
		}else{
			$this->tagsController->ifDeletingTag();
            $this->ifNewSerie();
            $this->ifNewPositionButton();
			$HTML = $this->adminPage->getAdminPageHTML();
			$HTML .= $this->newSerieHTML();
			$HTML .= $this->getAllSeries();
			$HTML .= $this->standardHTML->getCloserHTML();
		}
		return $HTML;
	}
	private function getAllSeries(){
		$series = $this->getSeries->getAllSeries();
		return $this->adminPage->listAllSeriesHTML($series);
	}
    private function newSerieHTML(){
        $HTML = $this->newSerieView->addNewSerieHTML();
        return $HTML;
    }
	private function ifNewSerie(){
		if($this->newSerieView->checkNewSerieButton()){
			$name = $this->newSerieView->getSerieNameForm();
			$titel = $this->newSerieView->getSerieTitelForm();
			$text = $this->newSerieView->getSerieTextForm();
			$smallText = $this->newSerieView->getSerieSmallTextForm();
            $thumbnailSize = $this->cropView->getNewThumbnailSize();
            $isVimeoVideo = $this->cropView->checkIfThumbnailIsVimeoVideo();
			$folderName = $this->addNewSerieModel->addNewSerie($name,$titel,$text,$smallText,$isVimeoVideo,$thumbnailSize);
			$serieId = $this->addNewSerieModel->serieId;
			$this->tagsController->tagsNewSerie($serieId);
			$this->ifUploadFilesNewSerie($folderName,$serieId);
            $this->thumbnailForNewSerire($folderName,$serieId,$isVimeoVideo);
		}
	}
	private function ifUploadFilesNewSerie($folderName,$serieId){
        $files = $this->newSerieView->getTheFiles();
        $this->uploadModel->uploadFilesToNewSerie($files,$folderName,$serieId);
	}
    private function thumbnailForNewSerire($folderName,$serieId,$isVimeoVideo){
        if($isVimeoVideo){
            $vimeoSrc = $this->thumbnailController->getVimeoSrcForThumbnail();
            $this->addNewSerieModel->addVimeoThumbnailToDatabase($vimeoSrc,$serieId);
        }else{
            $this->cropThumbnailForNewSerie($folderName);
        }
    }
	private function cropThumbnailForNewSerie($folderName){
		$this->thumbnailController->cropThumbnailForNewSerie($folderName);
	}
	private function ifEditSerie(){
		return $this->adminPage->checkEditSerie();
	}
	private function ifNewPositionButton(){
		if($this->adminPage->checkNewPositionButton()){
			$newPositions = $this->adminPage->getNewPosition();
			$this->editSerieModel->updateSeriePosition($newPositions);
		}
	}
}







