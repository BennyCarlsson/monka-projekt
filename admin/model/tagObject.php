<?php

Class TagObject{
    public $tagId;
    public $tagName;

    public function __construct($tagId, $tagName){
        $this->tagId = $tagId;
        $this->tagName = $tagName;
    }
}