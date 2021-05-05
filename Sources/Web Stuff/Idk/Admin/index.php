<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");

	if ($myU->PowerAdmin != "true") {
	
		header("Location: /index.php");
	
	}
	echo "
	<table cellspacing='0' cellpadding='0' width='100%'>
		<tr>
			<td width='250' valign='top'><center>
				<div id='ProfileText'><div align='left'>Panel Navigation</div></div>
				<div align='left'>
				<div id='aP'>
				<a href='?tab=configuration'>Main Configuration</a>
				<a href='?tab=power'>Grant Power to User</a>
				";
		        if ($myU->PowerAdmin == "true") {
				echo "<a href='?tab=item'>Give Item to User</a>";
				echo "<a href='Users.php'>Manage Users</a>";
				}
				echo "
				<a href='?tab=logs'>Logs</a>
				</div>
				<br />
				<div id='ProfileText'>
					Time
				</div>
				";
				include "time.php";
				include "timesource.php";
				echo "
				<br />
				";
				$Online = mysql_num_rows($Online = mysql_query("SELECT * FROM Users WHERE $now < expireTime"));
				$Object = mysql_fetch_object($Object = mysql_query("SELECT * FROM Users WHERE $now < expireTime"));
				echo "<div id='ProfileText'>Statistics</div><div title='' style='color:black;'>$Online users are online";
				echo "
				</div>
				<br />
					";
					echo '<img src="/cgi-sys/Count.cgi?df=socialpa.dat|display=Counter|ft=6|md=5|frgb=100;139;216|dd=A">';
					echo "
			</td>
			<td style='padding-left:15px;' valign='top'>
				<div style='border-radius:5px;'>
				";
				$tab = SecurePost($_GET['tab']);
				if (!$tab) {
				echo "<b>Please navigate in the navigation bar.</b>";
				}
				else {
				
				include "$tab.php";
				}
				echo "
				</div>
			</td>
		</tr>
	</table>
	";
	

include($_SERVER['DOCUMENT_ROOT']."/Footer.php");