<?php
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