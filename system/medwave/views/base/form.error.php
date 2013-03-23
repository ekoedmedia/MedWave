<?php if (isset($_SESSION['error'])){ ?>
<div class="form-error">
	<?php
		$error = unserialize($_SESSION['error']);
		print $error->getMessage();
		unset($_SESSION['error']);
	?>
</div>
<?php } ?>