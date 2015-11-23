<?php
require_once "model/tagsModel.php";
Class TagView{
    private static $newTags = "newTags";
    private static $checkedTags = "checkedTags";
    private $tagsModel;
	public function __construct(){
        $this->tagsModel = new TagsModel();
    }
    public function getTags(){
		if(isset($_POST[self::$newTags]))
		return $_POST[self::$newTags];
	}

	public function getTagHTMLForForm(){
        $tags = $this->tagsModel->getAllTags();
		$HTML = "Lägg till taggar (seperera med ,) ex. klockar,blå,djur
                <input type='text' name='".self::$newTags."' id='tagInput'>
		Taggar:";
		foreach($tags as $tag){
            $HTML .= "<a onclick='addTagToInput(\"$tag->tagName\")'> +".$tag->tagName." </a>";
        }
        return $HTML;
	}
    public function getEditTags(){
        if(isset($_POST['editTags']))
        return $_POST['editTags'];
    }
    public function getOriginalEditTags(){
        if(isset($_POST['originalEditTags']))
            return $_POST['originalEditTags'];
    }
    public function getTagForEditViewForm($serieId){
        $tags = $this->tagsModel->getTagForSerie($serieId);
        $HTML = "Taggar:";
        $tagsForInput = "";
        for($i = 0; $i < count($tags); $i++){
            if($i == 0){
                $tagsForInput .= $tags[$i]->tagName;
            }else {
                $tagsForInput .= ",".$tags[$i]->tagName;
            }
        }
        $HTML .= "<input type='hidden' value='$tagsForInput' name='originalEditTags'>
                   <input type='text' value='$tagsForInput' name='editTags'> ";

        return $HTML;
    }

    public function checkDeletingTag(){
        if(isset($_POST['deleteTagButton'])){
            return true;
        }
        return false;
    }
    public function getTagIdToDelete(){
        if(isset($_POST['deleteTagId'])){
            return $_POST['deleteTagId'];
        }
    }
    public function getTagForDelete(){
        $tags = $this->tagsModel->getAllTags();
        $HTML = "<div id='deleteTagForm'>Delete Tagg";
        foreach($tags as $tag){
            $HTML .=
                    "<form method='post'>
                        <input type='hidden' value='$tag->tagId' name='deleteTagId'>
                        <input type='submit' value='X' name='deleteTagButton' onclick='return delete_tag_confirm()' />
                        $tag->tagName
                     </form>";
        }
        $HTML .="</div></br>";
        return $HTML;
    }
}
