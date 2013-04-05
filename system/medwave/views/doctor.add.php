<?php include "_base/check.auth.php"; ?>
<?php 
    switch ($role) {
        case 'p':
        case 'd':
        case 'r':
            $error = new MedWave\Model\Error('Authenitcation', '1004', 'Invalid Permissions to view User Management Page');
            $_SESSION['error'] = serialize($error);
            header('Location: /'.$core->getBaseDir().'/home');
            break;
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>MedWave | Add User</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link type="text/css" rel="stylesheet" href="media/css/base.styles.css">
	<script type="text/javascript" src="media/js/jquery.min.js"></script>
	<script src="media/bootstrap/js/bootstrap.min.js"></script>
	<link href="media/select2/select2.css" rel="stylesheet" type="text/css">
	<script src="media/select2/select2.min.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			$('[rel="select2"]').select2();
		});
	</script>
</head>
	<body>
		<header class="header">
			<?php include '_base/auth.header.php'; ?>
		</header>
		<div class="container-wide">
			<ul class="nav nav-tabs">
	            <li class="active"><a href="./doctor.add"><i class="icon-plus-sign"></i> Add Doctor</a></li>
	            <li class="pull-right"><a href="./analysis">Data Analysis</a></li>
	            <li class="pull-right"><a href="./report-gen">Report Generating</a></li>
	            <li class="pull-right"><a href="./user-list">Manage Users</a></li>
	        </ul>
	        <?php include "_base/form.success.php"; ?>
			<?php include "_base/form.error.php"; ?>

			<form method="POST" action="./?c=user&d=doctor.add" class="formDoctorAdd">
				<div>
					<label>Doctor Name<label>
					<select name="doctor" rel="select2" style="width:300px;">
						<?php
							// Prints out a list of Doctor Names
							$sql = "SELECT u.user_name AS username, p.first_name AS first_name, p.last_name AS last_name FROM users u LEFT JOIN persons p ON u.user_name=p.user_name WHERE class='d'";
							$stmt = $dbcon->prepare($sql);
							$stmt->execute();

							while ($results = $stmt->fetch(\PDO::FETCH_LAZY)) {
								if ($results->first_name == NULL || $results->last_name == NULL)
									$name = $results->username;
								else 
									$name = $results->first_name." ".$results->last_name." (".$results->username.")";

								print "<option value=\"".$results->username."\">".$name."</option>";
							}	
						?>
					</select>
				</div>
				<div>
					<label>Patient Name<label>
					<select name="patient" rel="select2" style="width:300px;">
						<?php
							// Prints out a list of Patient Names
							$sql = "SELECT u.user_name AS username, p.first_name AS first_name, p.last_name AS last_name FROM users u LEFT JOIN persons p ON u.user_name=p.user_name WHERE class='p'";
							$stmt = $dbcon->prepare($sql);
							$stmt->execute();

							while ($results = $stmt->fetch(\PDO::FETCH_LAZY)) {
								if ($results->first_name == NULL || $results->last_name == NULL)
									$name = $results->username;
								else 
									$name = $results->first_name." ".$results->last_name." (".$results->username.")";

								print "<option value=\"".$results->username."\">".$name."</option>";
							}	
						?>
					</select>
				</div>
				<div>
	            	<input type="submit" class="btn" value="Add Family Doctor">
	            	<input type="hidden" name="CMD" value="addDoctor">
	        	</div>
	        </form>
    	</div>
    	<footer class="footer">
			<?php include '_base/auth.footer.php'; ?>
		</footer>
	<body>
</html>