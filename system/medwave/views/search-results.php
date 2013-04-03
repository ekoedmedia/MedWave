<?php include "_base/check.auth.php"; ?>
<?php 
	switch ($role) {
		case 'p':
			$fileToInclude = "_search/patient.php";
			break;
		case 'd':
			$fileToInclude = "_search/doctor.php";
			break;
		case 'r':
			$fileToInclude = "_search/radiologist.php";
			break;
		case 'a':
			$fileToInclude = "_search/admin.php";
			break;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
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
		});
	</script>
</head>
<body>
	<header class="header">
		<?php include '_base/auth.header.php'; ?>
	</header>
	<div class="content">
	    <?php include $fileToInclude; ?>	
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

