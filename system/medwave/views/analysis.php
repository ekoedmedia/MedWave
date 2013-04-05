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
	<title>MedWave | Data Analysis</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
	<link href="media/select2/select2.css" rel="stylesheet" type="text/css">
	<link href="media/jquery-ui/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="media/js/jquery.min.js"></script>
	<script src="media/select2/select2.min.js" type="text/javascript"></script>
	<script src="media/jquery-ui/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="media/bootstrap/js/bootstrap.min.js"></script>
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
	<div class="container-wide">
		<ul class="nav nav-tabs">
            <li class="pull-right active"><a href="./analysis">Data Analysis</a></li>
            <li class="pull-right"><a href="./report-gen">Report Generating</a></li>
            <li class="pull-right"><a href="./user-list">Manage Users</a></li>
        </ul>

	    <div class="content-wrapper">
	    	<h2>Data Analysis</h2>
	    	<div class="analysis-form">
	    		<form method="GET">
	    			<div>
	    				<div>
		    				<label for="patientName">Patient</label>
		    				<select name="patientName" rel="select" id="patientName" style="width:300px;">
		    					<option value="">Not Set</option>
		    					<?php
		    						$sql = "SELECT DISTINCT patient_name FROM radiology_record";
		    						$stmtList = $dbcon->prepare($sql);
		    						$stmtList->execute();
		    						while ($results = $stmtList->fetch(\PDO::FETCH_LAZY)) {
		    							if (isset($patient) && $results->patient_name == $patient)
		    								print "<option value=\"".$results->patient_name."\" selected=\"selected\">".$results->patient_name."</option>";
		    							else 
		    								print "<option value=\"".$results->patient_name."\">".$results->patient_name."</option>";
		    						}
		    					?>
		    				</select>
	    				</div>
	    				<div>
		    				<label for="testType">Test Type</label>
		    				<select name="testType" rel="select" id="testType" style="width:300px;">
		    					<option value="">Not Set</option>
		    					<?php
		    						$sql = "SELECT DISTINCT test_type FROM radiology_record";
		    						$stmtList = $dbcon->prepare($sql);
		    						$stmtList->execute();
		    						while ($results = $stmtList->fetch(\PDO::FETCH_LAZY)) {
		    							if (isset($testType) && $results->test_type == $testType)
		    								print "<option value=\"".$results->test_type."\" selected=\"selected\">".$results->test_type."</option>";
		    							else 
		    								print "<option value=\"".$results->test_type."\">".$results->test_type."</option>";
		    						}
		    					?>
		    				</select>
	    				</div>
	    				<div>
	    					<label for="timeHorizonCheckbox">Time</label>
	    					<input type="text" name="from" rel="date" value="<?php print (isset($from) ? $from : ""); ?>" placeholder="From">
	    					<input type="text" name="to" rel="date" value="<?php print (isset($to) ? $to : ""); ?>" placeholder="To">
	    				</div>
	    			</div>
	    			<div style="margin-top:20px;">
	    				<input type="submit" class="btn" value="Analyze">
	    			</div>
	    		</form>
	    	</div>
	    	<hr>
	    	<div class="analysis-results" id="results">
	    		<?php 
	    			$i = 0;
	    			if (isset($_GET['patientName']) || isset($_GET['testType']) || isset($_GET['to']) || isset($_GET['from'])) {
	    				if (!empty($_GET['to']) || !empty($_GET['from'])) {
	    					print "<h3 class=\"text-right\">Drill Down/Roll Up</h3>";
	    					print '<ul class="nav nav-pills pull-right">';
	    						if (isset($_GET['spec']) && $_GET['spec'] == "m") {
	    							print "<li><a href=\"".$_SERVER['REQUEST_URI']."&spec=w\">Week</a></li>";
	    							print "<li class=\"active\"><a href=\"".$_SERVER['REQUEST_URI']."&spec=m\">Month</a></li>";
	    							print "<li><a href=\"".$_SERVER['REQUEST_URI']."&spec=y\">Year</a></li>";
	    						} elseif (isset($_GET['spec']) && $_GET['spec'] == "w") {
	    							print "<li class=\"active\"><a href=\"".$_SERVER['REQUEST_URI']."&spec=w\">Week</a></li>";
	    							print "<li><a href=\"".$_SERVER['REQUEST_URI']."&spec=m\">Month</a></li>";
	    							print "<li><a href=\"".$_SERVER['REQUEST_URI']."&spec=y\">Year</a></li>";
	    						} else {
	    							print "<li><a href=\"".$_SERVER['REQUEST_URI']."&spec=w\">Week</a></li>";
	    							print "<li><a href=\"".$_SERVER['REQUEST_URI']."&spec=m\">Month</a></li>";
	    							print "<li class=\"active\"><a href=\"".$_SERVER['REQUEST_URI']."&spec=y\">Year</a></li>";
	    						}
	    					print '</ul>';
	    				}
	    				print "<table class=\"table table-striped table-hover table-bordered table-condensed\">";
	    				print "<tr>
	    					       <th>Image Count</th>";
	    				if (isset($patient)) print "<th>Patient</th>";
	    				if (isset($testType)) print "<th>Test Type</th>";
	    				if (isset($from) || isset($to)) print "<th>Time</th>";
	    				print "</tr>";
    				}

    				while ($results = $stmt->fetch(\PDO::FETCH_LAZY)) {
    					$i = 1;
    					print "<tr>";
    						print "<td>".$results->imgCount."</td>";
    						if (isset($patient)) print "<td>".$results->patient_name."</td>";
    						if (isset($testType)) print "<td>".$results->test_type."</td>";
    						if (isset($from) || isset($to)) {
    							print "<td>";
    							if (isset($_GET['spec']) && $_GET['spec'] == 'w')
    								print "Week: ".date("W", strtotime($results->test_date));
    							elseif (isset($_GET['spec']) && $_GET['spec'] == 'm')
    								print date("F", strtotime($results->test_date));
    							else
    								print date("Y", strtotime($results->test_date));
    							print "</td>";
    						}
    					print "</tr>";
    				}
    				print "</table>";
    				if ($i == 0 && (isset($_GET['patientName']) || isset($_GET['testType']) || isset($_GET['from']) || isset($_GET['to'])))
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

