<?
include('Header.php');

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
					
					header("Location: index.php");
				
				}
			
			}
		
		}
	
	}

?>
<form action="" method="POST">
<div align='left'>
	<table>
		<tr>
			<td valign='top'>
				<?php
if (!$User) { echo "
					<div id='Login'>
						<div align='center'>
							<table>
								<tr>
									<td id='Msg'>
										Login to your account
									</td>
								</tr>
							</table>
						</div>
							<table>
								<tr>
									<td id='smalltext'>
										Username
									</td>
									<td>
										<input type='text' name='Username' required='required'>
									</td>
								</tr>
								<tr>
									<td id='smalltext'>
										Password
									</td>
									<td>
										<input type='password' name='Password' required='required'>
									</td>
								</tr>
								<tr>
									<td>
										<input type='submit' name='Submit' value='Login'>
									</td>
								</tr>
							</table>
							<a href='ForgotPassword.php'>Forgot your password?</a>
					</div>
					<br />
					<br />
					</form>
					<form action='register.php' method='POST'>
					<div id='Login'>
						<div align='center'>
							<table>
								<tr>
									<td>
										<div id='Msg'>
											No account?
										</div>
										<div id='Msgsmall'>
											<a href='Register.php'>Register</a> for free!
			"; }
			else {
			
				echo "
				<div id='Login'>
					<left>
						<b>Welcome, $User!</b>
						<br />
						<br />
						<img src='https://www.buildcity.ml/Avatar2D.php?ID=$myU->ID'>
                                                <center position:absolute; TOP:35px; LEFT:170px; WIDTH:50px; HEIGHT:50px>
                                               <b>Welcome to Build City!</b> 
                                                <br />
						<br />
                                           A place where people can meet up and create cool avatars or just talk to each other.
                                               We are still going under construction,but we should be finished soon!
					</center>

				</div>
				";
			
			}
			echo "

			";
			?>
			</td>
		</tr>
	</table>
</div>
</form>
<?php
include('Footer.php');
?>