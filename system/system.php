<?php

require 'ekoed/autoloader/autoloader.php';
$autoloader = new autoloader();
$autoloader->registerLoader();

$directory = ltrim(dirname($_SERVER['PHP_SELF']), DIRECTORY_SEPARATOR);

// Include Core
$core = new Ekoed\Core\System($directory);

// Connect To DB

// Modified Database functionality to be able to include
// settings.json relatively now. So the string below basically allows the system to 
// get settings.jsons true path in the system and include it.
$settings = substr(realpath(getcwd()), 0, strpos(realpath(getcwd()), 'system')+7)."settings.json";
$dbClass = new Ekoed\Database\DB($settings);
$dbcon = $dbClass->getDbcon("medwave");
$core->setDbHandle($dbcon);