<?php
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$page = $_GET['p'];
} else{
	$page = 0;
}
$sql = "SELECT u.user_name AS username, p.first_name AS fname, p.last_name AS lname, u.class AS role FROM users u LEFT JOIN persons p ON u.user_name=p.user_name ORDER BY p.user_name DESC LIMIT $page, 50";
$stmt = $dbcon->prepare($sql);
$stmt->execute();
?>
<table>
	<tr>
		<th>Username</th><th>First Name</th><th>Last Name</th><th>Role</th><th>Controls</th>
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
				print "<td class=\"user-management-controls\">
					      <a href=\"update-user?user=".$result->username."\"><img src=\"media/img/update-icon.png\" alt=\"Update User\"></a><form method=\"post\" action=\"./?c=user&d=users\" onsubmit=\"return window.confirm('Are you sure you want to delete the user: ".$result->username." ?');\" class=\"delete-user-form\">
					          <input type=\"submit\" class=\"delete-user-icon\" value=\"\">
					          <input type=\"hidden\" name=\"user\" value=\"".$result->username."\">
					          <input type=\"hidden\" name=\"CMD\" value=\"removeUser\">
					      </form>
					   </td>";
			print "</tr>";
		}
	?>
</table>
<?php ##TODO: PUT IN PAGINATION LINKS ?>
