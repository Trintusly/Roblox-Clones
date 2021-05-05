<form action='' method='POST'>
	<table>
		<tr>
			<td>
				<?php
					$Setting = array(
						"PerPage" => 5
					);
					$PerPage = 12;
					$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
					if ($Page < 1) { $Page=1; }
					if (!is_numeric($Page)) { $Page=1; }
					$Minimum = ($Page - 1) * $Setting["PerPage"];
					//query
					$num = mysql_num_rows($allusers = mysql_query("SELECT * FROM Logs ORDER BY ID DESC"));
					$Num = ($Page+8);
					$getLogs = mysql_query("SELECT * FROM Logs ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
						$amount=ceil($num / $Setting["PerPage"]);
						if ($Page > 1) {
						echo '<a href="/Admin/?tab=logs&Page='.($Page-1).'">Prev</a> - ';
						}
						echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
						if ($Page < ($amount)) {
						echo ' - <a href="/Admin/?tab=logs&Page='.($Page+1).'">Next</a>';
						}
					while ($gL = mysql_fetch_object($getLogs)) {
					
					
						echo "
						<table width='100%'>
							<tr>
								<td width='75'>
								<center>
								";
								$getAction = mysql_query("SELECT * FROM Users WHERE ID='$gL->UserID'");
								$gA = mysql_fetch_object($getAction);
								echo "
								<a href='/user.php?ID=$gA->ID'>
								<img src='../Avatar.php?ID=$gA->ID' height='100'>
								<br />
								$gA->Username
								</a>
								</td>
								<td valign='top'>
									$gL->Message
									<br />
									<br />
									$gA->IP
								</td>
							</tr>
						</table>
						<br />
						";
					
					}
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="/Admin/?tab=logs&Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="/Admin/?tab=logs&Page='.($Page+1).'">Next</a>';
}
				?>
			</td>
		</tr>
	</table>
</form>