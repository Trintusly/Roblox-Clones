<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
if (!$User) {
header("Location: ../index.php"); exit(); }
        $ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
        $getThread = mysql_query("SELECT * FROM Threads WHERE ID='$ID'");
        $gT = mysql_fetch_object($getThread);
        $Posts = $Posts+$Replies;
        $getTopic = mysql_query("SELECT * FROM Topics WHERE ID='$gT->tid'");
$views = $gT->Views + 1;
$Setting = array(
        "PerPage" => 1000
);
 
$PerPage = 1000;
$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];
        $gTT = mysql_fetch_object($getTopic);
       
        $ThreadExist = mysql_num_rows($getThread);
       
       
                if ($ThreadExist == "0") {
               
                        echo "<center><h1><font color= 'darkred'>Oops! Something went wrong.</font></h1></center><br><b><h2><center><b><font color= 'black'>THE THREAD YOU REQUESTED DOES NOT EXIST.</font></center></b></h2>";
                        exit;
               
                }
                                                $getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gT->PosterID'");
                                                $gP = mysql_fetch_object($getPoster);
if ($myU->ID != $gP->ID) {
               
                        mysql_query("UPDATE Threads SET Views=Views + 1 WHERE ID='".$ID."'"); }
                echo "
               
                        <tr>
                                <td>
                                        <br /><a href='../Forum/'><b>Forum</b></font></a> &rsaquo; <a href='../Forum/ViewTopic.php?ID=$gT->tid'><font color='darkblue'><b>$gTT->TopicName</a></font></b> &rsaquo; <a href='../Forum/ViewThread.php?ID=$ID'></font><b>$gT->Title</b></a></div>
                                </td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <div align='left'>
 
                <table>
                        <tr>
                                <td width='125' valign='top' style='border:1px solid rgba(50, 50, 50, 0.75);'><br>
                                               ";

                               
                                
	
	$Posts = mysql_num_rows($Posts = mysql_query("SELECT * FROM Threads WHERE PosterID='".$gP->ID."'")); 
	$Replies = mysql_num_rows($Replies = mysql_query("SELECT * FROM Replies WHERE PosterID='".$gP->ID."'")); 
	$Posts = $Posts+$Replies;
	
	
	//name display online/offline
	
	echo"
	<center>
	";
	
	
	
	echo"
		<a href='../user.php?ID=$gP->ID' style='font-color:#0066CF;font-weight:normal;font-size:14px;'>
			$gP->Username
		</a>
		<br />
		<img src='../Avatar.php?ID=$gP->ID'>
	";
	
	echo"
	</center>
	";	
	
	if ($gP->PowerForumModerator == "true") {
	
		echo"
			<img src='../Imagess/users_moderator.gif' style='padding-left:2px;'>
			<br />
		";
	
	}
	
	if ($gP->Username == "airplanejoe") {
	
		echo"
			<img src='../Images/web.png' style='padding-left:2px;'>
			<br />
		";
	
	}
	
	echo"
	<font style='color:#00000;padding-left:2px;'>
		<strong>Total Posts:</strong> 
		$Posts
	</font>
	";
                                   
echo "</div>
 
                                </td>
 
                                <td valign='top' width='750' style=''>
                                        <div id='ProfileText' style='padding:10px;background:darkwhite;border:1px solid rgba(50, 50, 50, 0.75);'>
                                              <strong> <font size='4'>$gT->Title</div></font></b></strong>
                                        ";if ($myU->PowerForumModerator == "true") { if ($gT->Edited == 1) {
                                                echo"<br /><font color='blue'><font size='2'>This thread has been edited by a moderator</font></font><br /><br />
                                "; }} echo"
                                        </div>
                                        <div style='max-height:189px;overflow-y:auto;height:189px; padding-left:10px;border:1px solid rgba(50, 50, 50, 0.75);border-top:0;'>
                                        ";
                                        $Body = $gT->Body;
                                        $Pattern = "/(http:\/\/)?(www\.)?social-avatar.net(\/)?([a-z\.\?\/\=0-9]+)?/i";
