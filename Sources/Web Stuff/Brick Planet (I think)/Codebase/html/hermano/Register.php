<?php

	include 'Header.php';
	
	$Email = (!empty($_POST['email'])) ? $_POST['email'] : false;
	$Password = (!empty($_POST['password'])) ? $_POST['password'] : false;
	$FirstName = (!empty($_POST['firstname'])) ? $_POST['firstname'] : false;
	$LastName = (!empty($_POST['lastname'])) ? $_POST['lastname'] : false;
	$Address = (!empty($_POST['address'])) ? $_POST['address'] : false;
	$Submit = (!empty($_POST['submit'])) ? true : false;
	$ErrorArray = array();
	
	if ($Submit) {
		
		if (!$Email) {
			array_push($ErrorArray, 'Please enter your e-mail address.');
		} if (!$Password) {
			array_push($ErrorArray, 'Please create a password.');
		} if (!$FirstName) {
			array_push($ErrorArray, 'Please enter your first name.');
		} if (!$LastName) {
			array_push($ErrorArray, 'Please enter your last name.');
		} if (!$Address) {
			array_push($ErrorArray, 'Please enter your address.');
		} else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			array_push($ErrorArray, 'The e-mail address you provided is invalid, please double check.');
		} else if (strlen($Password) < 8) {
			array_push($ErrorArray, 'The password you provided is too weak, please create a password with at least 8 characters.');
		} else if (strlen($FirstName) > 100) {
			array_push($ErrorArray, 'Your first name can only contain up to 100 characters.');
		} else if (strlen($LastName) > 100) {
			array_push($ErrorArray, 'Your last name can only contain up to 100 characters.');
		} else {
			$GetUser = $db->prepare("SELECT COUNT(*) FROM users WHERE users.email = ?");
			$GetUser->bindValue(1, $Email, PDO::PARAM_STR);
			$GetUser->execute();
			
			if ($GetUser->fetchColumn() > 0) {
				array_push($ErrorArray, 'There is already an account registered with this e-mail address.');
			} else {
				$PasswordHash = password_hash($Password, PASSWORD_DEFAULT);
				$AddressArray = explode(',', $Address);
				
				$InsertUser = $db->prepare("INSERT INTO users (email, password, firstname, lastname, State, City, Street, ZIP) VALUES(?, '".$PasswordHash."', ?, ?, ?, ?, ?, ?)");
				$InsertUser->bindValue(1, $Email, PDO::PARAM_STR);
				$InsertUser->bindValue(2, $FirstName, PDO::PARAM_STR);
				$InsertUser->bindValue(3, $LastName, PDO::PARAM_STR);
				$InsertUser->bindValue(4, $AddressArray[2], PDO::PARAM_STR);
				$InsertUser->bindValue(5, $AddressArray[1], PDO::PARAM_STR);
				$InsertUser->bindValue(6, $AddressArray[0], PDO::PARAM_STR);
				$InsertUser->bindValue(7, $AddressArray[3], PDO::PARAM_STR);
				$InsertUser->execute();
				
				$_SESSION['UserID'] = $db->lastInsertId();
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
								<center><h1>Register</h1></center>
								<br>
								<div class="form-group">
								  <input type="email" class="form-control" name="email" placeholder="E-mail Address">
								</div>
								<br>
								<div class="form-group">
								  <input type="password" class="form-control" name="password" placeholder="Password">
								</div>
								<br>
								<div class="form-group">
								  <input type="text" class="form-control" name="firstname" placeholder="First Name">
								</div>
								<br>
								<div class="form-group">
								  <input type="text" class="form-control" name="lastname" placeholder="Last Name">
								</div>
								<br>
								<div class="form-group">
								  <input type="text" class="form-control" name="address" placeholder="Street, City, State, ZIP">
								</div>
								<br>
								<center><button type="submit" name="submit" value="1" class="btn btn-outline-primary">Sign Up</button>&nbsp;&nbsp;<a href="./Login.php" class="btn btn-outline-primary">Login</a></center>
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