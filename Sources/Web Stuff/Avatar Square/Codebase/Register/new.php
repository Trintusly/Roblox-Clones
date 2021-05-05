<?php include('../header.php'); ?>
<div class="register-hold">
<?php include('../api/user/create_account.php'); ?>
<div class="content-box" style="min-width:400px;width:400px;margin:0 auto;">
<h5 style="padding:0;margin:0;padding-bottom:25px;">Register</h5>
<form action="" method="POST">
<input type="text" name="email" id="email" class="general-textarea" placeholder="Email Address">
<div style="height:15px;"></div>
<input type="text" name="username" id="username" class="general-textarea" placeholder="Username">
<div style="height:15px;"></div>
<input type="password" name="password" id="password" class="general-textarea" placeholder="Password">
<div style="height:15px;"></div>
<input type="password" name="confirmpassword" id="confirmpassword" class="general-textarea" placeholder="Password (again)">
<div style="height:15px;"></div>
<input type="submit" name="submit" class="groups-blue-button" style="padding:0;padding:4px 8px;" value="Register">
</form> </div> <?php include('../footer.php'); ?>