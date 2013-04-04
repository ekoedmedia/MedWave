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
	<title>MedWave | Search Results</title>
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
		});
	</script>
</head>
<body>
	<header class="header">
		<?php include '_base/auth.header.php'; ?>
	</header>
	<div class="container-wide">
		<ul class="nav nav-tabs">
			<li><a href="./home">Back to Search</a></li>
		</ul>
		<h3>Search Results</h3>
		<?php 
			if (isset($_GET['search'])) {
				print "<p>Displaying Results for the Search: <strong>".$_GET['search']."</strong></p>";
			} else {
				print "<p>Displaying Results for the Search Period from: <strong>".$_GET['from']."</strong> to: <strong>".$_GET['to']."</strong></p>";
			}
		?>
	    <?php include $fileToInclude; ?>	
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

