<?php include "_base/check.auth.php"; ?>
<?php 
	switch ($role) {
		case 'p':
			$fileToInclude = "_home/patient.php";
			break;
		case 'd':
			$fileToInclude = "_home/doctor.php";
			break;
		case 'r':
			$fileToInclude = "_home/radiologist.php";
			break;
		case 'a':
			$fileToInclude = "_home/admin.php";
			break;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
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

