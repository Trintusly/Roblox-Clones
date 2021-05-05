<?php 

	include('../SiT_3/PHP/helper.php');
	
	$numarray = array(
		1,
		2,
		3,
		4,
		5,
		6,
		7,
		8,
		9,
		10,
		11,
		12,
		13,
		14,
		15,
		16,
		17,
		18,
		19,
		20,
		21,
		22,
		23
	);
	
	foreach ($numarray as $num) {
		echo $num . ' : ' . shopItemHash($num) . '<br>';
	}
	
	//90f154de
?>