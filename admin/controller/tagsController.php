<?php
require_once 'view/tagView.php';
require_once 'model/tagsModel.php';
Class TagsController{
    private $tagView;
    private $tagsModel;

    public function __construct(){
        $this->tagView = new TagView();
        $this->tagsModel = new TagsModel();
    }
    public function tagsNewSerie($serieId){
        $newTags = $this->tagView->getTags();
        $this->tagsModel->onNewSerie($newTags,$serieId);
    }
    public function ifDeletingTag(){
        if($this->tagView->checkDeletingTag()){
            $tagId = $this->tagView->getTagIdToDelete();
            $this->tagsModel->deleteTag($tagId);
        }
    }
    public function ifEditTags($serieId){
        $tags = $this->tagView->getEditTags();
        $originalTags = $this->tagView->getOriginalEditTags();
        $this->tagsModel->editTags($serieId,$tags,$originalTags);
    }
}