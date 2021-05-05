<?php 

$method = $_GET['method'];

$versionsArray = array (
	"clientVersion" => "0ziOuxj.0.cV",
	"launcherVersion" => "0ziOuxj.0.lV"
);

if ( $method == "clientVersion" ) {
	echo $versionsArray[$method];
} elseif ( $method == "launcherVersion" ) {
	echo $versionsArray[$method];
} else {
	foreach ( $versionsArray as $version ) {
		echo $version."<br>";
	}
}

?>