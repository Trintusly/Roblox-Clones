<?php
	include "Header.php";
	
	if (!$User) {
	
		$Username = SecurePost($_POST['Username']);
		$Password = SecurePost($_POST['Password']);
		$Submit =   SecurePost($_POST['Submit']);
		
		if ($Submit) {
		
			if (!$Username || !$Password) {
			
				echo "
				<div id='Error'>
					Sorry, you have missing fields.
				</div>
				";
			
			}
			
			else {
			
				$_HASH = hash('sha512',$Password);
				
				$checkUser = mysql_query("SELECT * FROM Users WHERE Username='$Username'");
				
				$cU = mysql_num_rows($checkUser);
				
				if ($cU == 0) {
				
				echo "
				<div id='Error'>
					Sorry, that account does not exist.
				</div>
				";
				
				}
				
				else {
				
					$getPassword = mysql_query("SELECT * FROM Users WHERE Username='$Username' AND Password='$_HASH'");
					
					$gP = mysql_num_rows($getPassword);
					
					if ($gP == 0) {
					
						echo "
						<div id='Error'>
							Sorry, but your password is incorrect.
						</div>
						";
					
					}
					
					else {
					
						$_SESSION['Username']=$Username;
						$_SESSION['Password']=$_HASH;
						
						header("Location: https://www.mine2build.eu/");
					
					}
				
				}
			
			}
		
		}
	
		echo "
		<div class='row'>
<div class='col s12 m3 l2'>&nbsp;</div>
<div class='col s12 m12 l8'>
<div style='padding-top:50px;'></div>
<div class='container' style='width:100%;'>
<div class='center-align'>
<div style='padding-bottom:50px;'>
<div class='text-center'>
</div>
</div>
</div>
<div class='row'>
<div class='col s12 m12 l4'>&nbsp;</div>
<div class='col s12 m12 l4'>
<div class='bc-content center-align'>
<h4 style='padding-bottom:25px;'>Log in</h4>
<form action='' method='POST'>
<div class='input-field'>
<input type='text' name='Username' id='Username'>
<label for='username' class=''>Username</label>
</div>
<div class='input-field'>
<input type='password' name='Password' id='Password'>
<label for='password'>Password</label>
</div>
<div class='input-field'>
<i class='waves-effect waves-light btn blue waves-input-wrapper' style=''>&nbsp;<input type='submit' name='Submit' class='waves-button-input' value='LOG IN'>&nbsp;</i>
</div>
</form>
</div>
</div>
</div>
</div></div></div>
		";
	
	}
	
	else {
	
		header("Location: ../");
	
	}
	
	include "Footer.php";
?>