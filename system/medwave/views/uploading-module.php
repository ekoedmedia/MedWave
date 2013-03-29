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
	<title>User Management</title>
	<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">

</head>
<body>
	<header class="header">
		<?php include '_base/auth.header.php'; ?>
	</header>
	<div class="content">
	    <div class="content-wrapper">
	    	<?php include "_uploading/form-data.php"; ?>
	    	<?php include "_base/form.success.php"; ?>
			<?php include "_base/form.error.php"; ?>
			<form action="./?c=upload&d=home" method="post" enctype="multipart/form-data" action="uploade.php" method="POST">
				<div>
					<label for="recordID">Record ID:</label>
					<input type="text" name="record_id" value="" id="recordID">
				</div>
				<div>
					<label for="patientName">Patient Name:</label>
					<select name="patientName" id="patientName">
						<?php print $patients; ?>
					</select>
				</div>
				<div>
					<label for="doctorName">Doctor Name:</label>
					<select name="patientName" id="doctorName">
						<?php print $doctors; ?>
					</select>
				</div>
				<div>
					<label for="radiologistName">Radiologist Name:</label>
					<input type="text"name="radiologist_name" value="<?php ?>" disabled="disabled" id="radiologistName">
				</div>
				<div>
					<label for="testType">Test Type:</label>
					<input type="text" name="test_type" value="" id="testType">
				</div>
				<div>
					<label for="trescribingDate">Prescribing Date:</label>
					<input type="text" name="prescribing_date" value="" id="trescribingDate">
				</div>
				<div>
					<label for="testDate">Test Date:</label>
					<input type="text" name="test_date" value="" id="testDate">
				</div>
				<div>
					<label for="diagnosis">Diagnosis:</label> 
					<input type="text" name="diagnosis" value="" id="diagnosis">
				</div>
				<div>
					<label for="description">Description:</label>
					<input type="text" name="description" value="" id="description">	
				</div>
				<div>
					<label for="files">Choose a file(s) to upload:</label>
					<input name="uploadedfile[]" type="file" multiple="multiple" id="files">
				</div>
				<div>
					<input type="submit" value="submit record">
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000000000" >
					<input type="hidden" name="CMD" value="upload">
				</div>
			</form>
	    </div>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
	<script type="text/javascript" src="media/js/jquery.min.js"></script>
</body>
</html>