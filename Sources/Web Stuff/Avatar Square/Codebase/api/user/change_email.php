<?php
if ($user) {
$pw = $_POST['password'];
$email = $_POST['email'];
$submit = $_POST['email-submit'];
$encrypt1 = hash('sha512',$pw);
$encrypt = hash('sha512',$encrypt1);
if ($submit) {
if (!$pw||!$email) {
echo "<div class='chng-em-alert'><p class='basic-font chng-em-alert-txt'>There are missing fields</p></div>";	
} elseif ($encrypt != $myu->password) {
echo "<div class='chng-em-alert'><p class='basic-font chng-em-alert-txt'>Incorrect password</p></div>";
} elseif ($email == $myu->email) {
echo "<div class='chng-em-alert'><p class='basic-font chng-em-alert-txt'>You are already using this email</p></div>";
} else {
$to = "$myu->email";
$subject = "$myu->username's email has been changed";
$message = <<<EMAIL
$myu->username's email has been changed.

From Dimensious
EMAIL;
$header = "From: no-reply@dimensious.com";
mail($to, $subject, $message, $header);
$changeEmail1 = "UPDATE users SET email=:email WHERE username=:username";
$changeEmail = $handler->prepare($changeEmail1);
$changeEmail->execute(array(':email' => $email, ':username' => $myu->username));
header("Location: ../");
}
}
}
?>