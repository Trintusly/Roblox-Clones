<?php include('../header.php'); ?>
<div class="register-hold">
<?php include('../api/user/create_account.php'); ?>
<div class="bc-content" style="min-width:400px;width:400px;margin:0 auto;">
<h5 style="padding:0;margin:0;padding-bottom:25px;">Register</h5>
<form action="" method="POST">
<input type="text" name="email" id="email" class="general-textarea" placeholder="Email Address">
<div style="height:15px;"></div>
<input type="text" name="username" id="username" class="general-textarea" placeholder="Username">
<div style="height:15px;"></div>
<input type="password" name="password" id="password" class="general-textarea" placeholder="Password">
<div style="height:15px;"></div>
<input type="password" name="confirmpassword" id="confirmpassword" class="general-textarea" placeholder="Confirm Password">
<div style="height:15px;"></div>
<div style="height:10px;"></div>
<input type="submit" name="submit" style="background:#2196F3;color:white;width:100px;padding:10px 8px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;" class="edit-hover" value="Register">
</form> </div> <?php include('../footer.php'); ?>