<?php
$ignore = true;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../site/lib.php");
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
						Register
					</div>
					<div class="body">
						<form id="main-form">
							<input class="width-80" id="username" placeholder="Username (3 - 20 (alphanum) Characters)">
							<br>
							<input type="password" class="width-80" id="pw1" placeholder="Password" style="margin-left: -5px;">
							<input type="password" class="width-80" id="pw2" placeholder="Confirm Password">
							<input type="email" class="width-80" id="email" placeholder="Your Email">
							<br>
							<input type="submit" class="button success" value="Register">
							<div style="centered">By signing up you agree to our <a href="/privacy/" style="color:#8771f7;">Privacy Policy</a></div>
						</form>
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
					$("#status").html("The passwords you have entered do not match.");
					break;
				case "err3":
					$("#status").html("Your username must be 3-20 characters long.");
					break;
				case "err4":
					$("#status").html("Special characters are not allowed in a username.");
					break;
				case "err5":
					$("#status").html("The username has been taken.");
					break;
				case "err6":
					$("#status").html("The email you have entered is not valid.");
					break;
				case "err7":
					$("#status").html("you succ you habe 2 many accs");
					break;
			}
		});
	});
});
</script>
<?php $bop->footer(); ?>
