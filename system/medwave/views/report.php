<!DOCTYPE html>
<html>
<head>
	<title>MedWave | Project Report</title>
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
					<li class="active"><a href="./report" title="Report">Report</a></li>
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
	<div class="container-extra-wide">
		<?php include "_base/form.success.php"; ?>
		<?php include "_base/form.error.php"; ?>
		<div class="page-header">
			<h1>MedWave | <small>Project Report</small></h1>
		</div>
		<div class="row-fluid">
			<div class="span3">
				<div class="well sidebar-nav" style="position:fixed;">
					<ul class="nav nav-list">
						<li class="nav-header">Modules</li>
						<li><a href="#intro">Introduction</a></li>
						<li><a href="#login">Login</a></li>
						<li><a href="#user">User Management</a></li>
						<li><a href="#report">Report Generation</a></li>
						<li><a href="#uploading">Uploading</a></li>
						<li><a href="#search">Search</a></li>
						<li><a href="#analysis">Data Analysis</a></li>
					</ul>
				</div>
			</div>
			<div class="span9">
				<div class="description">
					<p class="lead">
						<strong>CMPUT 391 Project</strong> - MedWave | Waves for the Future<br>
						<strong>Winter 2013</strong> | University of Alberta<br>
						Jeremy Smereka<br>
						Amir Salimi<br>
					</p>
					<hr>
					<a name="intro"></a>
					<div style="margin-top:50px;"></div>
					<h3>Introduction</h3>
					<p>
						Within the medwave folder, there are two folders Media and System. The Media folder contains the CSS code, images and the visual aspects of the site. System contains the architecture and functionalities of the site.
					</p>
					<a name="login"></a>
					<div style="margin-top:50px;"></div>
					<h3>Login Module</h3>
					<p>
						<strong>index.php</strong>: The page where the users logs in.<br>
						It sends the data to the <strong>controller/user.php</strong>. Where the authenticate() function gets the supplied username/password and checks the users table to see if they match using the following sql command:

						<pre>SELECT COUNT(*) AS count, class, user_name<br>FROM users<br>WHERE user_name=:username AND password=:password</pre>

						If the authentication is completed, the user gets redirected to the home page under <strong>home.php</strong>.
					</p>
					<a name="user"></a>
					<div style="margin-top:50px;"></div>
					<h3>User Management Module</h3>
					<p>
						This module allows a system administrator to manage (to enter or update) the user information, i.e., the information stored in tables users, persons, family_doctor. The admin can click on manage users on their home page and access this module.
					</p>
					<p>
						The file <strong>user-list.php</strong> is called by default, it can be accessed by the administrators to modify/add/remove data from tables persons and users (these 2 tables are joined to make adding and removing users easier) and the family_doctor table. Clicking on update next to any row will take all the data out of that row and send it to user.php. where updateUser() or addUser() will do the following:
					</p>
					<p>
						First update or add all the personal information:
					</p>
					<pre>
UPDATE persons 
SET first_name=:fname, 
	last_name=:lname, 
	address=:address, 
	email=:email, 
	phone=:phone 
WHERE user_name=:name
<br>Or if it's new information<br>
INSERT INTO persons (first_name, last_name, address, email, phone, user_name) 
VALUES (:fname, :lname, :address, :email, :phone, :name)</pre>
					<p>
						Then update the users table.
					</p>
					<pre>
UPDATE family_doctor 
SET patient_name=:patient 
WHERE doctor_name=:doctor 
AND patient_name=:oldpatient</pre>
					<p>
						or
					</p>
					<pre>
INSERT INTO users (user_name, password, class, date_registered) 
VALUES (:username, :password, :class, :date_registered)</pre>
					<p>
						On the family_doctor table, only removing/adding can be done. if the user clicks on add, the date will be send to controller/user.php where the function addDoctor() does the following:
					</p>
					<pre>
INSERT INTO family_doctor (family_doctor, patient_name) 
VALUES (:doctor, :patient)</pre>
					<p>
						Same for removing, but the sql command is:
					</p>
					<pre>
DELETE FROM family_doctor 
WHERE patient_name=:patient 
AND doctor_name=:doctor</pre>
					<a name="report"></a>
					<div style="margin-top:50px;"></div>
					<h3>Report Generating Module</h3>
					<p>
						Report Generating is done by selecting a diagnosis and a date range (from/to). From here the following SQL is executed:
					</p>
					<pre>
SELECT p.user_name AS username, 
	   p.first_name As nameF, 
	   p.last_name As nameL, 
	   p.address As address, 
	   p.phone AS phone, 
	   MIN(r.test_date) AS testDate, 
	   r.diagnosis As diagnosis 
FROM persons p 
RIGHT JOIN radiology_record r 
ON p.user_name = r.patient_name 
WHERE r.diagnosis=:diagnosis AND r.prescribing_date BETWEEN :from AND :to</pre>
					<p>
						This joins the persons table with a radiology record, which is then used to display the results of the user information, provided it is available.
					</p>
					<a name="uploading"></a>
					<div style="margin-top:50px;"></div>
					<h3>Uploading Module</h3>
					<p>
						Lets the user input all the information for a patient record and select multiple images to upload. The information will be sent to <strong>controller/upload.php</strong> function. The information will then be uploaded with the following commands:
					</p>
					<pre>
INSERT INTO radiology_record (record_id, patient_name, doctor_name, radiologist_name, test_type, prescribing_date, test_date, diagnosis, description)
 VALUES (:record_id, :patient_name, :doctor_name, :radiologist_name, :test_type, :prescribing_date, :test_date, :diagnosis, :description)</pre>
 					<p>
 						This same record is then also partially inserted into the radiology_search table which is a different database type so to allow for searching.
 					</p>
 					<pre>
