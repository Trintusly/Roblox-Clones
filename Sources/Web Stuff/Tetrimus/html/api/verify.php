<?php
include '../func/connect.php';

// These arent used in any querys so I think it's fine to just use them like this.
$auth_key = $_GET['auth_key'];
$format = $_GET['format'];
$code = $_GET['code'];

$getUsers = $conn->query("SELECT * FROM users");

$verified = false;
$username = "none";

while($allUsers = mysqli_fetch_object($getUsers)) {
   // I guess I could make a function for this but there's really no need.
   $part1 = md5($allUsers->username);
   $part2 = md5($allUsers->password);
   $part3 = md5($allUsers->email);
   $combine = ''.$part1.''.$part2.''.$part3.'';
   $complete = substr(md5($combine),12);

   if($code == $complete) {
        if($allUsers->discordVerification == 0) {
        $verified = true;
        $username = $allUsers->username;
     }else{
        $verified = false;
        $username = $allUsers->username;      
     }
   }
}


if($auth_key == "alksfhebwaeuifipwaeuhpogh09a347gh92843gh9a423g") {
if($verified == true) {
    $conn->query("UPDATE users SET discordVerification = '1' WHERE username = '$username'");
    echo '{"name":"'.$username.'", "status":"valid"}'; 
}else{
    echo '{"name":"none", "status":"invalid"}';   
}

}else{
  echo 'You do not have permission to access this page.';
}
?>