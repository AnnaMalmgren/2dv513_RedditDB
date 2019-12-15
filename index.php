<?php

require_once("model/DBSeeder.php");
require_once("model/DBConnection.php");
require_once("model/File.php");
require_once("controller/MainDBController.php");
require_once("view/TimeDisplay.php");

$fileSmall = "RC_2007-10.bz2";
$fileMedium = "RC_2011-07.bz2";
$fileLarge = "RC_2012-12.bz2";


$connection = new \Model\DBConnection();
$mysqli = new \Model\DBSeeder($connection);
$file = new \Model\File($fileLarge);
$timer = new \View\TimeDisplay();
$controller = new \Controller\MainDBController($mysqli, $file, $timer);

try {

    $controller->populateDB();
    
} catch (\Exception $e) {
    echo $e->getMessage();
}
