<?php
session_id();
session_start();
ob_start();
$connection = mysql_connect("localhost","brickpla_usr","2zqKKQQ*bZF&+_+") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");
mysql_select_db("brickpla_db") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");
	$Maintenance = mysql_fetch_object($Configuration = mysql_query("SELECT * FROM Maintenance"));
	
	if ($Maintenance->Status == "false") {
	
		header("Location: index.php");
	
	}
?>
<style>
body {
background: url();
background-repeat:no-repeat;
background-attachment:fixed;
background-position:center top; 
background-size:cover;
height:100%;

background: #95a5a6;
color:white;
font-family:Segoe UI;
}

#Opacity {
background: url(Opacity.png);
padding:12px;
border:1px solid #969696;
border-radius:6px;
width:380px;
}

h3 {
color:#F5F5F5;
font-size:25px;
margin:0;
padding:0;
padding-bottom:10px;
}

#h3sub {
color:#F5F5F5;
font-size:18px;
}

h2 {
color:#F5F5F5;
text-shadow:1px 0px 0px #999;
margin:0;
padding:0;
padding-bottom:10px;
}

input[type=text] {
width:300px;
background:white;
border:1px solid #999;
padding:4px;
font-family:Segoe UI;
border-radius:5px;
}

input[type=password] {
width:300px;
background:white;
border:1px solid #999;
padding:4px;
font-family:Segoe UI;
border-radius:5px;
}

#btn {
background:rgb(34,51,136);
padding:4px;
border-radius:7px;
color:white;
font-family:Verdana;
font-size:16px;
font-weight:bold;
text-shadow:1px 0px 0px rgb(34,34,34);
</style>
<center>
<div style='padding-bottom:170px;'></div>
<div class='container'>
<table width='800'>
	<tr>
		<td width='410' valign='top'>
		<h3>Site Offline</h3>
		We apologize, but BrickPlanet is currently offline :(
		<br />
		<br />
		We'll be back shortly, in the meantime, join our <a href="/discord">discord server here</a>.
		</td>
		<td valign='top'>
			<div id='Opacity'>
			<h2>Administration Access</h2>
			<form action='' method='POST'>
				<table>
					<tr>
						<td>
							<input type='password' name='Password' placeholder='Passcode...'>
						</td>
					</tr>
					<tr>
						<td>
							<input type='submit' name='submit' value='Login'>
						</td>
					</tr>
				</table>
			</form>
			</div>
		</td>
	</tr>
</table>
<?php
$Password = mysql_real_escape_string(strip_tags(stripslashes($_POST['Password'])));
$submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['submit'])));

	if ($submit) {
	
		$Passcode = "***^%797777Access";
		
		if ($Password == $Passcode) {
		
			$_SESSION['Admin']="hi";
			header("Location: index.php");
		
		}
	
	}

?>