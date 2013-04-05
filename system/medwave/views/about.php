<!DOCTYPE html>
<html>
<head>
	<title>MedWave | About MedWave</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link type="text/css" rel="stylesheet" href="media/css/base.styles.css">
	<script src="media/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="#">MedWave</a>
				<ul class="nav">
					<li><a href="./" title="Home">Home</a></li>
					<li><a href="./report" title="Report">Report</a></li>
					<li class="active"><a href="./about" title="About">About</a></li>
					<li><a href="http://github.com/ekoedmedia/MedWave" title="Github">GitHub</a></li>
				</ul>
				<form action="?c=user&d=home" method="POST" class="navbar-form pull-right">
					<input type="text" name="user_name" class="input-small" placeholder="Username" id="username">
					<input type="password" name="password" class="input-small" placeholder="Password" id="password">
					<input type="submit" value="Submit" class="btn">
					<input type="hidden" name="CMD" value="authenticate">
				</form>
			</div>
		</div>
	</div>
	<div class="container">
		<?php include "_base/form.success.php"; ?>
		<?php include "_base/form.error.php"; ?>
		<div class="page-header">
			<h1>MedWave | <small>About MedWave</small></h1>
		</div>
		<div class="description">
			
		</div>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

