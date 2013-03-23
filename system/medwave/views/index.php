<!DOCTYPE html>
<html>
<head>
	<title>MedWave | Waves for the Future</title>
	<link type="text/css" rel="stylesheet" href="media/css/base.styles.css">
</head>
<body>
	<header class="header">
		<!-- LOGO TO GO HERE -->
	</header>
	<div class="content">
		<div class="description">
			<p>
				MedWave provides patients, doctors, and radiologists a single point of entry to 
				start sharing radiological information between eachother. MedWave simplifies your 
				life by giving you what you need, when you need it.
			</p>
			<p>
				Contact your family doctor about using MedWave today!
			</p>
		</div>
		<div class="form--login">
			<?php include "base/form.success.php"; ?>
			<?php include "base/form.error.php"; ?>
			<form action="?c=user&d=home" method="POST">
				<label for="username">Username</label> <input type="text" name="user_name" id="username"><br>
				<label for="password">Password</label> <input type="password" name="password" id="password"><br>
				<input type="submit" value="Submit" class="btn--submit">
				<a href="" title="">Forgot my Password</a>
				<input type="hidden" name="CMD" value="authenticate">
			</form>
		</div>
	</div>
	<footer class="footer">
		<ul class="nav">
			<li><a href="" class="btn" title="">Report</a></li>
			<li><a href="" class="btn" title="">About</a></li>
			<li><a href="" class="btn" title="">GitHub</a></li>
		</ul>
	</footer>
</body>
</html>