if ($gP->PowerAdmin == "true"||$gP->PowerForumModerator == "true"||$gP->PowerMegaModerator == "true") {
echo "
                                                <b><font color='darkred'>".nl2br($Body)."</b></font>
                                                ";
}
else {
echo" ".nl2br($Body)." ";
}
echo"</font><br /><br /><b> $gP->Signature </b>";
                                                if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
                                               
                                                    echo "
														<a href='?ID=$ID&Moderation=Scrub&Thread=Main&ThreadID=".$gT->ID."' style='font-size:14px;color:#0066CF;font-weight:normal;'>
															Scrub Thread
														</a>
														&nbsp;&nbsp;
														<a href='movethread.php?ID=".$gT->ID."' style='font-size:14px;color:#0066CF;font-weight:normal;'>
														Move Thread</a>
														&nbsp;&nbsp;
														
														";
														if ($gT->Locked == 0) {
														echo "
														<a href='?ID=$ID&Moderation=Lock' style='font-size:14px;color:#0066CF;font-weight:normal;'>
															Lock Thread
														</a>
														";
														}
														else {
													
														echo "
															<a href='?ID=$ID&Moderation=unlock' style='font-size:14px;color:#0066CF;font-weight:normal;'>
															Unlock Thread
														</a>
														";
														}
														
														echo "
														&nbsp;&nbsp;
														<a href='?ID=$ID&Moderation=Edit' style='font-size:14px;color:#0066CF;font-weight:normal;'>
														Edit Thread</a>
	&nbsp;&nbsp;
														<a href='?ID=$ID&Moderation=Delete&Thread=Main&ThreadID=".$gT->ID."' style='font-size:14px;color:#0066CF;font-weight:normal;'>
														Delete Thread</a>
														&nbsp;&nbsp;
														-
														<font color='black'><strong>Thread ID #".$gT->ID."</strong>
														&nbsp;&nbsp;
														
														";
														if ($myU->PowerAdmin == "true") {
														echo"
														<p>
														<font color='black'><strong>Poster IP: ".$gP->IP."</strong>
														</p>
														

";
}
														}
                                                        
														
														$action = $_GET['action'];
														
                                               
if ($User) {
 
                               
}              
$Redirect = rawurlencode($_SERVER['PHP_SELF']);                                

