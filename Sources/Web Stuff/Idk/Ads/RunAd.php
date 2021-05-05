<?php
	include "../Header.php";
	if (!$User) {
	
		header("Location: ../index.php");
		die;
	}
	
	echo "
	<div id='TopBar'>
		Upload Ad
	</div>
	<div id='aB'>
	<form enctype='multipart/form-data' action='' method='POST'>
		<table>
			<tr>
				<td>
					<b>File</b>
				</td>
				<td>
					<input type='file' name='uploaded'>
				</td>
			</tr>
		</table>
	</form>
	</div>
	";
	
	include "../Footer.php";