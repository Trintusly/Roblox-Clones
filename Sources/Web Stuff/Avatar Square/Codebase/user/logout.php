<?php
include('../Site/init.php');
$handler->query("UPDATE users SET expiretime='0' WHERE username='$user'");
session_start();
session_destroy();
header('Location: ../');
exit();
die();
?>