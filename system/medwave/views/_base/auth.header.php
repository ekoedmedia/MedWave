<?php 
	// Minor PHP for Style Purposes
	$request = $_SERVER['REQUEST_URI']; 
	if (false !== strpos($request, 'home')) {
		$home = "active";
		$account = "";
	} elseif (false !== strpos($request, 'account')) {
		$home = "";
		$account = "active";
	} else {
		$home = "";
		$account = "";
	}
?>

<div class="navbar navbar-fixed-top">
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="#">Hello, <?php print $username; ?></a>
				<ul class="nav">
					<li class="<?php print $home; ?>"><a href="./home" title="Home">Home</a></li>
					<li class="<?php print $account; ?>"><a href="./account" title="Account">Account</a></li>
				</ul>
				<form action="./?c=user&d=./" method="POST" class="pull-right navbar-form">
	    			<input type="submit" value="Logout" class="btn btn-primary">
	    			<input type="hidden" name="CMD" value="unauthenticate">
	    		</form>
			</div>
		</div>
	</div>
</div>