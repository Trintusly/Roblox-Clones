<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("bopimo.php");

$text = "https://www.bopimo.com/forum/";

$text = preg_replace('|([\w\d]*)\s?(https?://(www.bopimo.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);

echo $text;
?>
