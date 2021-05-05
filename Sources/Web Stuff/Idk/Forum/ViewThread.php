<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
	$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
	$getThread = mysql_query("SELECT * FROM Threads WHERE ID='$ID'");
	$gT = mysql_fetch_object($getThread);
	
	$getTopic = mysql_query("SELECT * FROM Topics WHERE ID='$gT->tid'");
	
	$gTT = mysql_fetch_object($getTopic);
	
	$ThreadExist = mysql_num_rows($getThread);
	
		if ($ThreadExist == "0") {
		
			echo "This thread does not exist.";
			exit;
		
		}
						$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gT->PosterID'");
						$gP = mysql_fetch_object($getPoster);
		echo "
		<table style='background:#FCFCFC;border:1px solid rgba(50, 50, 50, 0.75);padding:5px;margin:3px;'>
			<tr>
				<td>
					<a href='/Forum/'>Forum</a> / <a href='/Forum/ViewTopic.php?ID=$gT->tid'>$gTT->TopicName</a> / <a href='/Forum/ViewThread.php?ID=$ID'>$gT->Title</a>
				</td>
			</tr>
		</table>
		
		<table>
			<tr style='background:#F9F9F9;'>
				<td width='125' valign='top' style='border:1px solid rgba(50, 50, 50, 0.75);'>
						<center>
						<a href='/user.php?ID=$gP->ID'>
						<img src='/Avatar.php?ID=$gT->PosterID'>
						<br />
						";

						echo "<b>".$gP->Username."</b></a>";
						echo "
						<br />
						<b>Posts:</b> "; $Posts = mysql_num_rows($Posts = mysql_query("SELECT * FROM Threads WHERE PosterID='".$gP->ID."'")); $Replies = mysql_num_rows($Replies = mysql_query("SELECT * FROM Replies WHERE PosterID='".$gP->ID."'")); $Posts = $Posts+$Replies; echo "$Posts
				</td>
				<td valign='top' width='750' style=''>
					<div id='ProfileText' style='padding:10px;background:#F9F9F9;border:1px solid rgba(50, 50, 50, 0.75);'>
						$gT->Title
					</div>
					<div style='max-height:189px;overflow-y:auto;height:189px; padding-left:10px;border:1px solid rgba(50, 50, 50, 0.75);border-top:0;'>
					";
					$Body = $gT->Body;
					$Pattern = "/(http:\/\/)?(www\.)?social-paradise.net(\/)?([a-z\.\?\/\=0-9]+)?/i";
					$Body = preg_replace($Pattern, "<a href='https://brickplanet.gq/\\4' target='_blank'>\\0</a>", $Body);
					echo "
						".nl2br($Body)."
						";
						if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
						
							echo "<br /><br /><a href='?ID=$ID&Moderation=Scrub&Thread=Main&ThreadID=".$gT->ID."' style='color:blue;font-weight:bold;'>Scrub</a> | <a href='?ID=$ID&Moderation=Delete&Thread=Main&ThreadID=".$gT->ID."' style='color:blue;font-weight:bold;'>Delete</a> | <a href='https://brickplanet.gq/Forum/EditThread.php?ID=".$gT->ID."' style='color:blue;font-weight:bold;'>Edit Thread</a>";

						
						}
						echo "
					</div>
				</td>
			</tr>
		</table>
		";
		//main moderation
		
			$getReplies = mysql_query("SELECT * FROM Replies WHERE tid='".$ID."' ORDER BY ID");
			
				while ($gR = mysql_fetch_object($getReplies)) {
						$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gR->PosterID'");
						$gP = mysql_fetch_object($getPoster);
					echo "
			<a name='$gR->ID'></a>
		<table style='margin-top:10px;'>
			<tr style='background:#F9F9F9;'>
				<td width='125' valign='top' style='border:1px solid rgba(50, 50, 50, 0.75);'>
						<center>
						<a href='/user.php?ID=$gP->ID'>
						<img src='/Avatar.php?ID=$gR->PosterID'>
						<br />
						";

						echo "<b>".$gP->Username."</b></a><br />";
						
						echo "
						<b>Posts:</b> "; $Posts = mysql_num_rows($Posts = mysql_query("SELECT * FROM Threads WHERE PosterID='".$gP->ID."'")); $Replies = mysql_num_rows($Replies = mysql_query("SELECT * FROM Replies WHERE PosterID='".$gP->ID."'")); $Posts = $Posts+$Replies; echo "$Posts
				</td>
				<td valign='top' width='750' style=''>
					<div id='ProfileText' style='padding:10px;border:1px solid rgba(50, 50, 50, 0.75);'>
						RE: ".$gT->Title."
					</div>
					<div style='padding-left:10px;max-height:189px;overflow-y:auto;height:189px;border:1px solid rgba(50, 50, 50, 0.75);border-top:0;'>
						";
					$Body = $gR->Body;
					$Pattern = "/(http:\/\/)?(www\.)?social-paradise.net(\/)?([a-z\.\?\/\=0-9]+)?/i";
					$Body = preg_replace($Pattern, "<a href='https://brickplanet.gq/\\4' target='_blank'>\\0</a>", $Body);
						echo "
						".nl2br($Body)."
						";
						if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
						
							echo "<br /><br /><a href='?ID=$ID&Moderation=Scrub&Thread=Reply&ThreadID=".$gR->ID."' style='color:blue;font-weight:bold;'>Scrub</a> | <a href='?ID=$ID&Moderation=Delete&Thread=Reply&ThreadID=".$gR->ID."' style='color:blue;font-weight:bold;'>Delete</a>";
						
						}
						echo "
					</div>
				</td>
			</tr>
		</table>
					";
				
				}
				$Moderation = mysql_real_escape_string(strip_tags(stripslashes($_GET['Moderation'])));
				$Thread = mysql_real_escape_string(strip_tags(stripslashes($_GET['Thread'])));
				$ThreadID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ThreadID'])));
				
				if ($Moderation == "Scrub" && $Thread == "Reply") {
				
					if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
					echo "
					<div style='background-image:url(/Imagess/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'><center>
						<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
						<div id='aB' style='width:300px;border:2px solid #aaa;border-radius:5px;'>
							<font id='HeadText'>
								<b>Confirm</b>
							</font>
							<br />
							<form action='' method='POST'>
								Are you sure you would like to scrub this reply?
								<br /><br />
								<input type='submit' name='True' value='Yes' id='SpecialInput'> <input type='submit' name='True1' value='Yes and Ban' id='SpecialInput'> <input type='submit' name='Close' value='Close' id='SpecialInput'>
							</form>
						</div>
					</div>
					";
					$Yes = mysql_real_escape_string(strip_tags(stripslashes($_POST['True'])));
					$Close = mysql_real_escape_string(strip_tags(stripslashes($_POST['Close'])));
					$Yes1 = mysql_real_escape_string(strip_tags(stripslashes($_POST['True1'])));
					if ($Yes) {
					mysql_query("UPDATE Replies SET Body='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					header("Location: ViewThread.php?ID=$ID");
					}
					if ($Yes1) {
					mysql_query("UPDATE Replies SET Body='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					mysql_query("UPDATE Replies SET Title='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					header("Location: /BanUser.php?ID=$gT->PosterID&badcontent=".$gR->Body."");
					}
					if ($Close) {
					header("Location: ViewThread.php?ID=$ID");
					}
					}
				
				}
				if ($Moderation == "Delete" && $Thread == "Reply") {
				
					if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
					echo "
					<div style='background-image:url(/Imagess/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'><center>
						<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
						<div id='aB' style='width:300px;border:2px solid #aaa;border-radius:5px;'>
							<font id='HeadText'>
								<b>Confirm</b>
							</font>
							<br />
							<form action='' method='POST'>
								Are you sure you would like to delete this reply?
								<br /><br />
								<input type='submit' name='True' value='Yes' id='SpecialInput'> <input type='submit' name='True1' value='Yes and Ban' id='SpecialInput'> <input type='submit' name='Close' value='Close' id='SpecialInput'>
							</form>
						</div>
					</div>
					";
					$Yes = mysql_real_escape_string(strip_tags(stripslashes($_POST['True'])));
					$Close = mysql_real_escape_string(strip_tags(stripslashes($_POST['Close'])));
					$Yes1 = mysql_real_escape_string(strip_tags(stripslashes($_POST['True1'])));
					if ($Yes) {
					mysql_query("DELETE FROM Replies WHERE ID='".$ThreadID."'");
					header("Location: ViewThread.php?ID=$ID");
					}
					if ($Yes1) {
					mysql_query("UPDATE Threads SET Body='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					mysql_query("UPDATE Threads SET Title='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					header("Location: /BanUser.php?ID=$gT->PosterID&badcontent=$gT->Title, $gT->Body");
					}
					if ($Close) {
					header("Location: ViewThread.php?ID=$ID");
					}
					}
				
				}
				if ($Moderation == "Scrub" && $Thread == "Main") {
				
					if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
					echo "
					<div style='background-image:url(/Imagess/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'><center>
						<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
						<div id='aB' style='width:300px;border:2px solid #aaa;border-radius:5px;'>
							<font id='HeadText'>
								<b>Confirm</b>
							</font>
							<br />
							<form action='' method='POST'>
								Are you sure you would like to scrub this thread?
								<br /><br />
								<input type='submit' name='True' value='Yes' id='SpecialInput'> <input type='submit' name='True1' value='Yes and Ban' id='SpecialInput'> <input type='submit' name='Close' value='Close' id='SpecialInput'>
							</form>
						</div>
					</div>
					";
					$Yes = mysql_real_escape_string(strip_tags(stripslashes($_POST['True'])));
					$Close = mysql_real_escape_string(strip_tags(stripslashes($_POST['Close'])));
					$Yes1 = mysql_real_escape_string(strip_tags(stripslashes($_POST['True1'])));
					if ($Yes) {
					mysql_query("UPDATE Threads SET Body='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					mysql_query("UPDATE Threads SET Title='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					header("Location: ViewThread.php?ID=$ID");
					}
					if ($Yes1) {
					mysql_query("UPDATE Threads SET Body='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					mysql_query("UPDATE Threads SET Title='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					header("Location: /BanUser.php?ID=$gT->PosterID&badcontent=Title: $gT->Title Body: $gT->Body");
					}
					if ($Close) {
					header("Location: ViewThread.php?ID=$ID");
					}
					}
				
				}
				if ($Moderation == "Delete" && $Thread == "Main") {
				
					if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
					echo "
					<div style='background-image:url(/Imagess/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'><center>
						<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
						<div id='aB' style='width:300px;border:2px solid #aaa;border-radius:5px;'>
							<font id='HeadText'>
								<b>Confirm</b>
							</font>
							<br />
							<form action='' method='POST'>
								Are you sure you would like to delete this thread?
								<br /><br />
								<input type='submit' name='True' value='Yes' id='SpecialInput'> <input type='submit' name='True1' value='Yes and Ban' id='SpecialInput'> <input type='submit' name='Close' value='Close' id='SpecialInput'>
							</form>
						</div>
					</div>
					";
					$Yes = mysql_real_escape_string(strip_tags(stripslashes($_POST['True'])));
					$Yes1 = mysql_real_escape_string(strip_tags(stripslashes($_POST['True1'])));
					$Close = mysql_real_escape_string(strip_tags(stripslashes($_POST['Close'])));
					if ($Yes) {
					mysql_query("DELETE FROM Threads WHERE ID='".$ThreadID."'");
					mysql_query("DELETE FROM Replies WHERE ID='".$ThreadID."'");
					header("Location: ViewTopic.php?ID=$gT->tid");
					}
					if ($Yes1) {
					mysql_query("UPDATE Threads SET Body='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					mysql_query("UPDATE Threads SET Title='[ Content Deleted ]' WHERE ID='".$ThreadID."'");
					header("Location: /BanUser.phpID=$gT->PosterID&badcontent=Title: $gT->Title Body: $gT->Body");
					}
					if ($Close) {
					header("Location: ViewThread.php?ID=$ID");
					}
					}
				
				}
		
		
		//reply lol
		
		if ($User&&$gT->Type == "regular") {
		
			echo "
			<center>
			<form action='' method='POST'>
				<table>
					<tr>
						<td>
							<textarea name='Reply' cols='120' rows='5'></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type='submit' name='Submit' value='Reply'>
						</td>
					</tr>
				</table>
			</form>
			";
			$Reply = mysql_real_escape_string(strip_tags(stripslashes($_POST['Reply'])));
			$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
			
				if ($Submit) {
				
				
					if (!$Reply) {
					
						echo "<b>Please include text in your reply.</b>";
					
					}
					elseif (strlen($Reply) < 3) {
					
						echo "<b>Please have your reply more 2 characters.</b>";
					
					}
					elseif (strlen($Reply) > 499) {
					
						echo "<b>Please have your reply less than 500 characters.</b>";
					
					}
					else {
					
						$Reply = filter($Reply);
					
						//insert query
						if ($now < $myU->forumflood) {
						echo "You are posting too fast, please wait.";
						}
						else {
						$flood = $now + 10;
						mysql_query("UPDATE Users SET forumflood='$flood' WHERE ID='$myU->ID'");
						mysql_query("INSERT INTO Replies (Body, PosterID, tid) VALUES('".$Reply."','".$myU->ID."','".$ID."')");
						mysql_query("UPDATE Threads SET bump='$now' WHERE ID='$ID'");
						$getNew = mysql_query("SELECT * FROM Replies WHERE Body='$Reply' AND PosterID='$myU->ID' AND tid='$ID'");
						$gN = mysql_fetch_object($getNew);
						header("Location: ViewThread.php?ID=$ID#".$gN->ID."");
						}
					
					}
				
				}
		
		}

include($_SERVER['DOCUMENT_ROOT']."/Footer.php");