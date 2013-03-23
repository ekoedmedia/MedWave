
<html>
	<body>
		<form action="./?c=report&d=reports" method="POST">
			<label for="diagnosis">Diagnosis</label>
			<input type="text" name="diagnosis" id="diagnosis">
			<label>From</label>
			<input type="date" name="From">
			<label>To</label>
			<input type="date" name="To">
			<input type="submit" value="search">
			<input type="hidden" name="CMD" value="generate">
		</form>
	</body>
</html>