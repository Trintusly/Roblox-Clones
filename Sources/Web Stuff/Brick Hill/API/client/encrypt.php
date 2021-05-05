<?php 

$launchString = "3";

$replaceArray = array(
	0 => "SDOCPAP34394L", // 0
	1 => "CNSA43278PDI4", // 1
	2 => "FHB43REW4AS6N", // 2
	3 => "ASD7VFGMHJDFG", // 3
	4 => "NCIRF42423VU4", // 4
	5 => "D940BXXAOER45", // 5
	6 => "52V852J8KV38Y", // 6
	7 => "ASD97DSF523VX", // 7
	8 => "XSDAPFOR94NA3", // 8
	9 => "STYU6GHJ4GDUU7", // 9
	"-" => "ASDU4G234L3VHJ" // -
);

/*

THIS IS FOR THE "KEY" FOR C#

foreach ($subArray as $targetvalue) {
	echo '.Replace( "'.$replaceArray[$targetvalue].'", "'.$targetvalue.'" )';
}

*/

echo strtr ($launchString , $replaceArray);

?>