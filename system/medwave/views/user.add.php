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
	<title>add a user</title>
	<link href="media/css/base.styles.css" rel="stylesheet" type="text/css">
</head>
	<body>
		<form>
			<label>username**<label>
			<input type="text" name="sda" id="username">
			<div>
			<label>password<label>
			<input type="text" id="password">
			<div>
			<label>registration date<label>
			<input type="text" id="reg_date">
			<div>
			<label>First name<label>
			<input type="text" id="first_name">
			<div>
			<label>Last name<label>
			<input type="text" id="last_name">
			<div>
			<label>Email<label>
			<input type="text" id="email">
			<div>
			<label>Address<label>
			<input type="text" id="address">
			<div>
			<label>phone #<label>
			<input type="text" id="phone_number">			
			<td><select id="role-dropdown">
							<option>Admin</option>
							<option>Doctor</option>
							<option>Patient</option>
							<option>Radiologist</option>
						</select></td>
			<div>
            <button type="button" name ="add_user" onclick="UserAdd()">Add user</button>
	
		</form>

		<script type="text/javascript" src="media/js/jquery.min.js">
	function UserAdd(){
				var username = document.getElementById('username').value;
				var passoword = document.getElementById('password').value;
				var reg_date=document.getElementById('reg_date').value;
				var first_name=document.getElementById('first_name').value;
				var last_name=document.getElementById('last_name').value;
				var email=document.getElementById('email').value;
				var address=document.getElementById('address').value;
				var phone_number=document.getElementById('phone_number').value;
				var role=document.getElementById('role-dropdown').value;

			      $.post("./?c=user",{CMD: "addDoctor",uname:username,pass:password,
			  	regdate:reg_date,fname:first_name,lname:last_name,email:email,address:address
			  	,phone:phone_number,role:role});
		
		}
		</script>
	<body>
</html>