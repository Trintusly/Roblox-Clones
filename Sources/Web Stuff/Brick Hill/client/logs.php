<?php 

$logsArray = array(
	"Added in things",
	"Added in things v2"
);

?>

<ul>
	<h1>Client Logs</h1>
	<?php 
	
	foreach ($logsArray as $log) {
		echo '<li>'.$log.'</li>';
	}
	
	?>
</ul>