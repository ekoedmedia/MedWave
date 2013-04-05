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
	<div class="container-wide">
		<?php include "_base/form.success.php"; ?>
		<?php include "_base/form.error.php"; ?>
		<div class="page-header">
			<h1>MedWave | <small>About MedWave</small></h1>
		</div>
		<div class="row-fluid">
			<div class="span3">
				<div class="well sidebar-nav" style="position:fixed;">
					<ul class="nav nav-list">
						<li class="nav-header">Quick Links</li>
						<li><a href="#intro">Introduction</a></li>

						<li><a href="#license">License</a></li>
					</ul>
				</div>
			</div>
			<div class="span9">
				<div class="description">
					<p class="lead">
						MedWave allows Doctors, Patients, and Radiologists to keep track of XRays, MRIs, and more all from one convienent place.<br><br>
						Ask your Doctor about MedWave today.
					</p>
					<hr>
					<div class="margin-top:50px;"></div>
					<div class="alert alert-error">
						MedWave is <strong>NOT</strong> commercially ready, and as such, should not be treated this way. MedWave would require much security improvements to be viable
						as a commercial product. It is highly recommended <strong>NOT</strong> to use this in a production setting, without prior consultation of security issues within
						the source code.
					</div>

					<a name="intro"></a>
					<div class="margin-top:50px;"></div>
					<h3>Introduction</h3>

					<a name="license"></a>
					<div class="margin-top:50px;"></div>
					<h3>License</h3>
					<p>
						MedWave is free and Open Source; released under the MIT Open Source License.
					</p>
					<pre>
Copyright (c) 2013 Jeremy Smereka, Amir Salimi

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
					</pre>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

