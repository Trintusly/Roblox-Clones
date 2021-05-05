<?php 

include("../SiT_3/config.php");

$usersSQL = "SELECT * FROM `beta_users`";
$usersQuery = $conn->query($usersSQL);

while ($userRow = $usersQuery->fetch_assoc()) {
	$uid = bin2hex(random_bytes(20));
	$changeUidSQL = "UPDATE `beta_users` SET `unique_key` = '$uid' WHERE `id` = '" . $userRow['id'] . "' ";
	$changeUidQuery = $conn->query($changeUidSQL);
	if ($changeUidQuery) {
		echo '<div style="padding:5px;background-color:rgba(0,0,0,0.1);">Success!!</div>';
	}
}

?>