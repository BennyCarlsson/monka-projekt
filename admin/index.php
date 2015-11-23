<?php
session_start();
require_once "controller.php";
$controller = new Controller();
$html = $controller->getHTML();
echo $html;
