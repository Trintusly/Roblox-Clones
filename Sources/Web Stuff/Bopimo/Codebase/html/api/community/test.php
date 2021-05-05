<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/api/community/class.php");
$thing = $com->createTag(1, "Test");
var_dump($thing);

?>
