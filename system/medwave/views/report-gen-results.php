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

	include '_report/form.check.php';
?>
<html>
	<head>
		<title>MedWave | Report Generation Results</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
		<link href="media/jquery-ui/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
		<link href="media/select2/select2.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="media/js/jquery.min.js"></script>
		<script src="media/jquery-ui/js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="media/select2/select2.min.js" type="text/javascript"></script>
		<script src="media/bootstrap/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function() { 
				$("[rel='date']").datepicker();
				$('#diagnosis').select2({ placeholder: "Select a Diagnosis" });
				$('#from').click(function(){
					$('#ui-datepicker-div').css('top','244px');
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
	            <li class="pull-right"><a href="./analysis">Data Analysis</a></li>
	            <li class="pull-right active"><a href="./report-gen">Report Generating</a></li>
	            <li class="pull-right"><a href="./user-list">Manage Users</a></li>
	        </ul>
			
			<h2>Report Generation Results</h2>
			<form action="./report-gen-results" method="GET" class="reportForm">
				<div>
					<select name="diagnosis" id="diagnosis" style="width:200px;">
						<option></option>
						<?php 
							$sql = "SELECT DISTINCT diagnosis FROM radiology_record";
							$stmt = $dbcon->prepare($sql);
							$stmt->execute();
							while ($results = $stmt->fetch(\PDO::FETCH_LAZY)) {
								print '<option value="'.$results->diagnosis.'">'.ucfirst($results->diagnosis).'</option>';
							}
						?>
					</select>
				</div>
				<div>
					<input type="text" id="from" name="from" class="date" placeholder="From" rel="date" required>
				</div>
				<div>
					<input type="text" id="to" name="to" class="date" placeholder="To" rel="date" required>
				</div>
				<div>
					<input type="submit" class="btn" value="Generate">
				</div>
			</form>
			<hr>
			<div class="results">
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>Name</th><th>Address</th><th>Phone</th><th>First Tested Date</th><th>Diagnosis</th>
					</tr>
					<?php include '_report/table.php'; ?>
				</table>
			</div>
		</div>
		<footer class="footer">
			<?php include '_base/auth.footer.php'; ?>
		</footer>
	</body>
</html>