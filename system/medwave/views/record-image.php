<?php
	/**
	 * Displays Record Image based on values from Database
	 * based on parameters passed to it.
	 */

	include '_base/check.auth.php';
	$dir = dirname(__FILE__);
	// If iid is not set/valid display no image
	if (!isset($_GET['iid']) || !is_numeric($_GET['iid'])) {
		header('Content-type: image/jpeg');
		print file_get_contents($dir.'/_search/no-image.jpg');
	// If rid is not set/valid display no iamge
	} elseif (!isset($_GET['rid']) || !is_numeric($_GET['rid'])) {
		header('Content-type: image/jpeg');
		print file_get_contents($dir.'/_search/no-image.jpg');
	// If fmt is not set display no image
	} elseif (!isset($_GET['fmt'])) {
		header('Content-type: image/jpeg');
		print file_get_contents($dir.'/_search/no-image.jpg');
	} else {
		if ($_GET['fmt'] == 'thumb') {
			$sql = "SELECT thumbnail AS img FROM pacs_images WHERE record_id=:rid AND image_id=:iid";
		} elseif ($_GET['fmt'] == 'reg') {
			$sql = "SELECT regular_size AS img FROM pacs_images WHERE record_id=:rid AND image_id=:iid";
		} else {
			$sql = "SELECT full_size AS img FROM pacs_images WHERE record_id=:rid AND image_id=:iid";
		}
		$stmt = $dbcon->prepare($sql);
		$stmt->execute(array(":iid" => $_GET['iid'], ":rid" => $_GET['rid']));
		$result = $stmt->fetch(\PDO::FETCH_LAZY);
		header('Content-type: image/jpeg');
		print $result->img;
	}
?>