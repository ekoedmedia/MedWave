<?php include "_base/check.auth.php"; ?>
<?php 
	switch ($role) {
		case 'p':
		case 'd':
		case 'a':
			$error = new MedWave\Model\Error('Authenitcation', '1004', 'Invalid Permissions to view User Management Page');
			$_SESSION['error'] = serialize($error);
			header('Location: /'.$core->getBaseDir().'/home');
			break;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>MedWave | Uploading Module</title>
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
			$('#doctorList').select2(); 
			$('#patientList').select2();
			$('#testDate').datepicker();
			$('#prescribingDate').datepicker();
		});
	</script>
</head>
<body>
	<header class="header">
		<?php include '_base/auth.header.php'; ?>
	</header>
	<div class="container-wide">
		<ul class="nav nav-tabs">
			<li class="pull-right active"><a href="./uploading-module">Upload Module</a></li>
		</ul>
		<?php include "_uploading/form-data.php"; ?>
    	<?php include "_base/form.success.php"; ?>
		<?php include "_base/form.error.php"; ?>
    	<h2>Upload Radiology Record</h2>
    	<p>All fields are required to fill out a Radiology Record</p>
		<form action="./?c=upload&d=uploading-module" method="post" enctype="multipart/form-data" action="uploade.php" method="POST" class="uploadingForm">
			<div>
				<label for="recordID">Record ID:</label>
				<input type="text" name="record_id" value="" id="recordID" required>
			</div>
			<div>
				<label for="patientName">Patient Name:</label>
				<select name="patientName" id="patientList" style="width:200px;" required>
					<?php print $patients; ?>
				</select>
			</div>
			<div>
				<label for="doctorName">Doctor Name:</label>
				<select name="doctorName" id="doctorList" style="width:200px;" required>
					<?php print $doctors; ?>
				</select>
			</div>
			<div>
				<label for="radiologistName">Radiologist Name:</label>
				<input type="text" value="<?php print $radiologist->user_name; ?>" disabled="disabled" id="radiologistName">
				<input type="hidden" value="<?php print $radiologist->user_name; ?>" name="radiologistName">
			</div>
			<div>
				<label for="testType">Test Type:</label>
				<input type="text" name="test_type" value="" id="testType" required>
			</div>
			<div>
				<label for="prescribingDate">Prescribing Date:</label>
				<input type="text" name="prescribing_date" value="" id="prescribingDate" required>
			</div>
			<div>
				<label for="testDate">Test Date:</label>
				<input type="text" name="test_date" value="" id="testDate" required>
			</div>
			<div>
				<label for="diagnosis">Diagnosis:</label> 
				<input type="text" name="diagnosis" value="" id="diagnosis" required>
			</div>
			<div>
				<label for="description">Description:</label>
				<input type="text" name="description" value="" id="description" required>	
			</div>
			<div>
				<label for="files">Choose a file(s) to upload:</label>
				<input name="uploadedfile[]" type="file" multiple="multiple" id="files" required>
			</div>
			<div>
				<input type="submit" class="btn" value="submit record">
				<input type="hidden" name="CMD" value="upload">
			</div>
		</form>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>