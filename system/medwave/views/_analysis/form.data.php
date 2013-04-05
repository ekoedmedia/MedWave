<?php

	// Setting of data to make sure form is consistent from page to page
	if (isset($_GET['patientName']) && !empty($_GET['patientName']))
		$patient = $_GET['patientName'];

	if (isset($_GET['testType']) && !empty($_GET['testType']))
		$testType = $_GET['testType'];

	if (isset($_GET['from']) && !empty($_GET['from']))
		$from = $_GET['from'];

	if (isset($_GET['to']) && !empty($_GET['to']))
		$to = $_GET['to'];
	

	// Beginning of OLAP Functionality
	if (isset($_GET['patientName']) || isset($_GET['testType']) || isset($_GET['from']) || isset($_GET['to'])) {
		
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
		
		if (isset($_GET['patientName']) && !empty($_GET['patientName']) && $_GET['patientName'] != "all")
			$determineSQL .= "p";
		if (isset($_GET['patientName']) && $_GET['patientName'] == "all")
			$determineSQL .= "P";
		if (isset($_GET['testType']) && !empty($_GET['testType']) && $_GET['testType'] != "all")
			$determineSQL .= "t";
		if (isset($_GET['testType']) && $_GET['testType'] == "all")
			$determineSQL .= "T";
		if (isset($_GET['from']) && !empty($_GET['from']))
			$determineSQL .= "f";
		if (isset($_GET['to']) && !empty($_GET['to']))
			$determineSQL .= "o";

		if (isset($_GET['spec']) && $_GET['spec'] == "m") 
			$spec = "MONTH";
		elseif (isset($_GET['spec']) && $_GET['spec'] == "w")
			$spec = "WEEK";
		else 
			$spec = "YEAR"; 


		// Determine what SQL statement should be used.
		switch ($determineSQL) {
			case "p":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->execute();
				break;
			case "P":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name";
				$stmt = $dbcon->prepare($sql);
				$stmt->execute();
				break;
			case "t":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->execute();
				break;
			case "T":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type";
				$stmt = $dbcon->prepare($sql);
				$stmt->execute();
				break;
			case "f":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "o":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "fo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "pt":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->execute();
				break;
			case "Pt":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType GROUP BY patient_name";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->execute();
				break;
			case "pT":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient GROUP BY test_type";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->execute();
				break;
			case "PT":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name, test_type";
				$stmt = $dbcon->prepare($sql);
				$stmt->execute();
				break;
			case "pf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date>=:fromDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "Pf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "po":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date<=:toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "Po":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "tf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date>=:fromDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "to":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date<=:toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "Tf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY test_type, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "To":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY test_type, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "ptf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType AND test_date>=:fromDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "pto":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType AND test_date<=:toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "Ptf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date>=:fromDate GROUP BY patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "Pto":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date<=:toDate GROUP BY patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "pTf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date>=:fromDate GROUP BY test_type, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "pTo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date<=:toDate GROUP BY test_type, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "PTf":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY test_type, patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->execute();
				break;
			case "PTo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY test_type, patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "pfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "Pfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "tfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "Tfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY test_type, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "ptfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType AND test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "Ptfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date BETWEEN :fromDate AND :toDate GROUP BY patient_name, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':patient', $_GET['patientName']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "pTfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date BETWEEN :fromDate AND :toDate GROUP BY test_type, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':testType', $_GET['testType']);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "PTfo":
				$sql = "SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY patient_name, test_type, ".$spec."(test_date)";
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(':fromDate', date("Y-m-d", strtotime($_GET['from'])));
				$stmt->bindParam(':toDate', date("Y-m-d", strtotime($_GET['to'])));
				$stmt->execute();
				break;
			case "":
				$j = 0;
				//throw new \RuntimeException("Invalid arguments for OLAP");
				break;
		}
		

	}

?>