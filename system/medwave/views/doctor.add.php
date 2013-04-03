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
			<label>doctor name<label>
			<input type="text" name="doctor_name">
			<div>
			<label>patient name<label>
			<input type="text" name="patient_name">
            <input type="button" onclick="familyDoctorAdd();">

	<body>
</html>