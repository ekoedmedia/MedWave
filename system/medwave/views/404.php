<!DOCTYPE html>
<html>
<head>
	<title>MedWave | 404 Page Not Found</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
	<link href="media/select2/select2.css" rel="stylesheet" type="text/css">
	<link href="media/jquery-ui/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="media/js/jquery.min.js"></script>
	<script src="media/select2/select2.min.js" type="text/javascript"></script>
	<script src="media/jquery-ui/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="media/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<header class="header">
		<?php 
			if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
				include '_base/auth.header.php';
			} else {
		?>
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="#">MedWave</a>
						<ul class="nav">
							<li><a href="./" title="Home">Home</a></li>
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
		<?php
			}
		?>
	</header>
	<div class="container-wide">
	   	<div class="page-header">
			<h1>404 | <small>Waves not Found</small></h1>
		</div>
		<div class="description">
			<p class="lead">
				The requested page does not exist.<br>Please check your spelling, or click the back button on your browser to return to the previous page.
			</p>
			<p class="text-center lead">
				<strong>If the problem persists contact the developers!</strong>
			</p>
		</div>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

