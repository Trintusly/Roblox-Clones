<?php
	include "../Header.php";
	
		echo "
		<div id='LargeText'>
		Top Forum Posters
		</div>
		";
		
		$getTopPosters = mysql_query("SELECT * FROM Users ORDER BY ID ASC");
		
		while ($gT = mysql_fetch_object($getTopPosters)) {
		
		$Posts = mysql_num_rows($Posts = mysql_query("SELECT * FROM Threads WHERE PosterID='".$gT->ID."'"));
		$Replies = mysql_num_rows($Replies = mysql_query("SELECT * FROM Replies WHERE PosterID='".$gT->ID."'"));
		$Posts = $Posts+$Replies;
		
		if ($Posts > 24) {
		
			echo "
			<table>
				<tr>
					<td>
						$gT->Username with $Posts posts
					</td>
				</tr>
			</table>
			";
		
		}
		
		}
	
	include "../Footer.php";