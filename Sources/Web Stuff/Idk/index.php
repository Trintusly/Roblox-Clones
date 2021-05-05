<?php
	include "Header.php";
	$Username = SecurePost($_POST['Username']);
	$Password = SecurePost($_POST['Password']);
	$Submit =   SecurePost($_POST['Submit']);
	

	if ($Submit) {
		
		if (!$Username || !$Password) {
			echo "
			<div id='Error'>
				Sorry, you have missing field
			</div>
			";
		} else {
			$_HASH = hash('sha512',$Password);
			$checkUser = mysql_query("SELECT * FROM Users WHERE Username='$Username'");
			$cU = mysql_num_rows($checkUser);
			
			if ($cU == 0) {
				echo "
			<div id='Error'>
				Sorry, that account does not exist.
			</div>
			";
			} else {
				$getPassword = mysql_query("SELECT * FROM Users WHERE Username='$Username' AND Password='$_HASH'");
				$gP = mysql_num_rows($getPassword);
				
				if ($gP == 0) {
					echo "
					<div id='Error'>
						Sorry, but your password is incorrect.
					</div>
					";
				} else {
					$_SESSION['Username']=$Username;
					$_SESSION['Password']=$_HASH;
					header("Location: index.php");
				}

			}

		}

	}

	?>
