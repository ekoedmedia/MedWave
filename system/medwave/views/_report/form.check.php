<?php
	// Checks if Diagnosis is Set as well as To/From to make sure there is a request for the page
	$diag = strtolower(trim($_GET['diagnosis']));
	$to = urldecode(trim($_GET['to']));
	$from = urldecode(trim($_GET['from']));
	if (empty($diag) || empty($to) || empty($from)) {
		$error = new \MedWave\Model\Error('Report', '8000', 'One or more fields left blank.');
		$_SESSION['error'] = serialize($error); 
		header("Location: ./report-gen");
	}

	$to = date('Y-m-d', strtotime($to));
	$from = date('Y-m-d', strtotime($from));
	if (strtotime($from) > strtotime($to)) {
		$error = new \MedWave\Model\Error('Report', '8001', 'From date cannot be greater than To date.');
		$_SESSION['error'] = serialize($error); 
		header("Location: ./report-gen");
	}
?>