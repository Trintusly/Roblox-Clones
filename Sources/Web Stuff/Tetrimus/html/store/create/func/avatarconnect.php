<?php
$host = "sql306.epizy.com";
$user = "epiz_22638840";
$pass = "aQNCvOxGeGZ";
$name = "epiz_22638840_tetrimus

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
