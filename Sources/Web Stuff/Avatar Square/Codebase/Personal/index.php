<? include "../header.php"; if($user){?>
<div class="container">
<center><h4>You currently have <? echo $myu->emeralds ?> cash, <? echo $myu->username ?></h5>
    <div class="section">
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">email</i></h2>
            <a href="/Personal/Messages"><h5 class="center">Messages</h5></a>

            <p class="light">You can use this feature to message other users!</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">add_box</i></h2>
            <a href="/Customize"><h5 class="center">Character</h5></a>

            <p class="light">You can customize your character, apply items you own and remove them here!</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">perm_identity</i></h2>
            <a href="/Profile?username=<? echo $myu->username ?>"><h5 class="center">Profile</h5></a>

            <p class="light">You can view your profile here and view what other people see about you!</p>
          </div>
        </div>
      </div>
    <div class="section">
<div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">settings</i></h2>
            <a href="/Personal/Settings"><h5 class="center">Settings</h5></a>

            <p class="light">You can use this feature to change your account's information</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">redeem</i></h2>
            <a href="/Upgrade"><h5 class="center">Memberships</h5></a>

            <p class="light">When using this feature, you can upgrade your accounts status.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">power_settings_new</i></h2>
            <a href="/user/logout.php"><h5 class="center">Logout</h5></a>

            <p class="light">You can sign out of your account by using this feature.</p>
          </div>
        </div>
      </div>
  </div>
<? } include "../footer.php"; ?>