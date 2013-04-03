<div class="content-wrapper">
	<div class="content-header">
		<div class="content__search">
			<div>Record Search</div>
			<form action="./search-results" method="GET">
				<input type="text" name="search"><input type="submit" value="Search">
			</form><span>OR</span>
			<form action="./search-results" method="GET">
					<label for="fromDate">From:</label><input type="text" name="from" id="fromDate" rel="date">
					<label for="toDate">To:</label><input type="text" name="to" id="toDate" rel="date">
					<input type="submit" value="Search">
			</form>
		</div>
		<ul class="content__nav">
			<li><a href="./uploading-module">Upload Module</a></li>
		</ul>
	</div>
</div>