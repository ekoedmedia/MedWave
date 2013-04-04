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
    <link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
    <link href="media/jquery-ui/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="media/js/jquery.min.js"></script>
    <script src="media/jquery-ui/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="media/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() { 
            $("[rel='date']").datepicker();
        });
    </script>
</head>
<body>
	<header class="header">
		<?php include '_base/auth.header.php'; ?>
	</header>
	<div class="container-wide">
		<ul class="nav nav-tabs">
            <li class="active"><a href="./user.add"><i class="icon-plus-sign"></i> Add User</a></li>
            <li class="pull-right"><a href="./analysis">Data Analysis</a></li>
            <li class="pull-right"><a href="./report-gen">Report Generating</a></li>
            <li class="pull-right"><a href="./user-list">Manage Users</a></li>
        </ul>

        <?php include "_base/form.success.php"; ?>
        <?php include "_base/form.error.php"; ?>
		<form method="POST" action="./?c=user&d=user.add" style="margin-top:20px;">
			<div>
				<label for="username">Username<label>
				<input type="text" name="username" id="username" required>
			</div>
			<div>
				<label for="password">Password<label>
				<input type="password" id="password" name="password" required>
			</div>
			<div>
				<label for="reg_date">Registration Date<label>
				<input type="text" id="reg_date" rel="date" name="date_registered" value="<?php print date("d/m/Y"); ?>" required>
			</div>
			<div>
				<label for="first_name">First Name<label>
				<input type="text" id="first_name" name="fname">
			</div>
			<div>
				<label for="last_name">Last Name<label>
				<input type="text" id="last_name" name="lname">
			</div>
			<div>
				<label for="email">Email<label>
				<input id="email" type="email" name="email" placeholder="example@domain.com" required>
			</div>
			<div>
				<label for="address">Address<label>
				<input type="text" id="address" name="address">
			</div>
			<div>
				<label for="phone">Phone<label>
				<input type="text" id="phone" name="phone" placeholder="5551234567">			
			</div>
			<div>
				<label for="role">Role</label>
				<select id="role" name="role" required>
					<option value="a">Admin</option>
					<option value="d">Doctor</option>
					<option value="p">Patient</option>
					<option value="r">Radiologist</option>
				</select>
			</div>
			<div>
	        	<button type="submit" class="btn"><i class="icon-plus-sign"></i> Add user</button>
	        	<input type="hidden" name="CMD" value="addUser">
			</div>
		</form>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
<body>
</html>