INSERT INTO radiology_search (record_id, patient_name, diagnosis, description)
VALUES (:record_id, :patient_name, :diagnosis, :description)</pre>
					<p>
						Finally, the images are stored into the database.
					</p>
					<pre>
INSERT INTO pacs_images (record_id, image_id, thumbnail, regular_size, full_size)
VALUES (:record_id, :image_id, :thumb, :regular_size, :full_size)</pre>
					<a name="search"></a>
					<div style="margin-top:50px;"></div>
					<h3>Search Module</h3>
					<p>
						Lets the user input either text OR a From/To Date range. Once either is submitted, the results being displayed will depend upon user class and their search parameters.
					</p>
					<p>
						The following SQL statements are the primary driving force behind it.
					</p>
					<pre>
SELECT r.record_id AS record_id,
      r.patient_name AS patient_name,
      r.doctor_name AS doctor_name,
      r.radiologist_name AS radiologist_name,
      r.test_type AS test_type,
      r.prescribing_date AS prescribing_date,
      r.test_date AS test_date,
      r.diagnosis AS diagnosis,
      r.description AS description,
      MATCH(s.patient_name) AGAINST(:search IN BOOLEAN MODE) AS freq1,
      MATCH(s.diagnosis) AGAINST(:search IN BOOLEAN MODE) AS freq2,
      MATCH(s.description) AGAINST(:search IN BOOLEAN MODE) AS freq3
FROM radiology_search s INNER JOIN radiology_record r ON s.record_id=r.record_id
WHERE MATCH(s.patient_name, s.diagnosis, s.description) AGAINST(:search IN BOOLEAN MODE)
ORDER BY (6*freq1)+(3*freq2)+(freq3) DESC</pre>
					<p>
						The above query, is modified minorly for each class of user. We introduce a where clause for each class EXCEPT admin (shown) which filters based on user name (i.e. if class is patient, it goes <code>WHERE patient_name=:patient</code>).
					</p>
					<p>
						Having used MySQL we found that we needed to use a separate table to power it, as InnoDB does not have Full Text search.	
					</p>
					<div class="alert alert-info">
						ASSUMPTION: We assume Doctors ONLY have records of their patients, thus <code>WHERE doctor_name=:doctor</code> is what we used for the Doctors.
					</div>
					<a name="analysis"></a>
					<div style="margin-top:50px;"></div>
					<h3>Data Analysis Module</h3>
					<p>
						Data Analysis is a complicated module for us since we used MySQL. For the data analysis, after the user chooses the Patients, Diagnosis’s, and Time Periods, we then do the following:
					</p>
					<pre>
CREATE TEMPORARY TABLE IF NOT EXISTS olap_analysis
    ENGINE=MEMORY AS (
		SELECT COUNT(i.image_id) AS imgCount,
               r.patient_name AS patient_name,
               r.test_type AS test_type,
               r.test_date AS test_date
        FROM radiology_record r
        INNER JOIN pacs_images i
        ON r.record_id=i.record_id
        GROUP BY i.record_id)</pre>
        			<p>
						This creates a temporary table in memory with the data from the inner select query, which is the count of images, and required information for the OLAP.
					</p>
					<p>
						From here, we begin the actual processing of the data (subsetting). Since MySQL doesn’t have a cube function this was abit trickier for us. All the queries contain the following:
					</p>
					<p>
					<code>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis</code>
					</p>
					<p>
						After this point, the queries change based on what is being requested. If a specific patient/testType is requested, then <code>WHERE</code> is added on. If ALL patients/testTypes are requested, then a <code>GROUP BY</code> is added on for those columns. If only one time is specified then a <code>WHERE</code> is added on with the condition being >= or <= depending on if its from or to. Finally, if both from/to is submitted, then it uses <code>WHERE test_date BETWEEN from AND to</code>.
					</p>
					<p>
						The queries are listed below. This most likely is not the most efficient way of doing this but in our situation it is what we came up with. Note: $spec is the Roll Up/Drill Down operation, where $spec == YEAR || MONTH || WEEK.
					</p>
					<p>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY test_type</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType GROUP BY patient_name</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient GROUP BY test_type</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis GROUP BY patient_name, test_type</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date>=:fromDate GROUP BY ".$spec."(test_date)</pre>

					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date<=:toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date>=:fromDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date<=:toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY test_type, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY test_type, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType AND test_date>=:fromDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType AND test_date<=:toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date>=:fromDate GROUP BY patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date<=:toDate GROUP BY patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date>=:fromDate GROUP BY test_type, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date<=:toDate GROUP BY test_type, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date>=:fromDate GROUP BY test_type, patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date<=:toDate GROUP BY test_type, patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY test_type, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_type=:testType AND test_date BETWEEN :fromDate AND :toDate GROUP BY ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_type=:testType AND test_date BETWEEN :fromDate AND :toDate GROUP BY patient_name, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE patient_name=:patient AND test_date BETWEEN :fromDate AND :toDate GROUP BY test_type, ".$spec."(test_date)</pre>
					<pre>SELECT SUM(imgCount) AS imgCount, patient_name, test_type, test_date FROM olap_analysis WHERE test_date BETWEEN :fromDate AND :toDate GROUP BY patient_name, test_type, ".$spec."(test_date)</pre>
					</p>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

