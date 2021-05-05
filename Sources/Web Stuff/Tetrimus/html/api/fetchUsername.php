<?php
include '../func/connect.php';

$clientType = 'adminClient';


if($user->power > 1){
    echo "adminClient";
}

$clientObj->username = "$user->username";
$clientObj->clientType = "$clientType";


$myJSON = json_encode($myObj);

echo $myJSON;
?>