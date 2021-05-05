<?php

$imageFile = fopen("../../../storage_subdomain/images/avatars/1.png", "w") or die("Unable to open file!");
$data = "Potatoes are cool!";
fwrite($imageFile, $data);
fclose($imageFile);

?>