<?php

if (isset($_GET['ajax']))
	include "../../../system.php";

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$page = $_GET['p'];
} else{
	$page = 0;
}
$sql = "SELECT u.user_name AS username, p.first_name AS fname, p.last_name AS lname, u.class AS role FROM users u LEFT JOIN persons p ON u.user_name=p.user_name ORDER BY p.user_name DESC LIMIT $page, 50";
$stmt = $dbcon->prepare($sql);
$stmt->execute();
?>

<table border="1" id="userTable">
	<tr>
		<th>Username</th><th>First Name</th><th>Last Name</th><th>Role</th><th>Controls</th>
	</tr>
	<?php 
		$rowNum=0;
		while ($result = $stmt->fetch(\PDO::FETCH_LAZY)) {
            
			print "<tr id=".$rowNum.">";
			
				print "<td><div id=\"userName".$rowNum."\" contenteditable>".$result->username."</div></td>";
				print "<td><div id=\"fName".$rowNum."\"contenteditable>".$result->fname."</div></td>";
				print "<td><div id=\"lName".$rowNum."\"contenteditable>".$result->lname."</div></td>";
				$selected0="";
				$selected1="";
				$selected2="";
				$selected3="";
				switch ($result->role) {
					case 'a':
						$selected0="Selected";
						$role = "Admin";
						break;
					case 'd':
						$selected1="Selected";
						$role = "Doctor";
						break;
					case 'p':
						$selected2="Selected";
						$role = "Patient";
						break;
					case 'r':
						$selected3="Selected";
						$role = "Radiologist";
						break;
				}

				print "<td><select id=\"role-dropdown".$rowNum."\">
							<option ".$selected0.">Admin</option>
							<option ".$selected1." >Doctor</option>
							<option ".$selected2." >Patient</option>
							<option ".$selected3." >Radiologist</option>
						</select></td>";

				print "<td class=\"user-management-controls\">
					   
					   	<form method=\"post\" id=\"updateUser\"
					      onsubmit=\"wat(".$rowNum.")\" class=\"update-user-form\">
					      
					          <input type=\"submit\" class=\"update-user-icon\" value=\"\">
					          <input type=\"hidden\" name=\"user\" value=\"".$result->username."\">
					          <input type=\"hidden\" name=\"CMD\" value=\"updateUser\">
					      </form>
					    
					      <form method=\"post\" action=\"./?c=user&d=users\" 
					      onsubmit=\"return window.confirm('Are you sure you want to delete the user: ".$result->username." ?');
					      \" class=\"delete-user-form\">
					      
					          <input type=\"submit\" class=\"delete-user-icon\" value=\"\">
					          <input type=\"hidden\" name=\"user\" value=\"".$result->username."\">
					          <input type=\"hidden\" name=\"CMD\" value=\"removeUser\">
					      </form>
					   </td>";
			print "</tr>";
		$rowNum++;
		}
	?>

<script>
function wat(r){
	var userName = document.getElementById("userName"+r);					
	var fName = document.getElementById("fName"+r);
	var lName = document.getElementById("lName"+r);
	var role = document.getElementById("role-dropdown"+r);
	allvars=userName.innerHTML+" "+fName.innerHTML+" "+lName.innerHTML+" "+role.options[role.selectedIndex].value;
	alert(allvars);
}

</script>

</table>		
<?php ##TODO: PUT IN PAGINATION LINKS ?>
