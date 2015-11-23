<?php
$directory = "../myImages/".$_POST["folderName"]."/";
//$directory = "../myImages/clocks/";
$fileNameArray = [];
$images = glob($directory . "*.{jpg,png,jpeg,JPG,PNG}",GLOB_BRACE);

foreach($images as $image)
{
  array_push($fileNameArray,$image);
}
echo json_encode($fileNameArray);