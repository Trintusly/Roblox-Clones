<?php
$ignore = true;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../site/header.php");
if($bop->logged_in())
{
	die(header("location: /home"));
}
?>

<div class="content">
	<div class="centered">
		<div class="register-container">
			<div class="banner danger hidden" id="status"><i class="fa fa-spinner fa-spin"></i> Loading</div>
				<div class="card b">
					<div class="top">
						Login
					</div>
					<div class="body centered">
						<form class="form" id="main-form">
						<input class="width-100" id="username" placeholder="Your Username">
						<br>
						<input type="password" class="width-100" id="pw1" placeholder="Your Password" style="margin-left: -5px;">
						<div class="col-1-2">
							<input type="checkbox" id="cbx" class="inp-cbx" style="display: none">
							<div class="inputGroup">
								<input id="option1" id="remember" value="true" type="checkbox"/>
								<label for="option1">Remember Me</label>
							</div>
						</div>
						<div class="col-1-2">
							<input type="submit" class="button success" value="Login">
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$("#main-form").submit(function(e){
		e.preventDefault();
		$("#status").removeClass("hidden");
		$("#submit").prop("disabled", true);
		$.post("submit.php", {username: $("#username").val(), pw1: $("#pw1").val(), pw2: $("#pw2").val(), email: $("#email").val()}, function(reply){
			switch(reply)
			{
				case "succ":
					document.location = '/home';
					break;
				case "err1":
					$("#status").html("All fields are required.");
					break;
				case "err2":
					$("#status").html("The user does not exist.");
					break;
				case "err3":
					$("#status").html("Incorrect password.");
					break;
			}
		});
	});
});
</script>
<?php $bop->footer(); ?>
