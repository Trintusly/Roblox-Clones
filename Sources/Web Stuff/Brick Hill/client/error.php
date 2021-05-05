<?php 

$errorCode = $_GET['e'];
$error = explode('bh-', $errorCode);
$error = $error['1'];

if ($error == "outdatedClient") {
	header("Location: /download/");
	echo '<script> window.location = "/download/"; </script>';
	die();
}

$errorArray = array (
	"a" => "The launcher cannot find the client. The client should be in \" C:\Program Files (x86)\Brick Hill\" and should be called Client.exe. ",
	"b" => "The URI that was provided is invalid. (Specifcally the uri scheme provided to little information or too much)"
);

echo $errorArray[$error];

?>