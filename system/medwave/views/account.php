<?php include "base/check.auth.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
</head>
<body>
	<header class="header">
		<?php include 'base/auth.header.php'; ?>
	</header>
	<div class="content">
	    <div class="content-wrapper">
	    	<h3>Update Information</h3>
	    	<?php include "base/form.success.php"; ?>
			<?php include "base/form.error.php"; ?>
	    	<form action="./?c=user&d=account" method="POST">
	    		<?php 
	    			## TODO: Separate this into a file to make things look nicers, 
	    			##		 only print statements and includes should be in template files.
	    			$sql = "SELECT * FROM persons WHERE user_name=:name";
	    			$stmt = $dbcon->prepare($sql);
	    			$stmt->execute(array(":name" => $_SESSION['username']));

	    			$result = $stmt->fetch(\PDO::FETCH_LAZY);
	    			$fname = ($result->first_name ? $result->first_name : "");
	    			$lname = ($result->last_name ? $result->last_name : "");
	    			$address = ($result->address ? $result->address : "");
	    			$email = ($result->email ? $result->email : "");
	    			$phone = ($result->phone ? $result->phone : "");
	    		?>
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
	    			<label for="email">Email:</label>
	    			<input type="text" name="email" id="email" value="<?php print $email; ?>">
	    		</div>
	    		<div>
	    			<label for="phone">Phone:</label>
	    			<input type="text" name="phone" id="phone" value="<?php print $phone; ?>">
	    		</div>
	    		<div>
	    			<input type="submit" value="Update Information">
	    			<input type="hidden" name="CMD" value="updatePerson">
	    		</div>
	    	</form>
	    	<h3>Change Password</h3>
	    	<form action="./?c=user&d=account" method="POST">
	    		<div>
		    		<label for="old_pass">Old Password:</label>
		    		<input type="password" name="old_password" id="old_pass">
	    		</div>
	    		<div>
		    		<label for="new_pass">New Password:</label>
		    		<input type="password" name="new_password" id="new_pass">
	    		</div>
	    		<div>
		    		<label for="con_pass">Confirm Password:</label>
		    		<input type="password" name="confirm_password" id="con_pass">
	    		</div>
	    		<div>
		    		<input type="submit" value="Update Information">
		    		<input type="hidden" name="CMD" value="changePassword">
	    		</div>
	    	</form>
	    </div>	
	</div>
	<footer class="footer">
		<?php include 'base/auth.footer.php'; ?>
	</footer>
</body>
</html>

