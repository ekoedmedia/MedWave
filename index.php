<?php
session_start();

use MedWave\System\Model as models;

require 'system/ekoed/autoloader/autoloader.php';
$autoloader = new autoloader();
$autoloader->setSystemDir("system");
$autoloader->registerLoader();

$core = new Ekoed\Core\System("/", "system");
$dbClass = new Ekoed\Database\DB();
$dbcon = $dbClass->getDbcon();
$core->determineRoute($_SERVER['REQUEST_URI']);

