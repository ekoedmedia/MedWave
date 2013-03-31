<?php

if (isset($_GET['ajax']))
	include "../../../system.php";

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$page = $_GET['p'];
} else{
	$page = 0;
}
$sql = "SELECT u.user_name AS username, 
u.password AS password,
u.date_registered AS date_registered,
p.first_name AS fname, 
p.last_name AS lname, 
p.email AS email,
p.address AS address,
p.phone AS phone,
u.class AS role 
FROM users u LEFT JOIN persons p ON u.user_name=p.user_name ORDER BY p.user_name DESC LIMIT $page, 50";
$stmt = $dbcon->prepare($sql);
$stmt->execute();
?>

<table border="1" id="userTable">
	<tr>
		<th>Username</th><th>password</th><th>registration date</th><th>First Name</th><th>Last Name</th><th>email</th>
		<th>address</th><th>phone #</th><th>Role</th><th>Controls</th>
	</tr>
	<?php 
		$rowNum=0;
		while ($result = $stmt->fetch(\PDO::FETCH_LAZY)) {
            
			print "<tr id=".$rowNum.">";
			
				print "<td><div id=\"userName".$rowNum."\" >".$result->username."</div></td>";
				print "<td><div id=\"password".$rowNum."\" contenteditable>".$result->password."</div></td>";
				print "<td><div id=\"date_registered".$rowNum."\" contenteditable>".$result->date_registered."</div></td>";				
				print "<td><div id=\"fName".$rowNum."\"contenteditable>".$result->fname."</div></td>";
				print "<td><div id=\"lName".$rowNum."\"contenteditable>".$result->lname."</div></td>";
				print "<td><div id=\"email".$rowNum."\" contenteditable>".$result->email."</div></td>";
				print "<td><div id=\"address".$rowNum."\" contenteditable>".$result->address."</div></td>";
				print "<td><div id=\"phone".$rowNum."\" contenteditable>".$result->phone."</div></td>";
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

				print "<td><select disabled id=\"role-dropdown".$rowNum."\">
							<option ".$selected0.">Admin</option>
							<option ".$selected1." >Doctor</option>
							<option ".$selected2." >Patient</option>
							<option ".$selected3." >Radiologist</option>
						</select></td>";

				print "<td class=\"user-management-controls\">
					   
					   	   <div class=\"update-user-form\">
					           <input type=\"button\" class=\"update-user-icon\" onclick=\"wat(".$rowNum.");\" value=\"\">
					       </div>
					    
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
	/*u.user_name AS username, 
	u.password AS password,
1	u.date_registered AS date_registered,
	p.first_name AS fname, 
	p.last_name AS lname, 
	p.email AS email,
	p.address AS address,
	p.phone AS phone,
	u.class AS role*/
	var userName = document.getElementById("userName"+r).innerHTML;					
	var password = document.getElementById("password"+r).innerHTML;
	var date_registered= document.getElementById("date_registered"+r).innerHTML;
	var fName = document.getElementById("fName"+r).innerHTML;
	var lName = document.getElementById("lName"+r).innerHTML;
	var email = document.getElementById("email"+r).innerHTML;
	var address = document.getElementById("address"+r).innerHTML;
	var phone = document.getElementById("phone"+r).innerHTML;
//	var role = document.getElementById("role-dropdown"+r);
	
	$.post("./?c=user",{CMD: "updateUser",username:userName, password:password, date_registered:date_registered,
	fname:fName, lname:lName, email:email, address:address,phone:phone}
      );
}

</script>

</table>		
<?php ##TODO: PUT IN PAGINATION LINKS ?>
