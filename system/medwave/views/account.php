<?php include "_base/check.auth.php"; ?>
<?php include '_account/details.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>MedWave | Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link type="text/css" rel="stylesheet" href="media/css/base.styles.css">
	<script src="media/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<header class="header">
		<?php include '_base/auth.header.php'; ?>
	</header>
	<div class="container-wide">
		<?php include "_base/form.success.php"; ?>
		<?php include "_base/form.error.php"; ?>
    	<h3>Update Information</h3>
    	<form action="./?c=user&d=account" method="POST">
    		<div>
    			<label for="fname">First Name:</label>
    			<input type="text" name="fname" id="fname" value="<?php print $fname; ?>">
    		</div>
    		<div>
    			<label for="lname">Last Name:</label>
    			<input type="text" name="lname" id="lname" value="<?php print $lname; ?>">
    		</div>
    		<div>
    			<label for="address">Address:</label>
    			<input type="text" name="address" id="address" value="<?php print $address; ?>">
    		</div>
    		<div>
    			<label for="email">Email: <span class="red">*</span></label>
    			<input type="text" name="email" id="email" type="email" required value="<?php print $email; ?>">
    		</div>
    		<div>
    			<label for="phone">Phone:</label>
    			<input type="text" name="phone" id="phone" value="<?php print $phone; ?>">
    		</div>
    		<div>
    			<input type="submit" class="btn" value="Update Information">
    			<input type="hidden" name="CMD" value="updatePerson">
    		</div>
    		<span class="help-block red">* Required Fields</span>
    	</form>
    	<hr>
    	<h3>Change Password</h3>
    	<form action="./?c=user&d=account" method="POST">
    		<div>
	    		<label for="old_pass">Old Password:</label>
	    		<input type="password" name="old_password" id="old_pass" required>
    		</div>
    		<div>
	    		<label for="new_pass">New Password:</label>
	    		<input type="password" name="new_password" id="new_pass" required>
    		</div>
    		<div>
	    		<label for="con_pass">Confirm Password:</label>
	    		<input type="password" name="confirm_password" id="con_pass" required>
    		</div>
    		<div>
	    		<input type="submit" class="btn" value="Update Information">
	    		<input type="hidden" name="CMD" value="changePassword">
    		</div>
    	</form>
	</div>
	<footer class="footer">
		<?php include '_base/auth.footer.php'; ?>
	</footer>
</body>
</html>

