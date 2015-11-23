<?php
require_once "model/getSeries.php";
Class AdminPage{
    private static $logout = 'logout';
    private static $editSerie = "editSerie";
    private static $newPosition = "newPosition";
    private static $newPositionButton = "newPositionButton";
    private $tagView;
    private $getSeriesModel;

    public function __construct(){
        $this->tagView = new TagView();
        $this->getSeriesModel = new GetSeries();
    }
	
	public function checkLogOutButton(){
		if(isset($_GET[self::$logout])){
			return TRUE;
		}
		return FALSE;
	}
	public function getLogoutHTML(){
		$HTML = "<a id='logoutBtn' href='index.php?".self::$logout."'>Logga ut</a>";
		return $HTML;
	}
	
	public function getAdminPageHTML(){
		$HTML = $this->getLogoutHTML();
        $HTML .= $this->tagView->getTagForDelete();
		return $HTML;
	}
	
	public function checkEditSerie(){
		 if(isset($_GET[self::$editSerie])){
		 	return true;
		 }
		 return false;
	}
	public function getEditSerieId(){
		return $_GET[self::$editSerie];
	}
	public function checkNewPositionButton(){
		if(isset($_POST[self::$newPositionButton])){
			return true;
		}
		return false;
	}
	public function getNewPosition(){
		return $_POST[self::$newPosition];
	}
    /*
     <div class="item w1">
         <input type="hidden" value="1" name="'.self::$newPosition.'"'.[1].'"/>
         <a><iframe class="image-1" src="https://player.vimeo.com/video/136312133?autoplay=1&loop=1&title=1&byline=1"
          frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></a>
     </div>
     <div class="item w1">
         <input type="hidden" value="1" name="'.self::$newPosition.'"'.[1].'"/>
         <a><iframe class="image-1" src="https://player.vimeo.com/video/137249858?autoplay=1&loop=1&color=c9ff23"
         frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></a>
     </div>
      <div class="item w1">
         <input type="hidden" value="2" name="'.self::$newPosition.'"'.[1].'"/>
         <a><img class="image-1" src="/monka/myImages/cordon_bleu/cordon_bleu_kanin.jpg" alt=""></a>
     </div>
     <div class="item w1">
         <input type="hidden" value="1" name="'.self::$newPosition.'"'.[1].'"/>
         <a><video class="image-1" autoplay muted loop><source src="gallery/asd(2)/thumbnail/thumbnail.mp4" type="video/mp4"></a>
     </div>
 */
    public function listAllSeriesHTML($series){
        $HTML = '
              <p><button id="toggle-button" class="button">Toggle stamped</button></p>
              <form method="post">
				<div id="content">
    				<div id="thumbNailsFlow">
                    <div id="container">
                	<div class="grid-sizer"></div>
                	<div class="item w1">
                        <input type="hidden" value="1" name="'.self::$newPosition.'"'.[1].'"/>
                        <a><img class="image-1" src="/monka/myImages/cordon_bleu/cordon_bleu_kanin.jpg" alt=""></a>
					</div>
					';
        foreach ($series as $serie) {
            $widthClass = $this->getWidthClass($serie->thumbnailSize);
            $imgOrVideoTag = $this->getImageOrVideoTag($serie->serieId,$serie->mapName, $serie->thumbnailSize,$serie->isVimeoVideo);
            $HTML .= "
					<div class='item $widthClass'>
					<a class='editSerieATag ' href='index.php?".self::$editSerie."=$serie->serieId'>Edit</a>
					<input type='hidden' value='$serie->position' name='".self::$newPosition."[$serie->serieId]'/>
					<a>$imgOrVideoTag</a></div>
					";
        }
        $HTML .= "
                    </div>
					</div>
				    </div>
					<input type='submit' value='SAVE' name='".self::$newPositionButton."'>
					</form>";
        return $HTML;
    }
    private function getImageOrVideoTag($serieId,$mapName, $thumbnailSize, $isVimeoVideo){
        if($isVimeoVideo == 1){
            return $this->getVimeoTag($serieId,$thumbnailSize);
        }else{
            return $this->getImageorMp4Tag($mapName, $thumbnailSize);
        }
    }
    private function getVimeoTag($serieId,$thumbnailSize){
        $iframeTag = $this->getSeriesModel->getVimeoSrcOnSerieId($serieId);
        $secondPartOfIframe = substr($iframeTag,7);
        return "<iframe class='image-$thumbnailSize' $secondPartOfIframe";
    }
    private function getImageorMp4Tag($mapName, $thumbnailSize){
        $filePath = "gallery/$mapName/thumbnail/thumbnail.";
        if(file_exists($filePath."jpg")){
            return "<img class='image-$thumbnailSize' src='gallery/$mapName/thumbnail/thumbnail.jpg' alt=''>";
        }else if(file_exists($filePath."png")){
            return "<img class='image-$thumbnailSize' src='gallery/$mapName/thumbnail/thumbnail.png' alt=''>";
        }else if(file_exists($filePath."jpeg")){
            return "<img class='image-$thumbnailSize' src='gallery/$mapName/thumbnail/thumbnail.jpeg' alt=''>";
        }else if(file_exists($filePath."mp4")){
            return "<video class='image-$thumbnailSize'
                    autoplay muted loop><source src='gallery/$mapName/thumbnail/thumbnail.mp4'' type='video/mp4'>";
        }else{
            return "<img class='image-1' src='/monka/myImages/cordon_bleu/cordon_bleu_kanin.jpg' alt=''>";
        }
    }
	private function getWidthClass($size){
		switch ($size) {
			case 1:
				return "w1";
				break;
			case 2:
				return "w1";
				break;
			case 3:
				return "w2";
				break;

			default:
				return "w1";
				break;
		}
	}

}



































