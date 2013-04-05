<?php
session_start();

use MedWave\System\Model as models;

require 'system/ekoed/autoloader/autoloader.php';
$autoloader = new autoloader();
$autoloader->registerLoader();

$directory = ltrim(dirname($_SERVER['PHP_SELF']), DIRECTORY_SEPARATOR);

if (empty($directory)) {
	$directory = ".";
}

$core = new Ekoed\Core\System($directory);
$dbClass = new Ekoed\Database\DB();
$dbcon = $dbClass->getDbcon("medwave");
$core->setDbHandle($dbcon);
$path = $core->determineRoute($_SERVER['REQUEST_URI']);
//var_dump($path);  ## Debugging to see what View is currently loaded
if ($path)
	require $path;

