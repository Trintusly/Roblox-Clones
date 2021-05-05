<?php
$json = json_decode(file_get_contents("https://www.bopimo.com/json.txt"));

foreach($json as $a)
{
	$acc = (object) $a;
	?>
	<?=$acc->username?>: 
	<?php
	foreach($acc->emails as $email)
	{
		?>
		<?=$email[0]?> (<?=$email[1]?>) | 
		<?php
	}
	?>
	<br>
	<?php
}
?>