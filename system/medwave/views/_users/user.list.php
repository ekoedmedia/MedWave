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
                print "<td><input type=\"password\" id=\"password".$rowNum."\" value=\"".$result->password."\"></td>";
                print "<td><input type=\"text\" value=\"".str_replace('-', '/', $result->date_registered)."\" rel=\"date\" id=\"date_registered".$rowNum."\"></td>";             
                print "<td><input type=\"text\" id=\"fName".$rowNum."\" value=\"".$result->fname."\"></td>";
                print "<td><input type=\"text\" id=\"lName".$rowNum."\" value=\"".$result->lname."\"></td>";
                print "<td><input type=\"text\" id=\"email".$rowNum."\" value=\"".$result->email."\"></td>";
                print "<td><input type=\"text\" id=\"address".$rowNum."\" value=\"".$result->address."\"></td>";
                print "<td><input type=\"text\" id=\"phone".$rowNum."\" value=\"".$result->phone."\"></td>";
                $selected0 = "";
                $selected1 = "";
                $selected2 = "";
                $selected3 = "";
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
                               <input type=\"button\" class=\"update-user-icon\" onclick=\"updateUser(".$rowNum.");\" value=\"\">
                           </div>
                           ";
                if ($result->username != $_SESSION['username']) {
                    print "<form method=\"post\" action=\"./?c=user&d=users\" 
                          onsubmit=\"return window.confirm('Are you sure you want to delete the user: ".$result->username." ?');
                          \" class=\"delete-user-form\">
                          
                              <input type=\"submit\" class=\"delete-user-icon\" value=\"\">
                              <input type=\"hidden\" name=\"user\" value=\"".$result->username."\">
                              <input type=\"hidden\" name=\"CMD\" value=\"removeUser\">
                           </form>";
                }
                print "</td></tr>";
        $rowNum++;
        }
    ?>

<script>
function updateUser(id){

    var userName = document.getElementById("userName"+id).innerHTML;                 
    var password = document.getElementById("password"+id).value;
    var date_registered= document.getElementById("date_registered"+id).value;
    var fName = document.getElementById("fName"+id).value;
    var lName = document.getElementById("lName"+id).value;
    var email = document.getElementById("email"+id).value;
    var address = document.getElementById("address"+id).value;
    var phone = document.getElementById("phone"+id).value;
    
    $.post("./?c=user",{
        CMD: "updateUser",
        username:userName, 
        password:password, 
        date_registered:date_registered,
        fname:fName, 
        lname:lName, 
        email:email, 
        address:address,
        phone:phone}
    ).done(function(msg){
        alert(msg);
    });
}

</script>

</table>        
<?php ##TODO: PUT IN PAGINATION LINKS ?>
