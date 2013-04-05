<!DOCTYPE html>
<html>
<head>
	<title>MedWave | Waves for the Future</title>
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
					<li class="active"><a href="./" title="Home">Home</a></li>
					<li><a href="./report" title="Report">Report</a></li>
					<li><a href="./about" title="About">About</a></li>
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
			<h1>MedWave | <small>Waves for the Future</small></h1>
		</div>
		<div class="description">
			<p class="lead">
				MedWave provides patients, doctors, and radiologists a single point of entry to 
				start sharing radiological information between eachother. MedWave simplifies your 
				life by giving you what you need, when you need it.
			</p>
			<p class="text-center lead">
				<strong>Contact your family doctor about using MedWave today!</strong>
			</p>
		</div>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

