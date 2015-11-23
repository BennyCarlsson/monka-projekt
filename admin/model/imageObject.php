<?php

Class ImageObject{
    public $imageId;
    public $serieId;
    public $src;
    public $position;

    public function __construct($imageId,$sereId,$src,$position){
        $this->imageId = $imageId;
        $this->serieId = $sereId;
        $this->src = $src;
        $this->position = $position;
    }
}