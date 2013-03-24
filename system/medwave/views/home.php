<?php include "base/check.auth.php"; ?>
<?php 
	switch ($role) {
		case 'p':
			$fileToInclude = "home/patient.php";
			break;
		case 'd':
			$fileToInclude = "home/doctor.php";
			break;
		case 'r':
			$fileToInclude = "home/radiologist.php";
			break;
		case 'a':
			$fileToInclude = "home/admin.php";
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
		<?php include 'base/auth.header.php'; ?>
	</header>
	<div class="content">
	    <?php include $fileToInclude; ?>	
	</div>
	<footer class="footer">
		<?php include 'base/auth.footer.php'; ?>
	</footer>
</body>
</html>

