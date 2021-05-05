<?php
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);

require("/var/www/html/site/bopimo.php");

if($bop->logged_in())
{
	die();
}

if(empty($_POST['username']) || empty($_POST['pw1']))
{
	//one field wasn't filled out
	die("err1");
}

$username = $_POST['username'];
$pw1 = $_POST['pw1'];

if(!$bop->user_exists($username)) //if it does exist
{
	die("err2");
}
$user = $bop->look_for("users", ["username" => $username]);
if(!password_verify($pw1, $user->password))
{
	die("err3");
}
$agent = $_SERVER['HTTP_USER_AGENT']??"";
$ip = json_decode($bop->ipInfo($_SERVER['REMOTE_ADDR']));
$id = $user->id;
if (isset($ip->code)) {
	if ($ip->code == "TooManyRequests") {
		$insert = $bop->query("INSERT INTO login VALUES (NULL, ? , ?, ?, now(), ?, ?)", [$id, $agent, $_SERVER['REMOTE_ADDR'], "-1", "unk"]);
		die("err4");
	}
} else {
$isVpn = ($ip->block == 1) ? 1 : 0;
$insert = $bop->query("INSERT INTO login VALUES (NULL, ? , ?, ?, now(), ?, ?)", [$id, $agent, $ip->ip, $isVpn, $ip->countryCode ]);
}
$_SESSION['id'] = $user->id;

//$bop->generateCsrfToken();
die("succ");
?>
