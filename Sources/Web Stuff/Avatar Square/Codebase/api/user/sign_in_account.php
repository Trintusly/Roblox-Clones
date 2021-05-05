<?php
if (!$user) {
$username = $_POST['username'];
$password = $_POST['password'];
$submit = $_POST['submit'];
if ($submit) {
if (!$username || !$password) {
echo "<div class='sign-alert'><p class='basic-font sign-alert-txt'>You have missing fields</p></div>";
} else {
$encrypt1 = hash('sha512',$password);
$encrypt = hash('sha512',$encrypt1);
$checkUser1 = "SELECT * FROM users WHERE username=:username";
$checkUser = $handler->prepare($checkUser1);
$checkUser->execute(array(':username' => $username));
$cU = ($checkUser->rowCount());
if ($cU == 0) {
echo "<div class='sign-alert'><p class='basic-font sign-alert-txt'>That user does not exist</p></div>";
} else {
$getPassword1 = "SELECT * FROM users WHERE username=:username AND password=:password";
$getPassword = $handler->prepare($getPassword1);
$getPassword->execute(array(':username' => $username, ':password' => $password));
$gP = ($getPassword->rowCount());
if ($gP == 0) {
echo "<div class='sign-alert'><p class='basic-font sign-alert-txt'>That password is incorrect</p></div>";
} else {
$_SESSION['username']=$username;
$_SESSION['hash']=$password;						
header("Location: ../");					
}
}
}
}
} else {
header("Location: ../");
exit();	
}
?>