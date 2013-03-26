<html>
	<head>
		<title>
			uploade record
		</title>
	</head>

	<body>
		<form action="./?c=upload&d=home" method="post" enctype="multipart/form-data" action="uploade.php" method="POST">
			Record ID: <input type="text" name="record_id" value=""><br>
			Patient Name: <input type="text" name="patient" value=""><br>
			Doctor Name: <input type="text" name="doctor_name" value=""><br>
			radiologist Name: <input type="text"name="radiologist_name" value=""><br>
			Test Type: <input type="text" name="test_type" value=""><br>
			prescribing Date: <input type="text" name="prescribing_date" value=""><br>
			Test Date: <input type="text" name="test_date" value=""><br>
			Diagnosis: <input type="text" name="diagnosis" value=""><br>
			Description: <input type="text" name="description" value=""><br>
			<input type="hidden" name="CMD" value="upload">
						
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000000000" >
			Choose a file to upload: <input name="uploadedfile[]" type="file" multiple="multiple" /><br />
				<input type="submit" value="submit record">
		</form>
	</body>

</html>