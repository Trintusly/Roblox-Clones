<?php
$DBhost = "localhost";
$DBuser = "admin";
$DBpass = "notonigiri7129";
$DBname = "tetrimus";

$con = new MySQLi($DBhost, $DBuser, $DBpass, $DBname);

if ($con->connect_errno) {
    die("ERROR : -> " . $con->connect_error);
}

$auth_key = trim($con->real_escape_string($_GET['auth_key']));
$format = trim($con->real_escape_string($_GET['format']));
$id = trim($con->real_escape_string($_GET['id']));

$fetch = $con->query("SELECT * FROM users where id='$id'");
$get = mysqli_fetch_object($fetch);

if($get->Gear != "none") {
	if($get->Gear2 != "none") {
		$secondgear = "true";
	}else{
	$secondgear = "false";
	}
}else{
$secondgear = "false";
}


if($auth_key == "71c184bbabb76b7e8b3719346b347f7d") {

	if($format == "true") {
		echo '<pre>';
	}

echo '
{
   "data":{
      "id":"'.$get->id.'",
      "type":"character",
      "links":{
         "self":"https://IgnoreThis.com"
      },
      "attributes":{
         "HeadColor":"'.$get->HeadColor.'",
         "TorsoColor":"'.$get->TorsoColor.'",
         "LeftArmColor":"'.$get->LeftArmColor.'",
         "RightArmColor":"'.$get->RightArmColor.'",
	 "LeftLegColor":"'.$get->LeftLegColor.'",
         "RightLegColor":"'.$get->RightLegColor.'",
         "Items":{
            "Face":"'.$get->Face.'",
            "Hat":"'.$get->Hat.'",';
if($get->Gear == "none"){
        echo '
	    "Gear":"false",';
}else{
	echo '
	    "Gear":"true",';
}
echo '
	    "Hat2":"'.$get->Hat2.'",
	    "Hat3":"'.$get->Hat3.'",
	    "tshirt":"'.$get->tshirt.'",
	    "shirt":"'.$get->shirt.'",
            "TwoGear":"'.$secondgear.'",
            "Gear":"'.$get->Gear.'",
            "rand":"'.$get->rand.'",
            "Gear2":"'.$get->Gear2.'"
         }
      }
   }
}
';

	if($format == "true") {
		echo '</pre>';
	}


}else{
echo "Seems this page doesnt exist.";
}
?>