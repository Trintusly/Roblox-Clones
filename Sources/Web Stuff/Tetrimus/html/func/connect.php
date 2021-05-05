<?php
ini_set('session.cookie_httponly', 1);
// error_reporting(E_ERROR | E_WARNING | E_PARSE); // E_ERROR | E_WARNING | E_PARSE | E_NOTICE are what can be reported.

//error_reporting(E_ALL); // Reports all errors warnings etc.
//We need to fix our errors but for now... 

error_reporting(0); // No errors. Use this if the site has activity and you don't want people finding visible vulnerabilities and warnings/errors.
// $conn = mysqli_connect( "localhost" , "root", "" , "test"); let's move this aside.

$host = "localhost";
$user = "admin";
$pass = "423d464f1bc6033317e7372966e91a0cb9081d67ef4ee00a";
$name = "tetrimusdb";

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
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


$user_os        = getOS();
$user_browser   = getBrowser();

$device_details = "<strong>Browser: </strong>".$user_browser."<br /><strong>Operating System: </strong>".$user_os."";





// User variables.
$loggedIn = isset($_SESSION['id']);
$currentDate = time();
$conn->query('UPDATE `users` SET `last_login` = "' . $currentDate . '"');

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
$currentDate = time();
$conn->query('UPDATE `users` SET `last_login` = "' . $currentDate . '"');
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
	echo "Tetrimus is preparing for client release.";
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
