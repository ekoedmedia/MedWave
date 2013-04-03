<div class="content-wrapper">
	<div class="content-header">
		<div class="content__search">
			<div>Record Search</div>
			<form action="./search-results" method="GET">
				<input type="text" name="search"><input type="submit" value="Search">
			</form>
			<span>OR</span>
			<form action="./search-results" method="GET">
				<label for="fromDate">From:</label><input type="text" name="from" id="fromDate" rel="date">
				<label for="toDate">To:</label><input type="text" name="to" id="toDate" rel="date">
				<input type="radio" name="order" value="desc" id="orderD"><label for="orderD">Most Recent First</label>
				<input type="radio" name="order" value="asc" id="orderA"><label for="orderA">Most Recent Last</label>
				<input type="submit" value="Search">
			</form>
		</div>
		<ul class="content__nav">
			<li><a href="./report-gen">Report Generating</a></li>
			<li><a href="./user-list">Manage Users</a></li>
			<li><a href="./analysis">Data Analysis</a></li>
		</ul>
	</div>
</div>