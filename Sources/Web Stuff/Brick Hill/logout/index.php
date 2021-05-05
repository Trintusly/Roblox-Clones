<?php 
session_name("BRICK-SESSION");
session_start();
unset($_SESSION['id']);
header('Location: ../login/');

?>