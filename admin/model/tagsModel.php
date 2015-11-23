<?php
require_once "DAL.php";
require_once "tagObject.php";
/*
 * TODO error handling
 */
Class TagsModel{
	private $DAL;
	public function __construct(){
		$this->DAL = new DAL();
	}
	public function getAllTags(){
        return $this->DAL->getAllTags();
    }
    public function getTagForSerie($serieId){
        return $this->DAL->getTagsSpecificForSerie($serieId);
    }
	public function onNewSerie($newTags,$serieId){
        $newTags = trim($newTags);
        $tags = explode(",",$newTags);
        foreach($tags as $tag){
            if(!empty($tag) && $tag != "" && $tag != " "){
                $tagName = trim($tag);
                $this->addTagAndTagSerieRelation($serieId,$tagName);
            }
        }
	}
    public function deleteTag($tagId){
        $this->DAL->deleteTagOnId($tagId);
    }
    public function editTags($serieId,$tags,$originalTags){
        if($tags != $originalTags && trim($tags) != $originalTags){
            $newTags = trim($tags);
            $arrNewTags = explode(",",$newTags);
            $arrOriginalTags = explode(",",$originalTags);
            $this->newTagsInEdit($serieId,$arrNewTags,$arrOriginalTags);

            foreach($arrOriginalTags as $originalTag){
                if(!empty($originalTag) && $originalTag != "" && $originalTag != " "){
                    if(!in_array($originalTag,$arrNewTags)){
                        $tagId = $this->DAL->getTagIdOnNameOrCreateNewTag($originalTag);
                        if($tagId != 0)
                        $this->DAL->deleteTagSerieRelation($serieId,$tagId);
                    }
                }
            }
        }
    }
    private function newTagsInEdit($serieId,$arrNewTags,$arrOriginalTags){
        foreach($arrNewTags as $tag){
            $tag = trim($tag);
            if(!empty($tag) && $tag != "" && $tag != " "){
                if(!in_array($tag,$arrOriginalTags)){
                    $this->addTagAndTagSerieRelation($serieId,$tag);
                }
            }
        }
    }
    //creates new tag is needed then creates tag and serie relation
    private function addTagAndTagSerieRelation($serieId,$tagName){
        $tagId = $this->DAL->getTagIdOnNameOrCreateNewTag($tagName);
        if($tagId == 0){
            if(count($tagName) < 100)
                $tagId = $this->DAL->createNewTagName($tagName);
        }
        $this->DAL->addSerieAndTagRelation($serieId,$tagId);
    }

}
