<?php if (isset($_SESSION['error'])){ ?>
<div class="form-error">
	<p class="text-error">
	<?php
		$error = unserialize($_SESSION['error']);
		print $error->getMessage();
		unset($_SESSION['error']);
	?>
	</p>
</div>
<?php } ?>