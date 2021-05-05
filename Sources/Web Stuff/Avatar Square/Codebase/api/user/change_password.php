<?php
if ($user) {
$oldpw = $_POST['current_password'];
$newpw = $_POST['new_password'];
$newpwagain = $_POST['new_password_again'];
$submit = $_POST['pw_submit'];
$oldencrypt1 = hash('sha512',$oldpw);
$oldencrypt = hash('sha512',$oldencrypt1);
$encrypt1 = hash('sha512',$newpw);
$encrypt = hash('sha512',$encrypt1);
if ($submit) {
if (!$oldpw||!$newpw||!$newpwagain) {
echo "<div class='chng-pw-alert'><p class='basic-font chng-pw-alert-txt'>There are missing fields</p></div>";
} elseif ($newpw != $newpwagain) {
echo "<div class='chng-pw-alert'><p class='basic-font chng-pw-alert-txt'>New password and new password again do not match</p></div>";
} elseif ($oldencrypt != $myu->password) {
echo "<div class='chng-pw-alert'><p class='basic-font chng-pw-alert-txt'>Incorrect password</p></div>";
} elseif (strlen($password) <= 4) {
echo "<div class='chng-pw-alert'><p class='basic-font chng-pw-alert-txt'>Your new password is too short</p></div>";
} elseif ($newpw == $myu->password) {
echo "<div class='chng-pw-alert'><p class='basic-font chng-pw-alert-txt'>You are already using this password</p></div>";
} else {
$changePassword1 = "UPDATE users SET password=:password WHERE username=:username";
$changePassword = $handler->prepare($changePassword1);
$changePassword->execute(array(':password' => $encrypt, ':username' => $myu->username));
$to = "$myu->email";
$subject = "$myu->username's password has been changed";
$message = <<<EMAIL
$myu->username's password has been changed.
header("Location: ../../Landing");
}
}
}
?>