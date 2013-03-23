<?php
// File simply checks if Logged is set, it not then destroys session and restarts with Error Message
if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
	session_destroy();
	session_start();
	$baseDir = $core->getBaseDir();
	$error = new MedWave\Model\Error('Authentication', '1002', 'You are not authenticated.');
	$_SESSION['error'] = serialize($error);
	header("Location: /".$baseDir."/");
}
