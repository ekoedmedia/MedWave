<?php

// Put here to make sure it is an AJAX request, so no errors happen.
if (isset($_GET['ajax']))
    include "../../../system.php";

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $page = $_GET['p'];
} else{
    $page = 0;
}
$sql = "SELECT doctor_name,patient_name FROM family_doctor WHERE 1";
$stmt = $dbcon->prepare($sql);
$stmt->execute();
?>

<table border="1" id="doctor_table">

    <tr>
        <th>Doctor</th><th>Patient</th><th>Controls</th>
    </tr>
    <?php    
        $rowNum=0;
        while ($result = $stmt->fetch(\PDO::FETCH_LAZY)) {
              print "<tr id=".$rowNum.">";
                print "<td><div id=\"doctor-name".$rowNum."\" contenteditable>".$result->doctor_name."</div></td>";
                print "<td><div id=\"patient-name".$rowNum."\"contenteditable>".$result->patient_name."</div></td>";              
                print "<td class=\"user-management-controls\">
                      <form method=\"post\" id=\"updateDoctor\"
                        onsubmit=\"familyDoctorUpdate(".$rowNum.")\" class=\"update-doctor-form\">                        
                            <input type=\"submit\" class=\"update-user-icon\" value=\"\">
                            <input type=\"hidden\" name=\"user\" value=\"".$result->doctor_name."\">
                            <input type=\"hidden\" name=\"CMD\" value=\"updateDoctor\">
                        </form>
                      
                        <form method=\"post\" action=\"./?c=user&d=users\" 
                        onsubmit=\"return window.confirm('Are you sure you want to delete entry for doctor: ".$result->doctor_name." ?');
                        \" class=\"delete-user-form\">
                            <input type=\"submit\" class=\"delete-user-icon\" value=\"\">
                            <input type=\"hidden\" name=\"user\" value=\"".$result->doctor_name."\">
                            <input type=\"hidden\" name=\"CMD\" value=\"removeUser\">
                        </form>
                     </td>";
  
              print"</tr>";          
        $rowNum++;
        }
    ?>
</table>
<script>
function familyDoctorUpdate(r){
      var dName = document.getElementById("doctor-name"+r);
      var pName= document.getElementById("patient-name"+r);    
      allvars=dName.innerHTML+" "+pName.innerHTML;
      alert(allvars);
}
</script>        
<?php ##TODO: PUT IN PAGINATION LINKS ?>
