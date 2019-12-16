<?php

require_once("settings.php");
require_once("model/DBSeeder.php");
require_once("model/DBConnection.php");
require_once("model/File.php");
require_once("controller/MainDBController.php");
require_once("view/TimeDisplay.php");

$connection = new \Model\DBConnection();
$withConststraints = false; 
$mysqli = new \Model\DBSeeder($connection, $withConststraints);
$file = new \Model\File(getenv('SMALLFILE'));
$timer = new \View\TimeDisplay();
$controller = new \Controller\MainDBController($mysqli, $file, $timer);

try {

    $controller->populateDB();
    
} catch (\Exception $e) {
    echo $e->getMessage();
}
