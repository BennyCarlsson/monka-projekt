<?php

Class SerieObject{
	public $serieId;
	public $name;
	public $titel;
	public $text;
	public $smallText;
	public $mapName;
	public $position;
	public $visibility;
	public $thumbnailSize;
    public $isVimeoVideo;

    public function __construct($serieId,$name,$titel,$text,$smallText,$mapName,$isVimeoVideo,$position
        ,$visibility,$thumbnailSize){
        $this->serieId = $serieId;
        $this->name = $name;
        $this->titel = $titel;
        $this->text = $text;
        $this->smallText = $smallText;
        $this->mapName = $mapName;
        $this->position = $position;
        $this->visibility = $visibility;
        $this->thumbnailSize = $thumbnailSize;
        $this->isVimeoVideo = $isVimeoVideo;
    }
}
