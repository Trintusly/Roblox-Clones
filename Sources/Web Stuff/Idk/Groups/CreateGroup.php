<?php

	include "../Header.php";
	
	
		if (!$User) {
		
			header("Location: ../index.php");
		
		}
		
		if ($myU->Premium == 1) {
		$Price = 0;
		}
		else {
		$Price = 25;
		}
		
		echo "
		<form action='' enctype='multipart/form-data' method='POST'>
		<b>Create Group <font color='green'>($Price BUX)</font></b>
			<table>
				<tr>
					<td>
						<b>Group Name:</b>
					</td>
					<td>
						<input type='text' name='GroupName'>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<b>Group Description:</b>
						<br />
						<textarea style='width:400px;height:100px;' name='Description'></textarea>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<b>Logo:</b>
					</td>
					<td>
						<input type='file' name='uploaded'>
					</td>
				</tr>
			</table>
			<table> 
				<tr>
					<td>
						<input type='submit' name='Submit' value='Create Group' id='buttonsmall'>
					</td>
				</tr>
			</table>
		</form>
		";
		
		$GroupName = mysql_real_escape_string(strip_tags(stripslashes($_POST['GroupName'])));
		$Description = mysql_real_escape_string(strip_tags(stripslashes($_POST['Description'])));
		$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
		
			if ($Submit) {
			
				if (!$GroupName||!$Description) {
				die("<b>Please fill in all fields.</b>");
				}
				
				$GroupName = filter($GroupName);
				$Description = filter($Description);
				
				$checkGroupExist = mysql_query("SELECT * FROM Groups WHERE Name='$GroupName'");
				$checkGroupExist1 = mysql_query("SELECT * FROM GroupsPending WHERE Name='$GroupName'");
				$GroupExist = mysql_num_rows($checkGroupExist);
				$GroupExist1 = mysql_num_rows($checkGroupExist1);
				
				
				if ($GroupExist > 0 || $GroupExist1 > 0) {
				
					//group name exists already , kill it
					
					die("<b>That group name already exists, sorry!</b>");
				
				}
				
				if ($GroupExist == 0||$GroupExist1 == 0) {
				
					if ($myU->Bux >= $Price) {
					
						$NumberInGroups = mysql_query("SELECT * FROM GroupMembers WHERE UserID='".$myU->ID."'");
						$NumberInGroups = mysql_num_rows($NumberInGroups);
									if ($myU->Premium == "1") {
									$Groups = 100;
									}
									else {
									$Groups = 5;
									}
						if ($NumberInGroups < $Groups) {
						 $FileName = "".$_FILES['uploaded']['name']."";
						 $_FILES['uploaded']['name'] = sha1("".$FileName."".time().".png"); 
						 $target = "GL/";
						 $target = $target . basename( $_FILES['uploaded']['name']) ; 
						 $ok=1; 
						if (($_FILES["uploaded"]["type"] == "image/png")
						&& ($_FILES["uploaded"]["size"] < 1000000000000000))
						{
						
							if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target))  {
							
							if (mysql_query("INSERT INTO GroupsPending (Name, Description, OwnerID, Logo) VALUES('".$GroupName."','".$Description."','".$myU->ID."','".$_FILES['uploaded']['name']."')")) {
							mysql_query("UPDATE Users SET Bux=Bux - $Price WHERE ID='$myU->ID'");
							echo "<b>Group created successfully, your name, description, and logo is under review. This should take up to 10 minutes.</b>";
							
							}
							else {
							
								echo "<b>Fatal error. Your account has not been charged.</b";
							
							}
							}
						
						}
						
						}
						else {
						
							die("<b>Sorry, but you can only be in $Groups groups.</b>");
						
						}
					
					}
					else {
					
						echo "Insufficient funds.";
					
					}
				
				}
				else {
				
					die("<b>That group name already exists.</b>");
				
				}
				
			
			}
		
 //if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
 //{
	
	include "../Footer.php";