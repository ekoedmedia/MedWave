<?php

// Put here to make sure it is an AJAX request, so no errors happen.
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
                print
                "<form method=\"post\" action=\"./?c=user&d=users\" 
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
</table>        
<?php ##TODO: PUT IN PAGINATION LINKS ?>
