<?php
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$page = $_GET['p'];
} else{
	$page = 0;
}
$sql = "SELECT u.user_name AS username, p.first_name AS fname, p.last_name AS lname, u.role AS role FROM users u INNER JOIN persons p ON u.user_name=p.user_name ORDER BY p.user_name DESC LIMIT 50, :page";
$stmt = $dbcon->prepare($sql);
$stmt->bindParam(':page', $page);
$stmt->execute();
?>
<table>
	<tr>
		<th>Username</th><th>First Name</th><th>Last Name</th><th>Role</th>
	</tr>
	<?php 
		while ($result = $stmt->fetch(\PDO::FETCH_LAZY)) {
			print "<tr>";
				print "<td>".$result->username."</td>";
				print "<td>".$result->fname."</td>";
				print "<td>".$result->lname."</td>";
				switch ($result->role) {
					case 'a':
						$role = "Admin";
						break;
					case 'd':
						$role = "Doctor";
						break;
					case 'p':
						$role = "Patient";
						break;
					case 'r':
						$role = "Radiologist";
						break;
				}
				print "<td>".$role."</td>";
			print "</tr>";
		}
	?>
</table>
<?php ##TODO: PUT IN PAGINATION LINKS ?>
