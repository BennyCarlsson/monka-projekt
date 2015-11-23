<?php
require_once "DB.php";
require_once 'serieObject.php';
require_once 'imageObject.php';

Class DAL{
	private $db;
		
	public function __construct(){
		$this->db = new DB();
	}
	
	public function addNewSerieToDatabase($name,$titel,$text,$smallText, $mapName,$isVimeoVideo,$position
											,$visibility,$thumbnailSize){
												
		$mysqli = $this->db->getDBConnection();
		$sql = "CALL addSerie(?,?,?,?,?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("sssssiiii",
			$name,$text,$titel,$smallText,$mapName,$isVimeoVideo,$position,$visibility,$thumbnailSize) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		$mysqli->close();
		$arr = $result->fetch_array(MYSQL_ASSOC);
		return $arr['insertedID'];
	}
	public function getAllSeries(){
		$mysqli = $this->db->getDBConnection();
		$sql = "CALL getAllSeries()";
		if(($result = $mysqli->query($sql)) === FALSE){
			throw new Exception("'$sql' failed " . $mysqli->error);
		}
		$mysqli->close();
		$ret = array();
		while($obj = $result->fetch_object()){
			$ret[] = new SerieObject($obj->SerieId,$obj->Name,$obj->Titel,$obj->Text,$obj->SmallText
			,$obj->MapName,$obj->IsVimeoVideo,$obj->Position,$obj->Visibility,$obj->ThumbnailSize);
		}
		return $ret;
	}
	public function getSpecificSerie($serieId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getSpecificSerie(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("i",$serieId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		$obj = $result->fetch_object();
		$serie = new SerieObject($obj->SerieId,$obj->Name,$obj->Titel,$obj->Text,$obj->SmallText
			,$obj->MapName,$obj->IsVimeoVideo,$obj->Position,$obj->Visibility,$obj->ThumbnailSize);
		$mysqli->close();
		return $serie;
	}
	public function getMapNameOnSerieId($serieId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getMapNameOnSerieId(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("i",$serieId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		$obj = $result->fetch_object();
		$mysqli->close();
		return $obj->MapName;
	}
	public function editSerie($serieId,$newTitle,$newText,$newSmallText,
											$newVisibility,$newThumbnailSize){
		$mysqli = $this->db->getDBConnection();
		$sql = "CALL editSerie(?,?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("isssii",
			$serieId,$newTitle,$newText,$newSmallText,$newVisibility,$newThumbnailSize) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();							
	}
	public function updateSeriePosition($serieId, $position){
		$mysqli = $this->db->getDBConnection();
		$sql = "CALL updateSeriePosition(?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("ii",
			$serieId,$position) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	public function deleteSerieOnId($serieId){
		$mysqli = $this->db->getDBConnection();
		$sql = "CALL deleteSerieOnId(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("i",$serieId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}

    //returns 0 if no tag
	public function getTagIdOnNameOrCreateNewTag($tagName){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getTagOnName(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("s",$tagName) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		if($result->num_rows >= 1){
            $obj = $result->fetch_object();
			$mysqli->close();
			return $obj->TagId;
		}else{
            $mysqli->close();
            return 0;
        }
	}
	public function createNewTagName($tagName){
		$mysqli = $this->db->getDBConnection();
		$sql = "CALL createNewTag(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("s",$tagName) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		$mysqli->close();
		$arr = $result->fetch_array(MYSQL_ASSOC);
		return $arr['insertedID'];
	}
	public function getAllTags(){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL getAllTags()";
        if(($result = $mysqli->query($sql)) === FALSE){
            throw new Exception("'$sql' failed " . $mysqli->error);
        }
        $mysqli->close();
        $ret = array();
        while($obj = $result->fetch_object()){
            $ret[] = new TagObject($obj->TagId,$obj->TagName);
        }
        return $ret;
    }
    public function getTagsSpecificForSerie($serieID){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL getTagsSpecificForSerie(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("i",$serieID) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $result = $stmt->get_result();
        $ret = array();
        while($obj = $result->fetch_object()){
            $ret[] = new TagObject($obj->TagId,$obj->TagName);
        }
        $mysqli->close();
        return $ret;
    }
    public function addSerieAndTagRelation($serieId,$tagId){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL addSerieAndTagRelation(?,?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("ii", $serieId,$tagId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $mysqli->close();
    }
    public function deleteTagOnId($tagId){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL deleteTag(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("i",$tagId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $mysqli->close();
    }
    public function deleteTagSerieRelation($serieId,$tagId){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL deleteTagAndSerieRelation(?,?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("ii",$serieId,$tagId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $mysqli->close();
    }
    public function addImage($serieId,$path,$position){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL addImage(?,?,?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("isi",$serieId,$path,$position) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $mysqli->close();
    }
    public function removeImageOnPath($path){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL removeImageOnPath(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("s",$path) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $mysqli->close();
    }
    public function fixImgPosition($serieId){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL getImageIdOnSerieId(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("i",$serieId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $result = $stmt->get_result();
        $imageIdArray = array();
        while($obj = $result->fetch_object()){
            $imageIdArray[] = $obj->ImageId;
        }
        $mysqli->close();
        for($i = 0; $i < COUNT($imageIdArray);$i++){
            $this->editImagePosition($imageIdArray[$i],$i+1);
        }
    }
    public function editImagePosition($imageId,$position){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL editImagePositionOnImageId(?,?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("ii",$imageId,$position) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $mysqli->close();
    }
    public function getImageCountOnSerieId($serieId){
        $mysqli = $this->db->getDbConnection();
        $sql = "CALL getCountImagesForSerie(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("i",$serieId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $result = $stmt->get_result();
        $obj = $result->fetch_object();
        $mysqli->close();
        return $obj->img_count;
    }

    public function getImagesOnSerieId($serieId){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL getImagesOnSerieId(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("i",$serieId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $result = $stmt->get_result();
        $ret = array();
        while($obj = $result->fetch_object()){
            $ret[] = new ImageObject($obj->ImageId,$obj->SerieId,$obj->Src,$obj->Position);
        }
        $mysqli->close();

        return $ret;
    }

    public function addVimeoThumbnailToDatabase($vimeoSrc,$serieId){
        $mysqli = $this->db->getDBConnection();
        $sql = "CALL addVimeoThumbnail(?,?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("is", $serieId,$vimeoSrc) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $mysqli->close();
    }
    public function getVimeoSrcOnSerieId($serieId){
        $mysqli = $this->db->getDbConnection();
        $sql = "CALL getVimeoSrcOnSerieId(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("i",$serieId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $result = $stmt->get_result();
        $obj = $result->fetch_object();
        $mysqli->close();
        return $obj->VimeoSrc;
    }
    public function vimeoThumbnailExistOnSerieId($serieId){
        $mysqli = $this->db->getDbConnection();
        $sql = "CALL getVimeoSrcOnSerieId(?)";
        $stmt = $mysqli->prepare($sql);
        if($stmt === FALSE){
            throw new Exception("prepare of $sql failed" . $this->mysqli->error);
        }
        if($stmt->bind_param("i",$serieId) === FALSE){
            throw new  Exception("bind_param of $sql failed " . $stmt->error);
        }
        if($stmt->execute() === FALSE){
            throw new Exception("execute of $sql failed " . $stmt->error);
        }
        $result = $stmt->get_result();
        if(mysql_fetch_array($result) !== false){
            echo "true";
            return true;
        }
        echo "false";
        return false;
    }
}





























