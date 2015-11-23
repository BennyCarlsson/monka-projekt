<?php

Class CropImagesModel{
	/*
	 * TODO: 
	 * make sure it works for all types png,jpg,jpeg, gifs etc
	 * make sure to delete all other files thumbnail.png / thumbnail.jpg
	 * rename thumbnails and sort them
	 * thumbnails for videos?
	 */
	public function cropImage ($x,$y,$w,$h,$fileName,$folderName){
        if(pathinfo($fileName, PATHINFO_EXTENSION) == "mp4"){
            //if mp4 format already named original.mp4 to thumbnail.mp4 since in uploadModel.php sinse original is not needed
            $this->deleteThumbnailAndOriginal($folderName,"mp4");
        }else{
            // Get dimensions of the original image
            list($current_width, $current_height) = getimagesize($fileName);
            // The x and y coordinates on the original image where we
            // will begin cropping the image
            $left = $x;
            $top = $y;

            // This will be the final size of the image (e.g. how many pixels
            // left and down we will be going
            $crop_width = $w;
            $crop_height = $h;

            if(pathinfo($fileName, PATHINFO_EXTENSION) == "jpg"){
                // Resample the image
                $canvas = imagecreatetruecolor($crop_width, $crop_height);
                $current_image = imagecreatefromjpeg($fileName);
                imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
                imagejpeg($canvas, "gallery/".$folderName."/thumbnail/thumbnail.jpg", 100);
                $this->deleteThumbnailAndOriginal($folderName,"jpg");
            }else if(pathinfo($fileName, PATHINFO_EXTENSION) == "png"){
                // Resample the image
                $canvas = imagecreatetruecolor($crop_width, $crop_height);
                $current_image = imagecreatefrompng($fileName);
                imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
                imagepng($canvas, "gallery/".$folderName."/thumbnail/thumbnail.png"); //quality??
                $this->deleteThumbnailAndOriginal($folderName,"png");
            }else if(pathinfo($fileName, PATHINFO_EXTENSION) == "jpeg"){
                // Resample the image
                $canvas = imagecreatetruecolor($crop_width, $crop_height);
                $current_image = imagecreatefromjpeg($fileName);
                imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
                imagejpeg($canvas, "gallery/".$folderName."/thumbnail/thumbnail.jpeg",100); //quality??
                $this->deleteThumbnailAndOriginal($folderName,"jpeg");
            }else{
                //TODO error handling
            }
        }
	}
    private function deleteThumbnailAndOriginal($folderName,$exception){
        if($exception != "jpg"){
            $this->deleteExistingThumbanil($folderName,"jpg");
            $this->deleteOriginalforThumbnail($folderName,"jpg");
        }
        if($exception != "jpeg"){
            $this->deleteExistingThumbanil($folderName,"jpeg");
            $this->deleteOriginalforThumbnail($folderName,"jpeg");

        }
        if($exception != "png"){
            $this->deleteExistingThumbanil($folderName,"png");
            $this->deleteOriginalforThumbnail($folderName,"png");
        }
        if($exception != "mp4"){
            $this->deleteExistingThumbanil($folderName,"mp4");
        }
    }
	private function deleteExistingThumbanil($folderName,$extension){
		if(file_exists("gallery/".$folderName."/thumbnail/thumbnail.".$extension)){
			unlink("gallery/".$folderName."/thumbnail/thumbnail.".$extension);
		}
	}
	private function deleteOriginalforThumbnail($folderName,$extension){
		if(file_exists("gallery/".$folderName."/thumbnail/original.".$extension)){
			unlink("gallery/".$folderName."/thumbnail/original.".$extension);
		}
	}
}