echo"<br><br /><a href='../ReportThread.php?ID=$ID&RedirectUrl=$Redirect?ID=$ID'><font size='2'><font color='darkred'><img src='../Badgess/Administrator.png' height='20' width='20'><b>Report Abuse</b></font></font></a>";
                                                echo "
                                        </div>
                                </td>
                        </tr>
                </table>
                ";
                //main moderation
               
                        $getReplies = mysql_query("SELECT * FROM Replies WHERE tid='".$ID."' ORDER BY ID ASC LIMIT {$Minimum},  ". $Setting["PerPage"]);
                       
                                while ($gR = mysql_fetch_object($getReplies)) {
                                                $getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gR->PosterID'");
                                                $gP = mysql_fetch_object($getPoster);
                                        echo "
                        <a name='$gR->ID'></a>
                <table style='margin-top:10px;'>
                        <tr style='background:darkwhite;'>
                                <td width='125' valign='top' style='border:1px solid rgba(50, 50, 50, 0.75);'>
                                               ";

	$Posts = mysql_num_rows($Posts = mysql_query("SELECT * FROM Threads WHERE PosterID='".$gP->ID."'")); 
	$Replies = mysql_num_rows($Replies = mysql_query("SELECT * FROM Replies WHERE PosterID='".$gP->ID."'"));
	$Posts = $Posts+$Replies;
	
	echo"
	<center>
	";
	
	
	
	echo"
	<a href='../user.php?ID=$gP->ID' style='font-weight:normal;color:#0066CF;font-size:14px;'>
		$gP->Username
	</a>
	<br />
	<img src='../Avatar.php?ID=$gP->ID'>
	";
	
	echo"
	</center>
	";
	
	if ($gP->PowerForumModerator == "true") {
	
		echo"
			<img src='../Imagess/users_moderator.gif' style='padding-left:2px;'>
			<br />
		";
	
	}
	
	echo"
	<font style='color:#00000;padding-left:2px;'>
		<strong>Total Posts:</strong> 
		".$Posts."
	</font>
	";
	
	/*
	$getTopPoster = ("SELECT * FROM ForumPost ORDER BY LIMIT 1,10");
	while($gTP = mysql_fetch_object($getTopPoster)) {
	
		echo"
		<img src='../Images/top10.gif'>
		<br />
		";
	
	}
	*/
	

echo" </div></div>
                                </td>
 
                                <td valign='top' width='750' style='darkwhite'>
                                        <div id='ProfileText' style='padding:10px;border:1px solid rgba(50, 50, 50, 0.75);'>
                                   <font size='4'>RE: ".$gT->Title."</font></div>
                                        </div>
                                        <div style='padding-left:10px;max-height:189px;overflow-y:auto;height:189px;border:1px solid rgba(50, 50, 50, 0.75);border-top:0;'>
                                                ";
                                        $Body = $gR->Body;
                                        $Pattern = "/(http:\/\/)?(www\.)?plim.biz(\/)?([a-z\.\?\/\=0-9]+)?/i";
                                        $Body = preg_replace($Pattern, "<a href='http://plim.biz/\\4' target='_blank'>\\0</a>", $Body);
                                       
												echo"
												<br />
												".nl2br($Body)."
												";
											
                                                echo "</font><br /><br /><b> $gP->Signature </b>";
                                                if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
                                               
                                                        echo "
														<br />
														<a href='?ID=$ID&Moderation=Scrub&Thread=Reply&ThreadID=".$gR->ID."' style='font-size:14px;color:#0066CF;font-weight:normal;'>
															Scrub Reply
														</a>
														&nbsp;&nbsp;
														<a href='?ID=$ID&Moderation=Delete&Thread=Reply&ThreadID=".$gR->ID."' style='font-size:14px;color:#0066CF;font-weight:normal;'>
														Delete Reply</a>
														&nbsp;&nbsp;
														-
														<font color='black'>Reply ID #".$gR->ID."
														";
													
														



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
                                                                <b><center>Confirm Moderation Action</center></b>
<br></font>
                                                        <br />
                                                        <form action='' method='POST'>
                                                                <font size='1'><b><font color= 'darkred'><center>Would you like to Content Delete this reply, $User?</center></font></b></font>
                                                                <br /><br />
                                                                <input type='submit' name='True' value='Confirm' id='SpecialInput'> <input type='submit' name='True1' value='Confirm and Moderate User' id='SpecialInput'> <input type='submit' name='Close' value='Cancel' id='SpecialInput'>
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
                                        header("Location: ../Administration/ModerateUser.php?ID=$gT->PosterID&badcontent=".$gR->Body."");
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
                                                                <b><center>Confirm Moderation Action</center></b>
                                                        </font>
                                                        <br />
                                                        <form action='' method='POST'>
                                                                <font size='1'><b><font color= 'darkred'>Would you like to remove this reply, $User?</font></b></font>
                                                                <br /><br />
                                                                <input type='submit' name='True' value='Confirm' id='SpecialInput'> <input type='submit' name='True1' value='Confirm and Moderate User' id='SpecialInput'> <input type='submit' name='Close' value='Cancel' id='SpecialInput'>
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
                                        header("Location: ../Administration/ModerateUser.php?ID=$gT->PosterID&badcontent=$gT->Title, $gT->Body");
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
                                                                <b><center>Confirm Moderation Action</b></center>
                                                        </font>
                                                        <br />
                                                        <form action='' method='POST'>
                                                                <b><font color='darkred'><font size='1'>Would you like to Content Delete this thread, $User?</font></font></b>
                                                                <br /><br />
                                                                <input type='submit' name='True' value='Confirm' id='SpecialInput'> <input type='submit' name='True1' value='Confirm and Moderate User' id='SpecialInput'> <input type='submit' name='Close' value='Cancel' id='SpecialInput'>
                                                        </form>
                                                </div>
                                        </div>
                                        ";
                                        $Yes = mysql_real_escape_string(strip_tags(stripslashes($_POST['True'])));
                                        $Close = mysql_real_escape_string(strip_tags(stripslashes($_POST['Close'])));
                                        $Yes1 = mysql_real_escape_string(strip_tags(stripslashes($_POST['True1'])));
                                        if ($Yes) {
                                        mysql_query("UPDATE Threads SET Body='[ Content Deleted $gT->ID ]' WHERE ID='".$ThreadID."'");
                                        mysql_query("UPDATE Threads SET Title='[ Content Deleted $gT->ID ]' WHERE ID='".$ThreadID."'");
                                        header("Location: ViewThread.php?ID=$ID");
                                        }
                                        if ($Yes1) {
                                        mysql_query("UPDATE Threads SET Body='[ Content Deleted $gT->ID ]' WHERE ID='".$ThreadID."'");
                                        mysql_query("UPDATE Threads SET Title='[ Content Deleted $gT->ID ]' WHERE ID='".$ThreadID."'");
                                        header("Location: ../ModerateUser.php?ID=$gT->PosterID&badcontent=Title: $gT->Title Body: $gT->Body");
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
                                                                <b><center>Confirm Moderation Action</b></center>
                                                        </font>
                                                        <br />
                                                        <form action='' method='POST'>
                                                                <b><font color='darkred'><font size='1'>Would you like to  remove this thread, $User?</font></font></b>
                                                                <br /><br />
                                                                <input type='submit' name='True' value='Confirm' id='SpecialInput'> <input type='submit' name='True1' value='Confirm and Moderate User' id='SpecialInput'> <input type='submit' name='Close' value='Cancel' id='SpecialInput'>
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
                                        header("Location: ../Administration/ModerateUser.phpID=$gT->PosterID&badcontent=Title: $gT->Title Body: $gT->Body");
                                        }
                                        if ($Close) {
                                        header("Location: ViewThread.php?ID=$ID");
                                        }
                                        }
                               
                                }
               
               
                //reply lol
 
                if ($gT->Locked == "1") {
				
					echo"
					<br />
					<div style='background:#FAE5E5;border:1px solid #C00;padding:5px;'>
						<font style='color:#000000;font-size:16px;'>
							<strong>This thread has been locked and does not allow replies to be posted.</strong>
						</font>
					</div>
					";
				
				}
				
                else {
 
 
 
 
 
 
 
       
 
if ($User&&$gT->Type == "regular") {
		
			echo "
			<form action='' method='POST'>
				<table>
					<tr>
						<td>
						<br />
						<br />
						<fieldset>
						<legend>
							<font size='6'>Reply to &quot;".$gT->Title."&quot;</font>			</legend>	

							<textarea name='Reply' cols='150' rows='5'></textarea>
						
						
							
						</td>
					</tr>
					<tr>
						
					</tr>
					<td>
							<input type='submit' name='Submit' class='btn' value='Reply'>
							</fieldset>
						</td>
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
                        
}
 
 
 
 
if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$myU->PowerForumModerator == "true") {
if ($Moderation == "Lock") { mysql_query("UPDATE Threads SET Locked='1' WHERE ID='$ID'"); }
if ($Moderation == "Edit"){
        ob_end_clean();
        header('location: ModEdit.php?ID=' . $ID);
}
if ($Moderation == "unlock") { mysql_query("UPDATE Threads SET Locked='0' WHERE ID='$ID'"); }          
               
}
 
$track = mysql_real_escape_string($_GET['track']);
 
if ($track == "true") {
mysql_query("INSERT INTO TrackedThreads (UserID, ThreadID) VALUES ('$myU->ID','$ID')");
header("Location: ?ID=$ID"); exit();
}
 
include($_SERVER['DOCUMENT_ROOT']."/Footer.php");