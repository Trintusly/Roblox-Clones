<?php
ini_set('session.cookie_httponly', 1);
// error_reporting(E_ERROR | E_WARNING | E_PARSE); // E_ERROR | E_WARNING | E_PARSE | E_NOTICE are what can be reported.

//error_reporting(E_ALL); // Reports all errors warnings etc.
//We need to fix our errors but for now... 

error_reporting(0); // No errors. Use this if the site has activity and you don't want people finding visible vulnerabilities and warnings/errors.
// $conn = mysqli_connect( "localhost" , "root", "" , "test"); let's move this aside.

$host = "localhost";
$user = "admin";
$pass = "notonigiri7129";
$name = "tetrimus";

$conn = new MySQLi($host, $user, $pass, $name);

// Uses variables boilerplate to OOP related.
if ($conn->connect_errno) {
    die("ERROR : -> " . $conn->connect_error);
}
/* Not needed.
 if(!$conn) {
	die("Database Error");
}
*/
if(session_status() == PHP_SESSION_NONE) {
	session_name("TetrimusSess");
	session_start();
}

/*
if ( $detect->isMobile() ) { // This works for all mobile devices.
 echo'<meta http-equiv="refresh" content="0; url=/mobile">';
}
*/
/*if( $detect->isTablet() ){ These conditions parameters works but we don't need this.
}
if( $detect->isiOS() ){
}
if( $detect->isAndroidOS() ){
}
// Some browser detects.
$detect->is('Chrome')
$detect->is('iOS')
$detect->is('UC Browser')
*/

date_default_timezone_set("America/New_York"); // EST.
$time = date("Y-m-d - h:ia"); // Current timestamp.
$date = time();

// User variables.
$loggedIn = isset($_SESSION['id']);

$query = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['id']);
$userRow = mysqli_fetch_array($query);

$CurrentUser = $conn->query("SELECT * FROM users WHERE id='".$userRow['id']."'");
$user = mysqli_fetch_object($CurrentUser);
$username = $user->{'username'}; // Could just use $user->username OOP.

$now = time();
$date = time();
$conn->query("UPDATE users SET now='$date' WHERE id=".$_SESSION['id']);
        $now = time();
$timeout = 5;
$xp = 60;
$expires = $now + $timeout * $xp;
$conn->query("UPDATE users SET visitTick='$now' WHERE id='$user->id'");
$conn->query("UPDATE users SET expireTime='$expires' WHERE id='$user->id'");
// Daily Currency
if ($now > $user->gettc) {
	$newgettc = $now + 86400;
	if($user->membership == 'Diamond') {
		$TokensToAdd = 25;
		$CoinsToAdd = 10;
	}else{
		$TokensToAdd = 1;
		$CoinsToAdd = 10;	
	}
	$conn->query("UPDATE `users` SET `tokens` = tokens + ".$TokensToAdd." WHERE `id` = '$user->id'");
	$conn->query("UPDATE `users` SET `coins` = coins + ".$CoinsToAdd." WHERE `id` = '$user->id'");	
	$conn->query("UPDATE `users` SET `gettc` = '$newgettc' WHERE `id` ='$user->id'");
}

/*
$ip = $_SERVER['REMOTE_ADDR'];
if($ip == '73.57.233.199') { //byte312
	$tas = 1;
}else{
	echo "Tetrimus is undergoing maintenance";
	die();
}
*/

/*
the reason the variables below have weird names is cause this is included on
every part of the site including forums so i didnt wanna interfere with forum queries by accident 
*/
if($loggedIn) {

	if($user->banned == 1) {
	    header("Location: ../banned.php");
	}

	$find_reps = $conn->query("SELECT * FROM `replies` WHERE `poster`='$user->id'");
	$reps_num = mysqli_num_rows($find_reps);

	$find_pos = $conn->query("SELECT * FROM `threads` WHERE `poster`='$user->id'");
	$pos_num = mysqli_num_rows($find_pos);

	$total_pos_plus_reps = $reps_num + $pos_num;

	$conn->query("UPDATE `users` SET `replies`='$reps_num' WHERE `id`='$user->id'");
	$conn->query("UPDATE `users` SET `posts`='$pos_num' WHERE `id`='$user->id'");
	$conn->query("UPDATE `users` SET `total`='$total_pos_plus_reps' WHERE `id`='$user->id'");

	//start points system

	$threadCount = $user->posts * 1.5;
	$replyCount = $user->replies;
	$replyPoints = floor($replyCount * 0.50);
	$points = $threadCount + $replyPoints;
	$level = floor(0.25 * sqrt($points));


	$nextLevel = $level + 1;
	$getNextLevelPoints = $nextLevel / 0.25;
	$NextLevelPoints = $getNextLevelPoints * $getNextLevelPoints;

	//echo "sorry guys just need to post this here for testing: Threads: $threadCount | Replies: $replyCount | Points: $points | Level: $level | $points/$NextLevelPoints points until next level";

	$conn->query("UPDATE `users` SET `points`='$points' WHERE `id`='$user->id'");
	$conn->query("UPDATE `users` SET `level`='$level' WHERE `id`='$user->id'");
	$conn->query("UPDATE `users` SET `next_points`='$NextLevelPoints' WHERE `id`='$user->id'");

	//end points system

	if($user->banned == 1) {
		echo "<center>It seems you have been banned :(</center>";
		die();
	}
}
?>
