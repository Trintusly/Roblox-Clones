<?php
	if (isset($_POST['image'])) {
		$imageURI = $_POST['image'];
		echo "<img src='".$imageURI."'>";
	}
?>