<?php
require_once "DAL.php";
	
Class GetSeries{
	private $DAL;
	
	public function __construct(){
		$this->DAL = new DAL();
	}
	public function getAllSeries(){
		return $this->DAL->getAllSeries();
	}
	public function getSpecificSerie($serieId){
		return $this->DAL->getSpecificSerie($serieId);
	}
	public function getMapNameOnSerieId($serieId){
		return $this->DAL->getMapNameOnSerieId($serieId);
	}
    public function getVimeoSrcOnSerieId($serieId){
        return $this->DAL->getVimeoSrcOnSerieId($serieId);
    }
}
