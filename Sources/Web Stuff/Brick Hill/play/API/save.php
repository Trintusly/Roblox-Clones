<?php
if (isset($_GET['id'])) {
	$file = $_GET['id'].".txt";
	echo file_get_contents($file);
}
?>