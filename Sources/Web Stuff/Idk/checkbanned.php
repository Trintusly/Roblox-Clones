<?php
/////////////////////////////////////////
//    Powered By : WindForce Studios   // 
/////////////////////////////////////////


include('config.php');
include('secureFunction.php');
include("Key.php");
include("getIP.php");

if(!empty($_GET['mac'])){
if($_GET['secureid'] != $SecureKey){
die("Secured! File");
}

$checkMAC = mysql_query("SELECT * FROM Users WHERE macAddresses='".make_safe($_GET['mac'])."'");

$stuts = mysql_num_rows($checkMAC);

if($stuts > 0 ){
	while($allUsers = mysql_fetch_array($checkMAC)){
	if($allUsers["banned"]== 1){
die("2"); // if user is exist and he got banned
}
}
	echo "1"; // if user is exist and he not got banned

}else{
echo "3"; // optional this check if you want disable user have multi account 3 mean new user
}

}else if(@$_GET["IP"]){
	$checkMAC = mysql_query("SELECT * FROM users WHERE IP='".make_safe($real_IP_adress)."'");
$stuts = mysql_num_rows($checkMAC);

if($stuts > 0 ){
	while($allUsers = mysql_fetch_array($checkMAC)){
	if($allUsers["banned"]== 1){
die("2"); // if user is exist and he got banned
}
}
	echo "1"; // if user is exist and he not got banned

}else{
echo "3"; // optional this check if you want disable user have multi account 3 mean new user
}

	
}


else{
	echo "Empty";
}





?>