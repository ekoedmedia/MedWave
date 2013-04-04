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
				ORDER BY (6*freq1)+(3*freq2)+(freq3) DESC";
		$stmt = $dbcon->prepare($sql);
		$stmt->execute(array(":search" => $_GET['search']."*"));

	// Get Records from Specified Time Range
	} elseif (isset($_GET['to']) && isset($_GET['from']) && isset($_GET['order'])) {
		$from = date('Y-m-d', strtotime(urldecode($_GET['from'])));
		$to = date('Y-m-d', strtotime(urldecode($_GET['to'])));
		if ($_GET['order'] == 'desc')
			$sql = "SELECT * FROM radiology_record WHERE test_date BETWEEN :from AND :to ORDER BY test_date DESC";
		else 
			$sql = "SELECT * FROM radiology_record WHERE test_date BETWEEN :from AND :to ORDER BY test_date ASC";
		$stmt = $dbcon->prepare($sql);
		$stmt->execute(array(":from" => $from, ":to" => $to));
	} else {
		$error = new MedWave\Model\Error('Search', '9000', 'Invalid search parameters.');
		$_SESSION['error'] = serialize($error);
		header('Location: ./home');
	}
?>
<div class="content-wrapper">
	<hr>
	<div class="search-results">
		<?php
			$i = 0; // Used for displaying if there are no results or not.
			// Start printing out information on records.
			while ($results = $stmt->fetch(\PDO::FETCH_LAZY)) {
				$i = 1;
				print "<div class=\"record media\">";
					// Get Images from Database for Record ID
					$sql = "SELECT image_id FROM pacs_images WHERE record_id=:record_id";
					$stmtImg = $dbcon->prepare($sql);
					$stmtImg->execute(array(":record_id" => $results->record_id));
					print "<div class=\"images pull-left\">";
						while ($imgs = $stmtImg->fetch(\PDO::FETCH_LAZY)) {
							print "<div class=\"media-object\" style=\"margin-bottom:5px;\">";
								print "<div>";
								print "<img src=\"./record-image?iid=".$imgs->image_id."&rid=".$results->record_id."&fmt=thumb\" rel=\"recordImgThumb\" alt=\"Full Size\" style=\"\">";
								print "<img src=\"./record-image?iid=".$imgs->image_id."&rid=".$results->record_id."&fmt=reg\" rel=\"recordImgReg\" alt=\"Regular Size\" style=\"display:none;\">";
								print "</div>";
								print "<a style=\"display:none;margin:10px auto;\" class=\"btn btn-info\" rel=\"recordImgFull\" href=\"./record-image?iid=".$imgs->image_id."&rid=".$results->record_id."&fmt=full\" target=\"_blank\">View Full Size</a>";
							print "</div>";
						}
					print "</div>";

					// Record Informations
					print "<div class=\"media-body\">";
						print "<h4 class=\"media-heading\">Record ID: ".$results->record_id."</h4>";

						// Query for actual names
						$sql = "SELECT first_name, last_name FROM persons WHERE user_name=:name";
						$stmtName = $dbcon->prepare($sql);
						$stmtName->execute(array(":name" => $results->patient_name));
						$names = $stmtName->fetch(\PDO::FETCH_LAZY);
						print "<div class=\"patient\"><strong>Patient:</strong> ".$names->first_name." ".$names->last_name." (".$results->patient_name.")</div>";

						$stmtName = $dbcon->prepare($sql);
						$stmtName->execute(array(":name" => $results->doctor_name));
						$names = $stmtName->fetch(\PDO::FETCH_LAZY);
						print "<div class=\"doctor\"><strong>Doctor:</strong> ".$names->first_name." ".$names->last_name." (".$results->doctor_name.")</div>";
					
						$stmtName = $dbcon->prepare($sql);
						$stmtName->execute(array(":name" => $results->radiologist_name));
						$names = $stmtName->fetch(\PDO::FETCH_LAZY);
						print "<div class=\"radiologist\"><strong>Radiologist:</strong> ".$names->first_name." ".$names->last_name." (".$results->radiologist_name.")</div>";
						
						print "<div class=\"testType\"><strong>Test Type:</strong> ".$results->test_type."</div>";
						print "<div class=\"prescribingDate\"><strong>Prescribing Date:</strong> ".$results->prescribing_date."</div>";
						print "<div class=\"testDate\"><strong>Test Date:</strong> ".$results->test_date."</div>";
						print "<div class=\"diagnosis\"><strong>Diagnosis:</strong> ".$results->diagnosis."</div>";
						print "<div class=\"description\"><strong>Description:</strong><br>".$results->description."</div>";
					print "</div>";
				print "</div>";
				print "<hr>";
			}
			if ($i == 0)
				print "<div class=\"no-results\">No results for your search.</div>";
		?>
	</div>
</div>
<script>
	// Clicking functions to show and hide different sizes of thumbnails.
	$('[rel="recordImgThumb"]').click(function(){
		$(this).hide();
		$(this).parent().find('[rel="recordImgReg"]').show();
		$(this).parent().parent().find('[rel="recordImgFull"]').show();
	});
	$('[rel="recordImgReg"]').click(function(){
		$(this).hide();
		$(this).parent().find('[rel="recordImgThumb"]').show();
		$(this).parent().parent().find('[rel="recordImgFull"]').hide();
	});
</script>