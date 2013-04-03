<?php
	// Get Records based on Specified Search
	if (isset($_GET['search'])) {
		$sql = "SELECT r.record_id AS record_id,
					   r.patient_name AS patient_name,
					   r.doctor_name AS doctor_name,
					   r.radiologist_name AS radiologist_name,
					   r.test_type AS test_type,
					   r.prescribing_date AS prescribing_date,
					   r.test_date AS test_date, 
					   r.diagnosis AS diagnosis,
					   r.description AS description,
					   MATCH(s.patient_name) AGAINST(:search IN BOOLEAN MODE) AS freq1, 
					   MATCH(s.diagnosis) AGAINST(:search IN BOOLEAN MODE) AS freq2,
					   MATCH(s.description) AGAINST(:search IN BOOLEAN MODE) AS freq3
				FROM radiology_search s INNER JOIN radiology_record r ON s.record_id=r.record_id
				WHERE MATCH(s.patient_name, s.diagnosis, s.description) AGAINST(:search IN BOOLEAN MODE)
				AND r.doctor_name=:user 
				ORDER BY (6*freq1)+(3*freq2)+(freq3) DESC";
		$stmt = $dbcon->prepare($sql);
		$stmt->execute(array(":search" => $_GET['search']."*", ":user" => $_SESSION['username']));

	// Get Records from Specified Time Range
	} elseif (isset($_GET['to']) && isset($_GET['from']) && isset($_GET['order'])) {
		$from = date('Y-m-d', strtotime(urldecode($_GET['from'])));
		$to = date('Y-m-d', strtotime(urldecode($_GET['to'])));
		if ($_GET['order'] == 'desc')
			$sql = "SELECT * FROM radiology_record WHERE doctor_name=:user AND test_date BETWEEN :from AND :to ORDER BY test_date DESC";
		else 
			$sql = "SELECT * FROM radiology_record WHERE doctor_name=:user AND test_date BETWEEN :from AND :to ORDER BY test_date ASC";
		$stmt = $dbcon->prepare($sql);
		$stmt->execute(array(":from" => $from, ":to" => $to, ":user" => $_SESSION['username']));
	} else {
		$error = new MedWave\Model\Error('Search', '9000', 'Invalid search parameters.');
		$_SESSION['error'] = serialize($error);
		header('Location: ./home');
	}
?>
<div class="content-wrapper">
	<div class="search-results">
		<?php
			$i = 0; // Used for displaying if there are no results or not.
			// Start printing out information on records.
			while ($results = $stmt->fetch(\PDO::FETCH_LAZY)) {
				$i = 1;
				print "<div class=\"record\">";
					// Get Images from Database for Record ID
					$sql = "SELECT image_id FROM pacs_images WHERE record_id=:record_id";
					$stmtImg = $dbcon->prepare($sql);
					$stmtImg->execute(array(":record_id" => $results->record_id));
					print "<div class=\"images\">";
						while ($imgs = $stmtImg->fetch(\PDO::FETCH_LAZY)) {
							print "<div>";
								print "<img src=\"./record-image?iid=".$imgs->image_id."&rid=".$results->record_id."&fmt=thumb\" rel=\"recordImgThumb\" alt=\"Full Size\" style=\"\">";
								print "<img src=\"./record-image?iid=".$imgs->image_id."&rid=".$results->record_id."&fmt=reg\" rel=\"recordImgReg\" alt=\"Regular Size\" style=\"display:none;\">";
								print "<a style=\"display:none;\" rel=\"recordImgFull\" href=\"./record-image?iid=".$imgs->image_id."&rid=".$results->record_id."&fmt=full\" target=\"_blank\">View Full Size</a>";
							print "</div>";
						}
					print "</div>";

					// Record Informations
					print "<div class=\"rid\"><span>Record ID:</span> ".$results->record_id."</div>";

					// Query for actual names
					$sql = "SELECT first_name, last_name FROM persons WHERE user_name=:name";
					$stmtName = $dbcon->prepare($sql);
					$stmtName->execute(array(":name" => $results->patient_name));
					$names = $stmtName->fetch(\PDO::FETCH_LAZY);
					print "<div class=\"patient\"><span>Patient:</span> ".$names->first_name." ".$names->last_name." (".$results->patient_name.")</div>";

					$stmtName = $dbcon->prepare($sql);
					$stmtName->execute(array(":name" => $results->doctor_name));
					$names = $stmtName->fetch(\PDO::FETCH_LAZY);
					print "<div class=\"doctor\"><span>Doctor:</span> ".$names->first_name." ".$names->last_name." (".$results->doctor_name.")</div>";
				
					$stmtName = $dbcon->prepare($sql);
					$stmtName->execute(array(":name" => $results->radiologist_name));
					$names = $stmtName->fetch(\PDO::FETCH_LAZY);
					print "<div class=\"radiologist\"><span>Radiologist:</span> ".$names->first_name." ".$names->last_name." (".$results->radiologist_name.")</div>";
					
					print "<div class=\"testType\"><span>Test Type:</span> ".$results->test_type."</div>";
					print "<div class=\"prescribingDate\"><span>Prescribing Date:</span> ".$results->prescribing_date."</div>";
					print "<div class=\"testDate\"><span>Test Date:</span> ".$results->test_date."</div>";
					print "<div class=\"diagnosis\"><span>Diagnosis:</span> ".$results->diagnosis."</div>";
					print "<div class=\"description\"><span>Description:</span><br>".$results->description."</div>";
				print "</div>";
			}
			if ($i == 0)
				print "<div class=\"no-results\">No results for your search. <a href=\"./home\">Back</a></div>";
		?>
	</div>
</div>
<script>
	// Clicking functions to show and hide different sizes of thumbnails.
	$('[rel="recordImgThumb"]').click(function(){
		$(this).hide();
		$(this).parent().find('[rel="recordImgReg"]').show();
		$(this).parent().find('[rel="recordImgFull"]').show();
	});
	$('[rel="recordImgReg"]').click(function(){
		$(this).hide();
		$(this).parent().find('[rel="recordImgThumb"]').show();
		$(this).parent().find('[rel="recordImgFull"]').hide();
	});
</script>