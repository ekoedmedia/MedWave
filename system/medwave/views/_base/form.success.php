<?php if (isset($_SESSION['success'])){ ?>
<div class="form-success">
	<?php
		$error = unserialize($_SESSION['success']);
		print $error->getMessage();
		unset($_SESSION['success']);
	?>
</div>
<?php } ?>