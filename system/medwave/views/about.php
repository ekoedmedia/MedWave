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
						<li><a href="#install">Installation</a></li>
						<li class="nav-header">Modules</li>
						<li><a href="#login">Login</a></li>
						<li><a href="#user">User Management</a></li>
						<li><a href="#report">Report Generating</a></li>
						<li><a href="#uploading">Uploading</a></li>
						<li><a href="#search">Search</a></li>
						<li><a href="#analysis">Data Analysis</a></li>
						<li class="nav-header">Addition Information</li>
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

					<a name="install"></a>
					<div class="margin-top:50px;"></div>
					<h3>Installation</h3>
					<p>
						To install MedWave it is best to follow the step provided below, or for more detailed steps see: <a href="https://github.com/ekoedmedia/MedWave/wiki/Detailed-Installation">Detailed Installation</a>
					</p>
					<h4>Step 1: Create MySQL Database and User</h4>
					<p>
						Create a MySQL Database and User for MedWave on your server. Remember the login details as you will need them.
					</p>
					<h4>Step 2: Get MedWave</h4>
					<p>
						Get MedWave either by downloading the zip, or cloning it via command line.
					</p>
					<h4>Step 3: Edit settings.json</h4>
					<p>
						Edit system/settings.json to contain your connection information. <strong>DO NOT EDIT conName, or DB Type</strong>
					</p>
					<h4>Step 4: Run console install script</h4>
					<p>
						Via command line, run <code>php system/console</code> to and follow the install commands instructions.
					</p>
					<h4>Step 5: Create Administrator Account</h4>
					<p>
						Via command line again, run <code>php system/console</code> and create a user with role a.
					</p>
					<h4>Step 6: Finished</h4>
					<p>
						Celebrate, you have now finished installing MedWave.
					</p>
					
					<div class="margin-top:50px;"></div>
					<h2>Modules</h2>

					<a name="login"></a>
					<div class="margin-top:50px;"></div>
					<h3>Login</h3>
					<p>
						The login module can be accessed from the front page of the site. A user must login using their user name and password to gain access to the rest of the site.
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/1.png">
					<p>
						Once logged in, proper privileges and tools will be given to the user based on their role set by the administrators. This tools are in the user menu which can be accessed on the top right of the home page.
						A user may change their personal information by clicking on the account button on the top left of the home page.
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/2.png">
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/3.png">

					<a name="user"></a>
					<div class="margin-top:50px;"></div>
					<h3>User Management</h3>
					<p>
						This module can be accessed only by the system administrators. It allows the administrators to modify, add and delete information about the users and doctor/patient relations.
					</p>
					<p>
						An admin may access the user management module by clicking on the user management button on their homepage options menu. 
					</p>
					<p>
						The admin will then be able to change and modify information about a user in the table by clicking on any field that they wish to change. The changes will be submitted by clicking on the upload button in the controls column.
					</p>
					<p>
						In order to add a user, click on the Add user button (orange arrow) and you will be taken to the add user page. In order to modify the family-doctor table, click on the Doctor’s List button (red arrow). 
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/4.png">
					<p>
						Once the admin has clicked Add User they are able to fill out the form and add a user to the system. From here onwards, Users are able to login.
					</p>
					<p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/5.png">
					<p>
						In the Doctor’s table, you may only delete a row by clicking on the remove button on the controls column, or insert a new row. 
					</p>

					<a name="report"></a>
					<div class="margin-top:50px;"></div>
					<h3>Report Generating</h3>
					<p>
						This module can be used by a system administrator to get the list of all patients with a specified diagnosis for a given time period. To access this module, click on the "Report Generating" link found on the menu bar on the home page.
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/6.png">
					<p>
						Then enter specific diagnosis and the beginning date/end date in each box labeled as such. A table will be generated giving the administrator all the relevant results.
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/17.png">

					<a name="uploading"></a>
					<div class="margin-top:50px;"></div>
					<h3>Uploading</h3>
					<p>
						This module will be used by radiologists to first enter a radiology record, and then to upload medical images into the radiology record. 
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/13.png">
					<p>
						A radiologist can access this module by clicking on "upload-module" on their home page. They will then be able to upload all the record information along with all the relevant images. To select multiple image, hold the ctrl key and click on all the images that need to be uploaded. 
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/14.png">
 					<a name="search"></a>
					<div class="margin-top:50px;"></div>
					<h3>Search</h3>
					<p>
						On the homepage when logged in, all users are able to perform a radiology record search. Users have two choices: Either perform a text search, or perform Time Period Search. Searching with Text returns the results of the search results, provided anything is found. 
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/11.png">
					<p>
						Performing a Time Period Search returns results from the database between the periods that were specified, in the order specified (Most Recent First or Most Recent Last).
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/15.png">
					<p>
						On the results page, the information from the record is displayed one at a time. Clicking on Record Images allows you to zoom in, with the option of viewing the full size image.
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/16.png">
					<p>
						Finally, Records are displayed ONLY to the pertaining user that is logged in. So patients will only see their records, Doctors will only see their Patients records, Radiologists will only see the records they have added, and Administrators are able to see all records.
					</p>
					
					<a name="analysis"></a>
					<div class="margin-top:50px;"></div>
					<h3>Data Analysis</h3>
					<p>
						On the Data Analysis Module page, Administrators are able to see the image count depending on what parameters are set. The image count is based on a summation of data for each record in the database.
					</p>
					<p>
						For filtering options, the Administrator is able to select individual Patients and/or Test Types, or they can select all of them or none of them. 
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/18.png">
					<p>
						They are also able to filter with Time Range. The Time Range option allows the admins to see a range of data from a date, up to a date, or between two dates. Including a Time Range also includes the Roll Up and Drill Down functionality. By default, it is set to the highest level which is Year. From here you are able to Drill Down to Month and Week.
					</p>
					<img src="https://raw.github.com/ekoedmedia/MedWave/master/media/report-img/19.png">





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

