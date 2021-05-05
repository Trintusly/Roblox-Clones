<?php 

header('Content-Type: Application/json');

function randSrting() {
	return chr(64+rand(1,26)).rand(0,9).chr(64+rand(0,26)).rand(0,9).chr(64+rand(0,26)).rand(0,9).rand(0,9).rand(0,9).chr(64+rand(0,26)).chr(64+rand(0,26)).chr(64+rand(0,26));  
}

for ($a = 0; $a < 10; $a++)  {
echo "\n".'$num'.$a.' = array (';
for ($i = 0; $i < 10; $i++)  {
	if ($i == 9) {
	echo "\n\t".'"'.randSrting().'"';
	} else {
		echo "\n\t".'"'.str_replace('@', 'D', randSrting()).'",';
	}
}
echo "\n".');';}
?>