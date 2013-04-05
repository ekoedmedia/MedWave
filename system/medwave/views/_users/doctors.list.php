<?php

/**
 * Gets the list of Doctor and Patients in the family_doctor table and displays them
 * in a table.
 */

// Checks if this is an AJAX request, includes base system if it is
if (isset($_GET['ajax']))
    include "../../../system.php";

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $page = $_GET['p'];
} else{
    $page = 0;
}
$sql = "SELECT doctor_name, patient_name FROM family_doctor WHERE 1";
$stmt = $dbcon->prepare($sql);
$stmt->execute();
?>

<table class="table table-striped table-hover table-bordered table-condensed" id="doctor_table">

    <tr>
        <th>Doctor</th><th>Patient</th><th>Controls</th>
    </tr>
    <?php    
        $rowNum=0;
        while ($result = $stmt->fetch(\PDO::FETCH_LAZY)) {
              print "<tr id=".$rowNum.">";
                print "<td><div id=\"doctor-name".$rowNum."\">".$result->doctor_name."</div></td>";
                print "<td><div id=\"patient-name".$rowNum."\">".$result->patient_name."</div>";              
                print "<div id=\"old-patient-name".$rowNum."\" style=\"display:none;\">".$result->patient_name."</div></td>";              

                print "<td class=\"user-management-controls\">
                        <form method=\"post\" action=\"./?c=user&d=doctor-list\" 
                        onsubmit=\"return window.confirm('Are you sure you want to delete entry for doctor: ".$result->doctor_name." ?');
                        \" class=\"delete-user-form\">
                            <button type=\"submit\" class=\"btn\"><i class=\"icon-trash\"></i></button>
                            <input type=\"hidden\" name=\"doctor\" value=\"".$result->doctor_name."\">
                            <input type=\"hidden\" name=\"patient\" value=\"".$result->patient_name."\">
                            <input type=\"hidden\" name=\"CMD\" value=\"removeFamilyDoctor\">
                        </form>
                     </td>";
  
              print"</tr>";          
        $rowNum++;
        }
    ?>
</table>
<script type="text/javascript" src="media/js/jquery.min.js"></script>
<script>
function familyDoctorUpdate(r){
      var dName = document.getElementById("doctor-name"+r).innerHTML;
      var pName= document.getElementById("patient-name"+r).innerHTML;    
      var opName= document.getElementById("old-patient-name"+r).innerHTML;    

      $.post("./?c=user",{CMD: "updateDoctor",doctor:dName,patient:pName,oldpatient:opName}
      );

}
</script>        
<?php ##TODO: PUT IN PAGINATION LINKS ?>
