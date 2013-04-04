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
		$timeChecked = "";
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
		
	}

?>