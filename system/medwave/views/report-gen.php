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
?>
<html>
	<head>
		<title>Report Generation</title>
		<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
		<link href="media/jquery-ui/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
		<link href="media/select2/select2.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="media/js/jquery.min.js"></script>
		<script src="media/jquery-ui/js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="media/select2/select2.min.js" type="text/javascript"></script>
		<script>
			$(document).ready(function() { 
				$("[rel='date']").datepicker();
				$('#diagnosis').select2({ placeholder: "Select a Diagnosis" });
			});
		</script>
	</head>
	<body>
		<header class="header">
			<?php include '_base/auth.header.php'; ?>
		</header>
		<div class="content">
			<div class="content-wrapper">
				<h2>Report Generation</h2>
				<?php include '_base/form.error.php'; ?>
				<form action="./report-gen-results" method="GET">
					<div>
						<label for="diagnosis">Diagnosis:</label>
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
						<label for="from">From:</label>
						<input type="text" id="from" name="from" rel="date">
					</div>
					<div>
						<label for="to">To:</label>
						<input type="text" id="to" name="to" rel="date">
					</div>
					<div>
						<input type="submit" value="Generate">
					</div>
				</form>
			</div>
		</div>
		<footer class="footer">
			<?php include '_base/auth.footer.php'; ?>
		</footer>
	</body>
</html>