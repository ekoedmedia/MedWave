<?php
session_start();

use MedWave\System\Model as models;

require 'medwave/ekoed/autoloader/autoloader.php';
$autoloader = new autoloader();
$autoloader->registerLoader();

$core = new MedWave\Ekoed\Core\System("/", "MedWave");
$dbClass = new MedWave\Ekoed\Database\DB();
$dbcon = $dbClass->getDbcon();
$core->determineRoute($_SERVER['REQUEST_URI']);

