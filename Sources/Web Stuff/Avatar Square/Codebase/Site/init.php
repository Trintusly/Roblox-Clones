<?php

error_reporting(0);
session_start();
session_id();
ob_start();
date_default_timezone_set('America/New_York');
session_name('avatar-kittens');
$user = $_SESSION['username'];
$encrypt = $_SESSION['hash'];
$admin = $_SESSION['admin'];

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


try {
	$handler = new PDO('mysql:host=sql304.byethost12.com;dbname=b12_21466421_db', 'b12_21466421', 'nick5501');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

$conn = mysql_connect("sql304.byethost12.com", "b12_21466421", "nick5501");
mysql_select_db("b12_21466421");

$Banner = $handler->query("SELECT * FROM banner");
$gB = $Banner->fetch(PDO::FETCH_OBJ);
$User = $handler->query("SELECT * FROM users");
$usr = $User->fetch(PDO::FETCH_OBJ);
$maintenance = $handler->query("SELECT * FROM refurbishment");
$mntnc = $maintenance->fetch(PDO::FETCH_OBJ);
$getipbans = $handler->query("SELECT * FROM ipbans WHERE ip='$ip'");
$ipban = ($getipbans->rowCount());
$gettopics = $handler->query("SELECT * FROM topics");
if ($ipban > 0) {
	die("ip banned");
	exit();
}
$handler->query("INSERT INTO iplogs (ip) VALUES('$ip')");

if ($user) {
$myusr = $handler->query("SELECT * FROM users WHERE username='".$user."'");
$myu = $myusr->fetch(PDO::FETCH_OBJ);
$userExist = ($myusr->rowCount());
if ($userExist == "0") {
session_destroy();
header("Location: /");
}
$handler->query("UPDATE users SET ip='$ip' WHERE username='$myu->username'");
$checkDatabase = $handler->query("SELECT * FROM userips WHERE ip='$ip' AND id='$myu->id'");
$cii = ($checkDatabase->rowCount());
if ($cii == "0") {
$handler->query("INSERT INTO userips (id, ip) VALUES('$myu->id','$ip')");
}
if ($encrypt != $myu->password) {
session_destroy();
}
}

if ($mntnc->status == "down"){
header("Location: /Site/Maintenance");
}

$now = time();
if ($now > $myu->getemeralds) {
$newemrlds = $now + 86400;
if ($myu->elite == 0) {
$amounttoadd = 15;
}
elseif ($myu->elite == 1) {
$amounttoadd = 30;
}
elseif ($myu->elite == 2) {
$amounttoadd = 50;
}
elseif ($myu->elite == 3) {
$amounttoadd = 70;
}
elseif ($myu->elite == 4) {
$amounttoadd = 100;
}
$handler->query("UPDATE users SET emeralds=emeralds + ".$amounttoadd." WHERE id='$myu->id'");
$handler->query("UPDATE users SET getemeralds='$newemrlds' WHERE id='$myu->id'");
}

if ($myu->banned == "1"){
header("Location: /Banned");
}

$now = time();
$timeout = 5; 
$xp = 60;
$expires = $now + $timeout*$xp;
$handler->query("UPDATE users SET visittick='$now' WHERE username='$user'");
$handler->query("UPDATE users SET expiretime='$expires' WHERE username='$user'");
?>