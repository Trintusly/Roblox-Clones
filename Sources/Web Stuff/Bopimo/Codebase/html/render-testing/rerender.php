<?php 

include("render-class.php");
$bopimo = new bopimo;
$blender = new blender;
error_reporting(E_ALL); ini_set('display_errors', 1); 
if ($bopimo->local_info()->id == 4) {
	

	$id = $_GET["page"];

	$page = $id;
	$amount = 50;
	print("SELECT * FROM `users` ORDER BY `users`.`lastseen` DESC LIMIT ".((string) ($page * $amount)).", ".((string) $amount)."");
	$penis = $bopimo->query("SELECT * FROM `users` ORDER BY `users`.`lastseen` DESC LIMIT ".((string) ($page * $amount)).", ".((string) $amount)."");
	#$penis = $bopimo->query("SELECT * FROM items WHERE category = ? LIMIT ?", [$page, $page]);
	#var_dump([$page * $amount, $amount]);
	$boob = $penis->fetchAll(PDO::FETCH_ASSOC);
	echo "<br>";
	foreach ($boob as $user) {
		print "rendering " . $user['username'] . " (" . $user['id'] . ")";
		$blender->renderAvatar($user['id']);
		print "<br>";
	}
}