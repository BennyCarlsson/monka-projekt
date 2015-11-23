<?php

Class StandardHTML{
	public function getHeadHTML(){
		$HTML="<!DOCTYPE html>
				<html lang='en'>
				<head>
				  <meta charset='utf-8'>
				  <link rel='stylesheet' href='css/jquery.Jcrop.css' type='text/css' />
				  <link rel='stylesheet' href='css/style.css' type='text/css' />
				</head>
				<body>
				";
		return $HTML;
	}
	
	public function getCloserHTML(){
        /*TODO FIND OUT DIFFERNE FROM JQUERYUI .draggable*/
		$HTML='
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
            <script src="http://packery.metafizzy.co/packery.pkgd.js"></script>
		    <script src="js/draggabilly.pkgd.min.js"></script>
            <script src="js/packery.pkgd.min.js"></script>
			<script src="js/packeryStarter.js"></script>
			<script src="js/jquery.Jcrop.min.js"></script>
			<script src="js/JcropStarter.js"></script>
			<script src="js/myJavascript.js"></script>
			';
	    $HTML .= '</body>';
		return $HTML;
	}
	public function getCloserEditSerieHTML(){
		$HTML='
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script src="js/jquery.Jcrop.min.js"></script>
			<script src="js/JcropStarter.js"></script>
			<script src="js/myJavascript.js"></script>
			';
		$HTML .= '</body>';
		return $HTML;
	}
}
