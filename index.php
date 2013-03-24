<?php
session_start();

use MedWave\System\Model as models;

require 'system/ekoed/autoloader/autoloader.php';
$autoloader = new autoloader();
$autoloader->registerLoader();

$core = new Ekoed\Core\System("MedWave");
$dbClass = new Ekoed\Database\DB();
$dbcon = $dbClass->getDbcon("medwave");
$core->setDbHandle($dbcon);
$path = $core->determineRoute($_SERVER['REQUEST_URI']);
//var_dump($path);  ## Debugging to see what View is currently loaded
if ($path)
	require $path;

