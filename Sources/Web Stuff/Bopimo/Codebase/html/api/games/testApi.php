<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$test = array();
$test['id'] = 1;
die(json_encode($test));
