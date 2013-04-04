<?php include "_base/check.auth.php"; ?>
<?php 
	switch ($role) {
		case 'p':
		case 'd':
		case 'r':
			$error = new MedWave\Model\Error('Authenitcation', '1004', 'Invalid Permissions to view User Management Page');
			$_SESSION['error'] = serialize($error);
			header('Location: /'.$core->getBaseDir().'/home');
			break;
	}
	include '_analysis/form.data.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
	<link href="media/select2/select2.css" rel="stylesheet" type="text/css">
	<link href="media/jquery-ui/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="media/js/jquery.min.js"></script>
	<script src="media/select2/select2.min.js" type="text/javascript"></script>
	<script src="media/jquery-ui/js/jquery-ui.min.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			$("[rel='select']").select2();
			$("[rel='date']").datepicker();
			
			$('#timeHorizonCheckbox').click(function(){
				if (this.checked == true){
					$('#timeHorizon').fadeIn();
					$('#timeHorizonSet').prop('disabled','');
				} else {
					$('#timeHorizon').fadeOut();
					$('#timeHorizonSet').prop('disabled','disabled');
				}
			});
		});
	</script>
</head>
<body>
	<header class="header">
		<?php include '_base/auth.header.php'; ?>
	</header>
	<div class="content">
	    <div class="content-wrapper">
	    	<h2>Data Analysis OLAP | "You can name anything, anything" - Amir</h2>
	    	<div class="analysis-form">
	    		<form method="GET">
	    			<div>
	    				<input type="checkbox" name="patientName" id="patientName" <?php print (isset($patientChecked) ? $patientChecked : ""); ?>><label for="patientName">Patient Name</label>
	    				<input type="checkbox" name="testType" id="testType" <?php print (isset($testTypeChecked) ? $testTypeChecked : ""); ?>><label for="testType">Test Type</label>
	    				<input type="checkbox" name="timeHorizon" id="timeHorizonCheckbox" <?php print (isset($timeChecked) ? $timeChecked : ""); ?>><label for="timeHorizonCheckbox">Time</label>
	    			</div>
	    			<div style="display:<?php print $timeHorizon; ?>;" id="timeHorizon">
	    				<label for="timeHorizonSet">Timeframe:</label>
	    				<select name="timeHorizonSet" id="timeHorizonSet" <?php print (isset($timeHorizonSet) ? $timeHorizonSet : ""); ?>>
	    					<option value="week" <?php print (isset($weekSelected) ? $weekSelected : ""); ?>>Week</option>
	    					<option value="month" <?php print (isset($monthSelected) ? $monthSelected : ""); ?>>Month</option>
	    					<option value="year" <?php print (isset($yearSelected) ? $yearSelected : ""); ?>>Year</option>
	    				</select>
	    			</div>
	    			<div>
	    				<input type="submit" value="Analyze">
	    			</div>
	    		</form>
	    	</div>
	    	<div class="analysis-results" id="results">
	    		<?php 
	    			$i = 0;
    				print "<table>";
    				print "<tr>
    					       <th>Image Count</th>";
    				if (isset($patientChecked)) print "<th>Patient</th>";
    				if (isset($testTypeChecked)) print "<th>Test Type</th>";
    				if (isset($timeChecked)) print "<th>Time</th>";
    				print "</tr>";

    				while ($results = $stmt->fetch(\PDO::FETCH_LAZY)) {
    					$i = 1;
    					print "<tr>";
    						print "<td>".$results->imgCount."</td>";
    						if (isset($patientChecked)) print "<td>".$results->patient_name."</td>";
    						if (isset($testTypeChecked)) print "<td>".$results->test_type."</td>";
    						if (isset($timeChecked)) print "<td>".$results->test_date."</td>";
    					print "</tr>";
    				}
    				print "</table>";
    				if ($i == 0)
    					print "<p>No OLAP Data :(</p>";
	    		?>
	    	</div>
	    </div>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

