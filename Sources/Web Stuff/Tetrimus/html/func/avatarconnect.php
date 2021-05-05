<?php
$host = "localhost";
$user = "admin";
$pass = "423d464f1bc6033317e7372966e91a0cb9081d67ef4ee00a";
$name = "tetrimusdb";

$conn = new MySQLi($host, $user, $pass, $name);

if ($conn->connect_errno) {
    die("ERROR : -> " . $conn->connect_error);
}
/* Not needed.
 if(!$conn) {
	die("Database Error");
}
*/
if(session_status() == PHP_SESSION_NONE) {
	session_name("TetrimusSessio");
	session_start();
}

$loggedIn = isset($_SESSION['id']);

$query = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['id']);
$userRow = mysqli_fetch_array($query);

$CurrentUser = $conn->query("SELECT * FROM users WHERE id='".$userRow['id']."'");
$user = mysqli_fetch_object($CurrentUser);
?>
