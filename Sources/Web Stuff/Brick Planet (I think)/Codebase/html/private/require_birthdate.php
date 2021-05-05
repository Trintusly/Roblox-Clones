<?php

	if (isset($_SESSION['username']) && $myU->BirthdateMonth == 0 && $myU->BirthdateDay == 0 && $myU->BirthdateYear == 0) {
		
		if (isset($_POST['birthdate_month']) && isset($_POST['birthdate_day']) && isset($_POST['birthdate_year'])) {
			
			if ($_POST['birthdate_month'] < 1 || $_POST['birthdate_month'] > 12) {
				
				$error = 'Invalid month';
				
			}
			
			else if ($_POST['birthdate_day'] < 1 || $_POST['birthdate_day'] > 31) {
				
				$error = 'Invalid day';
				
			}
			
			else if ($_POST['birthdate_year'] > date('Y') || $_POST['birthdate_year'] < (date('Y') - 100)) {
				
				$error = 'Invalid year';
				
			}
			
			else {
				
				$update = $db->prepare("UPDATE Users SET BirthdateMonth = ?, BirthdateDay = ?, BirthdateYear = ? WHERE ID = ".$myU->ID."");
				$update->bindValue(1, $_POST['birthdate_month'], PDO::PARAM_INT);
				$update->bindValue(2, $_POST['birthdate_day'], PDO::PARAM_INT);
				$update->bindValue(3, $_POST['birthdate_year'], PDO::PARAM_INT);
				$update->execute();
				
				$_SESSION['NextF5'] = time();
				
				header("Location: ".$_SERVER['REQUEST_URI']."");
				die;
				
			}
			
		}
		
		echo '
		<div class="content-box" style="width:50%;margin:0 auto;">
			';
			
			if (isset($error)) {
				
				echo '<div style="color:red;padding-bottom:5px;">'.$error.'</div>';
				
			}
			
			echo '
			<div class="header-text" style="padding-bottom:10px;">Action Required</div>
			We\'ve recently made changes to our site that requires your birth date. Please enter it below:
			<div style="height:10px;"></div>
			<form action="" method="POST">
				<table width="100%" style="padding:0;margin:0;">
					<tr>
						<td>
							<select name="birthdate_month" class="browser-default general-textarea">
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</td>
						<td>
							<select name="birthdate_day" class="browser-default general-textarea">
								';
								
								for ($i = 1; $i < 32; $i++) {
									
									if ($i < 10) { $i = 0 . $i; }
									
									echo '<option value="'.$i.'">'.$i.'</option>';
									
								}
								
								echo '
							</select>
						</td>
						<td>
							<select name="birthdate_year" class="browser-default general-textarea">
								';
								
								$date_year = date('Y');
								$hundred_years = date('Y') - 100;
								
								for ($i = $date_year; $i >= $hundred_years; $i--) {
									
									echo '<option value="'.$i.'">'.$i.'</option>';
									
								}
								
								echo '
							</select>
						</td>
						<td>
							<input type="submit" class="groups-blue-button" style="padding:0;padding:4px 8px;" value="Update">
						</td>
					</tr>
				</table>
			</form>
		</div>
		';
		
		require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
		
		die;
		
	}