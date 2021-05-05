<?php 

header('Content-Type: application/json');

include('../SiT_3/PHP/helper.php');

$directory = '../../storage_subdomain/assests/hats/models/';

/*if ($handle = opendir($directory)) { 
    while (false !== ($fileName = readdir($handle))) {  
		$newName = explode('.obj', $fileName);
        $newName = shopItemHash($newName[0]) . '.obj';
        rename($directory . $fileName, $directory . $newName);
    }
    closedir($handle);
}


/*$files = scandir($directory);
print_r($files);*/
?>