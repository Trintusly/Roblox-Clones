<? include('../header.php');
if (!$user) { ?>
<div class="bc-content" style="min-width:400px;width:400px;margin:0 auto;">
<div class="signin-hold">
<? include('../api/user/sign_in_account.php'); ?>
<form method="post" class="sign-form basic-font">
<h5 style="padding:0;margin:0;padding-bottom:25px;">Log in</h5>
<input type="text" name="username" id="username" class="general-textarea" placeholder="Username">
<div style="height:15px;"></div>
<input type="password" name="password" id="password" class="general-textarea" placeholder="Password">
<div style="height:15px;"></div>
<input type="submit" name="submit" style="background:#2196F3;color:white;width:100px;padding:10px 8px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;" class="edit-hover" value="Login">
</form></div>
<? } include('../footer.php'); ?>