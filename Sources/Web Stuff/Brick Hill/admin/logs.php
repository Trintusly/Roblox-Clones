<?php
    include("../SiT_3/config.php");
    include("../SiT_3/header.php");
    include("../SiT_3/PHP/helper.php");
    
    if($power < 4) {header("Location: ../");} // Will be changed to 5 later :^)
?>
<div id="body" >

	<div id="box">
		<h2>
			Admin Logs
		</h2>
		<hr>
	</div>

</div>
<?php 
    include("../SiT_3/footer.php");
?>