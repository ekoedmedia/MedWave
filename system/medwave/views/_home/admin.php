<ul class="nav nav-tabs">
	<li class="pull-right"><a href="./analysis">Data Analysis</a></li>
	<li class="pull-right"><a href="./report-gen">Report Generating</a></li>
	<li class="pull-right"><a href="./user-list">Manage Users</a></li>
</ul>

<div class="search-forms">
	<div style="instructions">
		<h4>Record Search</h4>
		<p>Search for records by typing in text, or specify a time range and sort order.</p>
	</div>
	<form action="./search-results" method="GET" class="form-search">
		<input type="text" name="search" class="search-query">
		<input type="submit" class="btn" value="Search">
	</form>
	<hr class="half"><span class="separaterText">OR</span>
	<form action="./search-results" method="GET">
		<input type="text" name="from" id="fromDate" rel="date" class="input-medium" placeholder="From">
		<input type="text" name="to" id="toDate" rel="date" class="input-medium" placeholder="To">
		<label for="orderD" class="radio">
			<input type="radio" name="order" value="desc" id="orderD">
			Most Recent First
		</label>
		<label for="orderA" class="radio">
			<input type="radio" name="order" value="asc" id="orderA">
			Most Recent Last
		</label>
		<input type="submit" class="btn" value="Search">
	</form>
</div>