<?php
	include "Header.php";
	$ID = SecurePost($_GET['ID']);
header("Location: /Memberships/UpgradePay.php?ID=$ID");