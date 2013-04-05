<?php
/** 
 * Gets data for form, such as name of patients,
 * doctors, and radiologist name that is logged in.
 */
$user = $_SESSION['username'];

$patients = "<option selected=\"selected\"></option>";
$doctors = "<option selected=\"selected\"></option>";

// Getting of Patient Names
$sql = "SELECT p.first_name AS fname, p.last_name AS lname, u.user_name AS username FROM persons p RIGHT JOIN users u ON u.user_name=p.user_name WHERE u.class='p'";
foreach ($dbcon->query($sql) AS $row) {
	if ($row['fname'] == "" || $row['lname'] == "")
		$patients .= "<option value=\"".$row['username']."\">".$row['username']."</option>";
	else 
		$patients .= "<option value=\"".$row['username']."\">".$row['fname']." ".$row['lname']."</option>";
}

// Getting of Doctor Names
$sql = "SELECT p.first_name AS fname, p.last_name AS lname, u.user_name AS username FROM persons p RIGHT JOIN users u ON u.user_name=p.user_name WHERE u.class='d'";
foreach ($dbcon->query($sql) AS $row) {
	if ($row['fname'] == "" || $row['lname'] == "")
		$doctors .= "<option value=\"".$row['username']."\">".$row['username']."</option>";
	else 
		$doctors .= "<option value=\"".$row['username']."\">".$row['fname']." ".$row['lname']."</option>";
}

// Getting of Radiologist Name
$sql = "SELECT p.first_name, p.last_name, u.user_name FROM persons p RIGHT JOIN users u ON u.user_name=p.user_name WHERE u.user_name=:user";
$stmt = $dbcon->prepare($sql);
$stmt->execute(array(":user" => $user));
$radiologist = $stmt->fetch(\PDO::FETCH_LAZY);


?>