<style>
h1 {
    text-align: center;
}
h4 {
    text-align: center;
}
#Login {
    margin-top: 20px;
}
</style>
		<link rel="stylesheet" href="https://brickplanet.gq/NewHomepage.css">
				<?php

	if (!$User) {
		echo "
<div class='container white z-depth-2' style='height:380px'>
	<ul class='tabs' style='background-color: #4d90ea;text-align:center'>
		<li class='tab col s3'><a class='white-text active' href='#login'>login</a></li>
	</ul>
	<div id='login' class='col s12'>
		<form action method='POST' class='col s12'>
			<div class='form-container'>
				<div class='row'>
					<div class='input-field col s12'>
						<input name='Username' type='text'  class='validate' require>
						<label for='Username'>Username</label>
					</div>
				</div>
				<div class='row'>
					<div class='input-field col s12'>
						<input name='Password' type='password' class='validate' required>
						<label for='Password'>Password</label>
					</div>
				</div>
				<br>
				<center>
					<button class='btn waves-effect waves-light' style='background-color: #4d90ea' type='submit' name='Submit' value='Login'>login</button>
					<br>
					<br>
					<a href='ForgotPassword.php'>Forgot your password?</a>
				</center>
			</div>
</div>
			";
	}



	elseif ($User) {
		echo "
<h1 style='font-weight:200;'>Hello, $User!</h1>
<div class='notification'>
<div class='w-row'><div class='w-col w-col-3 w-col-medium-6 w-col-small-6 w-col-tiny-6 w-clearfix columnone'>
<img class='avatarincolumnone' src='https://brickplanet.gq/Avatar.php?ID=$myU->ID' alt='549892444afa674f26ae6f9c_Avatar.png'></div>
<div class='w-col w-col-9 w-col-medium-6 w-col-small-6 w-col-tiny-6'>
<div class='avatardescription'>";
		// Status update
		$SubmitStat = mysql_real_escape_string(strip_tags(stripslashes($_POST['status'])));
		$SubmitStat = filter($SubmitStat);
		$IDD = $myU->ID;
		
		if ($SubmitStat) {
			
			if ($status >= 101) {
				echo"error";
			} else {
				mysql_query("UPDATE Users SET ProfileStatus='$SubmitStat' WHERE ID='$IDD'");
				header("Location: /index.php");
			}

		}

		echo "<br /><b>Status</b><div id='UpdateStatus'>
<form action='' method='post'>
<input type='input' name='status' style='width:75%;padding:4px' value='$myU->ProfileStatus' placeholder='What are you up to?'>
<input type='submit' name='SubmitStat' class='btn' value='Share Status'>
</form></div><br>
";
		
		if ($myU->Premium == "1") {
			echo '
You currently have a <b>Premium membership</b>. Your daily bonus is 250 Bux.<br />';
		} else {
			echo '
You currently do not have a Premium membership.<br /><a href="https://brickplanet.gq/Memberships/UpgradeAccount.php">Purchase Premium</a>
';
		}

		echo "</div>";
	
		// Enter notification text content
		echo "
<br>You have ";
		echo number_format("$myU->Bux");
		echo "&nbsp;Bux.</div></div></div><h1 style='font-weight:200;'>Notifications</h1><p>";
		
		if ($myU->PowerAdmin == "true") {
		$clear = $_GET['clear'];
		if ($clear == "true") {
		mysql_query("DELETE FROM Notifications");
		header("Location: index.php");
		}
		
			echo "
			<div class='notification'>

			<div id='AddNotification'>
<form action='' method='POST'>
<input type='input' name='notification' style='width:75%;padding:4px'>
<input type='submit' name='Submit' class='btn' value='Add Notification'><br /><br />
<a href='?clear=true' class='btn' style='color:white; text-decoration:none; font-weight: 400;'>Clear Notifications</a>

</form></div></div><br />";
			
			
			
			$notificationT = mysql_real_escape_string(strip_tags(stripslashes($_POST['notification'])));
			$notificationT = filter($notificationT);
			if($Submit) {
				mysql_query("INSERT INTO Notifications (Text, Creator) VALUES ('$notificationT', '$myU->Username')");
				mysql_query("INSERT INTO PMs (ReceiveID, Title, Body) VALUES ('1', 'Site Notification by $myU->Username', '$notificationT')");
				header("Location: /index.php");
			}

		}
		


		$getRecentNotifications = mysql_query('SELECT * FROM Notifications ORDER BY ID DESC LIMIT 4');
		while ($gRN = @mysql_fetch_object($getRecentNotifications)) {
			echo "<div class='notification' style='height:80px;'><font weight='bold'>$gRN->Creator</font><br />";
			echo "$gRN->Text</div><br />";
		}
		

		
		
		echo "<table width='100%'><tr width='100%'><td width='50%'>
<h1 style='font-weight:300;'>6 Recent Threads</h1><div class='notification' style='height:350px;'><p>
";
		// Recent threads
		$getRecentThreads = mysql_query('SELECT * FROM Threads ORDER BY ID DESC LIMIT 6');
		while ($gRT = mysql_fetch_object($getRecentThreads)) {
			echo "
<a href='Forum/ViewThread.php?ID=$gRT->ID'>$gRT->Title</a><br /> $gRT->TimePosted<br /><br />";
		}

		echo "
	</p></div>
	</td><td width='50%'>";
		echo "
<h1 style='font-weight:300;'>3 Recent Items</h1><div class='notification' style='height:350px;'><table width='100%' style='margin-left:15px;'><tr width='100%'>
";
		// Recent threads	
		$getRecentItems = mysql_query('SELECT * FROM Items ORDER BY ID DESC LIMIT 3');
		while ($gRI = mysql_fetch_object($getRecentItems)) {
			$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gRI->CreatorID."'");
			$gC = mysql_fetch_object($getCreator);
			echo "<td width='35%'>
<div style='width: 100px; height: 200px; z-index: 999;  background-image: url(https://brickplanet.gq/Store/Dir/".$gRI->File.");'></div>
<a href='Store/Item.php?ID=$gRI->ID'>$gRI->Name</a><br />
<b>Price: ".number_format($gRI->Price)." Bux<br /></b>
<b>Creator:</b> <a href='/user.php?ID=".$gC->ID."'>".$gC->Username."</a><br />
<b>Type:</b> <b>".$gRI->Type."<br /></b>
</td>";
		}

		echo "</tr></table></div>
</td></tr><table>";
	}

	include "Footer.php";
	?>
