<?php
    /**
     * Queries Database for Report Information then generates a table 
     * of data for use in Report Gen Results
     */
	$sql = "SELECT p.user_name AS username, p.first_name As nameF, p.last_name As nameL, p.address As address, p.phone AS phone, MIN(r.test_date) AS testDate, r.diagnosis As diagnosis
            FROM persons p RIGHT JOIN radiology_record r         
            ON p.user_name = r.patient_name 
            WHERE r.diagnosis=:diagnosis AND r.prescribing_date BETWEEN :from AND :to "; 
    $stmt = $dbcon->prepare($sql);
    $stmt->bindParam(':diagnosis', $diag);
    $stmt->bindParam(':from', $from);
    $stmt->bindParam(':to', $to);
    $stmt->execute();

    try {
        $i = 0;
        while ($result = $stmt->fetch(\PDO::FETCH_LAZY)) {
            if ($result->username != null)
                $i = 1;
            
            print " <tr> ";
            if (is_null($result->nameF) || is_null($result->nameL)){
            	$name = $result->username;
            } else {
            	$name = $result->nameF." ".$result->nameL." (".$result->username.")";
            }
            print  "<td>".$name."</td>
            		<td>".$result->address."</td>
            		<td>".$result->phone."</td>
            		<td>".$result->testDate."</td>
            		<td>".$result->diagnosis."</td>";
            print " </tr>";

        }
        if ($i == 0) {
            print "<caption style=\"margin-bottom:10px;\">No reports found for time period from: <b>".$from."</b> to: <b>".$to."</b></caption>";
        } else {
            print "<caption style=\"margin-bottom:10px;\">Reports found for time period from: <b>".$from."</b> to: <b>".$to."</b></caption>";
        }
    } catch(\PDOException $e) {
        print $e->getMessage();
    }
                
?>