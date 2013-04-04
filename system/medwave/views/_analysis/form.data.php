<?php

	// Setting of data to make sure form is consistent from page to page
	if (isset($_GET['patientName']))
		$patientChecked = "checked=\"checked\"";

	if (isset($_GET['testType']))
		$testTypeChecked = "checked=\"checked\"";

	if (isset($_GET['timeHorizon'])) {
		$timeChecked = "checked=\"checked\"";
		$timeHorizon = "block";
		$timeHorizonSet = "";
	} else {
		$timeHorizonSet = "disabled";	
		$timeHorizon = "none";
	}
	
	if (isset($_GET['timeHorizonSet'])) {
		if ($_GET['timeHorizonSet'] == "week")
			$weekSelected = "selected=\"selected\"";
		if ($_GET['timeHorizonSet'] == "month")
			$monthSelected = "selected=\"selected\"";
		if ($_GET['timeHorizonSet'] == "year")
			$yearSelected = "selected=\"selected\"";	
	}
	

	// Beginning of OLAP Functionality
	if (isset($_GET['patientName']) || isset($_GET['testType']) || isset($_GET['timeHorizonSet'])) {
		
		// Creates temporary table of required data.
		$sqlCreateTemp = "CREATE TEMPORARY TABLE IF NOT EXISTS olap_analysis 
						  ENGINE=MEMORY AS (
						  	SELECT COUNT(i.image_id) AS imgCount, 
						  		   r.patient_name AS patient_name, 
						  		   r.test_type AS test_type, 
						  		   r.test_date AS test_date 
						  	FROM radiology_record r 
						  	INNER JOIN pacs_images i 
						  	ON r.record_id=i.record_id 
						  	GROUP BY i.record_id)";
		try {
			$dbcon->exec($sqlCreateTemp);
		} catch (\PDOException $e) {
			error_log($e->getMessage());
		} 

		$determineSQL = "";
		
		if (isset($_GET['patientName']))
			$determineSQL .= "p";
		if (isset($_GET['testType']))
			$determineSQL .= "t";
		if (isset($_GET['timeHorizonSet']) && $_GET['timeHorizonSet'] == "week")
			$determineSQL .= "w";
		if (isset($_GET['timeHorizonSet']) && $_GET['timeHorizonSet'] == "month")
			$determineSQL .= "m";
		if (isset($_GET['timeHorizonSet']) && $_GET['timeHorizonSet'] == "year")
			$determineSQL .= "y";

		// Determine what SQL statement should be used.
		switch ($determineSQL) {
			case "p":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name";
				break;
			case "t":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type";
				break;
			case "w":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY WEEK(test_date)";
				break;
			case "m":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY MONTH(test_date)";
				break;
			case "y":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY YEAR(test_date)";
				break;
			case "pt":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type, patient_name";
				break;
			case "pw":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name, WEEK(test_date)";
				break;
			case "pm":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name, MONTH(test_date)";
				break;
			case "py":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name, YEAR(test_date)";
				break;
			case "tw":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type, WEEK(test_date)";
				break;
			case "tm":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type, MONTH(test_date)";
				break;
			case "ty":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type, YEAR(test_date)";
				break;
			case "ptw":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type, patient_name, WEEK(test_date)";
				break;
			case "ptm":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type, patient_name, MONTH(test_date)";
				break;
			case "pty":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type, patient_name, YEAR(test_date)";
				break;
			case "":
				throw new \RuntimeException("Invalid arguments for OLAP");
				break;
		}

		try {
			$stmt = $dbcon->prepare($sql);
			$stmt->execute();
		} catch (\PDOException $e) {
			error_log($e->getMessage());
		}
		

	}

?>