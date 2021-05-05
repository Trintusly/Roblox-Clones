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

$fetch = $con->query("SELECT * FROM store where id='$id'");
$get = mysqli_fetch_object($fetch);


	$secondgear = "false";


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
         "HeadColor":"225/255,221/255,56/255",
         "TorsoColor":"16/255,113/255,184/255",
         "LeftArmColor":"225/255,221/255,56/255",
         "RightArmColor":"225/255,221/255,56/255",
	 "LeftLegColor":"135/255,155/255,58/255",
         "RightLegColor":"135/255,155/255,58/255",
         "Items":{
	    "Type":"'.$get->type.'",
	    "Item":"'.$get->texture.'",
            "Face":"face",
            "Hat":"none",
	    "GearEquip":"false",
	    "Hat2":"none",
	    "tshirt":"none.png",
	    "shirt":"none.png",
            "TwoGear":"false",
            "Gear":"none",
            "Gear2":"none"
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