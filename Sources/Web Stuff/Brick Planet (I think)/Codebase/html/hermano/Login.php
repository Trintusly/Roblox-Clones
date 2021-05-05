<?php

	include 'Header.php';
	
	$Email = (!empty($_POST['email'])) ? $_POST['email'] : false;
	$Password = (!empty($_POST['password'])) ? $_POST['password'] : false;
	$Submit = (!empty($_POST['submit'])) ? true : false;
	$ErrorArray = array();
	
	if ($Submit) {
		
		if (!$Email) {
			array_push($ErrorArray, 'Please provide an e-mail address.');
		} else if (!$Password) {
			array_push($ErrorArray, 'Please provide your passowrd.');
		} else {
			$GetUser = $db->prepare("SELECT users.id, users.password FROM users WHERE users.email = ?");
			$GetUser->bindValue(1, $Email, PDO::PARAM_STR);
			$GetUser->execute();
			$CountGetUser = $GetUser->rowCount();
			$gU = ($CountGetUser > 0) ? $GetUser->fetch(PDO::FETCH_OBJ) : false;
			
			if ($GetUser->rowCount() == 0) {
				array_push($ErrorArray, 'You have entered an incorrect e-mail and/or password, please try again.');
			} else if (!password_verify($Password, $gU->password)) {
				array_push($ErrorArray, 'You have entered an incorrect e-mail and/or password, please try again.');
			} else {
				$_SESSION['UserID'] = $gU->id;
				header("Location: " . $SiteName);
				die;
			}
		}
		
	}
	
	echo '
	<div style="height:150px;"></div>
	<div class="row">
			<div class="col-12 col-md-3">
			</div>
			<div class="col-12 col-md-6">
				<div class="card border-dark">
					  <div class="card-body">
					<div style="height:60px;"></div>
						<div class="container">
							';
							
							if (!empty($ErrorArray)) {
								echo '
								<div class="error-message-class">
								'.implode('<br>', $ErrorArray).'
								</div>
								';
							}
							
							echo '
							<form action="" method="post" name="login">
							  <fieldset>
								<center><h1>Login</h1></center>
								<br>
								<div class="form-group">
								  <input type="email" class="form-control" name="email" placeholder="Email Address">
								</div>
								<br>
								<div class="form-group">
								  <input type="password" class="form-control" name="password" placeholder="Password">
								</div>
								<br>
								<center><button type="submit" name="submit" value="1" class="btn btn-outline-primary">Login</button>&nbsp;&nbsp;<a href="./Register.php" class="btn btn-outline-primary">Sign Up</a></center>
							  </fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-3">
			</div>
		</div>
	';