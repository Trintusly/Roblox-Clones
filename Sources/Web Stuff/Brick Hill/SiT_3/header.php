<?php
$load = sys_getloadavg();
if ($load[0] > 18) {
?>
<!DOCTYPE html>
	<head>
		<title>Uh oh!</title>
		<link rel="icon" href="http://www.brick-hill.com/assets/BH_favicon.png">
		<link rel="stylesheet" href="/style.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
	</head>
	<body>
		<div id="body">
			<div style="height:120px;width:1px;"></div>
			<div id="box" style="height:300px;">
				<center>
					<div id="subsect">
						<h3>Uh oh...</h3>
					</div>
					<h4>The site is trying to handle too many requests!</h4>
					<h6>The site has been temporarily closed to deal with this influx in traffic, come back soon!</h6>
					<input type="hidden" value="<?php echo $load[0]; ?>">
					<input type="hidden" value="<?php echo $load[1]; ?>">
					<input type="hidden" value="<?php echo $load[2]; ?>">
				</center>
			</div>
		</div>
	</body>
</html>


<?php 
die();
}

include('config.php');

$membershipPower = -1;
if (isset($_SESSION['id'])) {
  
  $currentUserID = $_SESSION['id'];
  $findUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '$currentUserID'";
  $findUser = $conn->query($findUserSQL);
  
  if ($findUser->num_rows > 0) {
    $userRow = (object) $findUser->fetch_assoc();
  } else {
    unset($_SESSION['id']);
    //header('Location: /login/');
  }
  
  $power = $userRow->{'power'};
  $UID = $userRow->{'id'};
  $currentID = $userRow->{'id'};
  $curDate = date('Y-m-d H:i:s');
  $sqlRead = "UPDATE `beta_users` SET `last_online` = '$curDate' WHERE `id` = '$currentUserID'";
  $result = $conn->query($sqlRead);
  
  $membershipSQL = "SELECT * FROM `membership` WHERE `active`='yes' AND `user_id`='$currentUserID'";
  $membership = $conn->query($membershipSQL);
  while($membershipRow = $membership->fetch_assoc()) {
    $membershipID = $membershipRow['id'];
  $membershipValue = $membershipRow['membership'];
  $memSQL = "SELECT * FROM `membership_values` WHERE `value`='$membershipValue'";
  $mem = $conn->query($memSQL);
  $memRow = $mem->fetch_assoc();
  
  $membershipPower = max($membershipPower,$membershipValue);
  
  $currentDate = $curDate;
  $membershipEnd = date('Y-m-d H:i:s',strtotime($membershipRow['date'].' +'.$membershipRow['length'].' minutes'));
  if($currentDate >= $membershipEnd) {
    $stopSQL = "UPDATE `membership` SET `active`='no' WHERE `id`='$membershipID';";
    $stop = $conn->query($stopSQL);
  }
  }
  
  $membershipSQL = "SELECT * FROM `membership_values` WHERE `value`='$membershipPower'";
  $membership = $conn->query($membershipSQL);
  $membershipRow = $membership->fetch_assoc();

  $lastonline = strtotime($curDate)-strtotime($userRow->{'daily_bits'});
  if ($lastonline >= 86400) {
    $bits = ($userRow->{'bits'}+10);
    $sqlBits = "UPDATE `beta_users` SET `bits` = '$bits' WHERE `id` = '$currentUserID'";
    $result = $conn->query($sqlBits);

    $daily = $curDate;
    $sqlDaily = "UPDATE `beta_users` SET `daily_bits` = '$daily' WHERE `id` = '$currentUserID'";
    $result = $conn->query($sqlDaily);
    
    
    ////MEMBERSHIP CASH
  $membershipSQL = "SELECT * FROM `membership` WHERE `active`='yes' AND `user_id`='$currentUserID'";
  $membership = $conn->query($membershipSQL);
  while($membershipRow = $membership->fetch_assoc()) {
    $membershipValue = $membershipRow['membership'];
    $memSQL = "SELECT * FROM `membership_values` WHERE `value`='$membershipValue'";
    $mem = $conn->query($memSQL);
    $memRow = $mem->fetch_assoc();
    
    $userMemSQL = "SELECT * FROM `beta_users` WHERE `id`='$currentUserID'";
    $userMem = $conn->query($userMemSQL);
    $userMemRow = $userMem->fetch_assoc();
    $bucks = ($userMemRow['bucks']+$memRow['daily_bucks']);
    $bucksSQL = "UPDATE `beta_users` SET `bucks` = '$bucks' WHERE `id` = '$currentUserID'";
    $result = $conn->query($bucksSQL);
  }
  ////
  }
  $loggedIn = true;
} else {
  $loggedIn = false;
  
  $URI = $_SERVER['REQUEST_URI'];
  if ($URI != '/login/' && $URI != '/register/') {
    //header('Location: /login/');
  }
}

$shopUnapprovedAssetsSQL = "SELECT * FROM `shop_items` WHERE `approved`='no' ORDER BY `date` DESC LIMIT 0,10";
$shopUnapprovedAssets = $conn->query($shopUnapprovedAssetsSQL);
$unapprovedNum = $shopUnapprovedAssets->num_rows;
?>
<!DOCTYPE html>
  <head>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
    (adsbygoogle = window.adsbygoogle || []).push({
      google_ad_client: "ca-pub-8506355182613043",
      enable_page_level_ads: true
    });
  </script>
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="/javascript/security.js?r=<?php echo rand(10000,1000000) ?>"></script>
  <?php 
  if($loggedIn) {
    $theme = $userRow->{'theme'};
  } else {
    $theme = 0;
  }
  $themeArray = array(
  "0" => "",
  "1" => "",
  );
  //$themeName = strtr();
  
  if ($theme != 3) {
    ?>
    <script src="/javascript/css/night.js?r=<?php echo rand(10000,1000000) ?>"></script>
    <?php
  } 
  ?>
    <link rel="icon" href="http://www.brick-hill.com/assets/BH_favicon.png">
    <link rel="stylesheet" href="/style.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
  <?php 
  if ($theme == 1) {
    ?>
  <link rel="stylesheet" href="/winter-theme/winter-style.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <?php
  } elseif ($theme == 2) {
    ?>
  <link rel="stylesheet" href="/assets/night.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <?php
  } elseif ($theme == 3) {
    
  } elseif ($theme == 4) {
    ?>
    <link rel="stylesheet" href="/assets/SummerTheme.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <?php
  } elseif ($theme == 5) {
    ?>
    <link rel="stylesheet" href="/assets/FallTheme.css?r=<?php echo rand(10000,1000000) ?>" type="text/css">
    <?php
  }
  ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div id="header">
      <div id="banner">
  <?php if($loggedIn) {echo '<div id="welcome"><a class="nav" href="http://www.brick-hill.com">Welcome, '. $userRow->{'username'}.'</a></div>';} ?>
        <div id="info" <?php if(!$loggedIn) {echo 'style="visibility:hidden;"';} ?> >
          <span style="display:inline-block;float: left;margin-left: -5px;">
            <ul>
              <li><a class="nav" href="/money" title="bucks"><i class="fa fa-money"></i> <?php if($loggedIn) {echo number_format($userRow->{'bucks'});} ?></a></li>
              <li><a class="nav" href="/money" title="bits"><i class="fa fa-circle"></i> <?php if($loggedIn) {echo number_format($userRow->{'bits'});} ?></a></li>
            </ul>
          </span>
          <span style="float:right; display:inline-block;padding-left: 10px;">
            <ul>
              <li><a class="nav" href="/messages/"><i class="fa fa-envelope"></i>
                <?php 
                if($loggedIn) {
                  $mID = $userRow->{'id'};
                  $sqlSearch = "SELECT * FROM `messages` WHERE  `recipient_id` = '$mID' AND `read` = 0";
                  $result = $conn->query($sqlSearch);
                  
                  $messages = 0;
                  while($searchRow=$result->fetch_assoc()) {$messages++;}
                  echo number_format($messages); 
                }
                ?>
              </a></li>
              <li><a class="nav" href="/friends/"><i class="fa fa-users"></i> 
              <?php
              if($loggedIn) {
                $requestsQuery = mysqli_query($conn,"SELECT * FROM `friends` WHERE `to_id`='$mID' AND `status`='pending'");
                $requests = mysqli_num_rows($requestsQuery);
                echo number_format($requests);
              }
              ?>
              </a></li>
            </ul>
          </span>
        </div>
      </div>
      <div id="navbar">
        <span>
          <span>
          <?php
          if($loggedIn) {
            echo '<a href="/user?id='.$userRow->{'id'}.'">You</a>';
          } else {
            echo '<a href="/login/">You</a>';
          }
          ?>
          </span>
          <span> | </span>
          <span>
          <?php
          if($loggedIn) {
            echo '<a href="/customize/">Avatar</a>';
          } else {
            echo '<a href="/login/">Avatar</a>';
          }
          ?>
          </span>
          <span> | </span>
          <span>
            <a class="nav" href="/play/">Play</a>
          </span>
          <span> | </span>
          <span>
            <a class="nav" href="/shop/">Shop</a>
          </span>
          <span> | </span>
          <span>
            <a class="nav" href="/clans/">Clans</a>
          </span>
          <span> | </span>
          <span>
            <a class="nav" href="/search/">Search</a>
          </span>
          <span> | </span>
          <span>
            <a class="nav" href="/forum/">Forum</a>
          </span>
          <span> | </span>
          <span>
            <a class="nav" href="/membership/">Membership</a>
          </span>
          <?php
          if($loggedIn) {
            if($power >= 1) {echo '<span> | </span><span><a class="nav" href="/admin/">Admin'; if ($unapprovedNum > 0) { echo " ($unapprovedNum) ";} echo '</a></span>';}
          }
          ?>
          
          
          <span style="float:right; margin-top: -3px;">
          <?php
          if($loggedIn) {
            echo '<a class="nav" href="/logout/">Logout</a>';
          } else {
            echo '<a class="nav" href="/login/">Login</a>';
          }
          ?>
          </span>
        </span>
      </div>
      <?php
    echo '<div style="border: 1px solid #b57500;background-color: #ffa500;color: #fff;text-align:center;padding: 3px;margin-top:5px;">
The site has not yet finished upgrading. There will be broken links, images, and the site will go down from time to time.<br>
Do not report these issues, as they will be fixed.
      </div>';
      ?>
    </div>
<?php
  if($_SERVER['REMOTE_ADDR'] != '82.21.246.202') { //for working on the site
    //exit;
  }
  ////
  if($loggedIn) {
    $bannedSQL = "SELECT * FROM `moderation` WHERE `active`='yes' AND `user_id`='$currentID'";
    $banned = $conn->query($bannedSQL);
    if($banned->num_rows != 0) {//they are banned
      $URI = $_SERVER['REQUEST_URI'];
      if ($URI != '/banned/') {
      header('Location: /banned/');
    
      $bannedRow = $banned->fetch_assoc();
      $banID = $bannedRow['id'];
      $currentDate = strtotime($curDate);
      $banEnd = strtotime($bannedRow['issued'])+($bannedRow['length']*60);
      if($bannedRow['length'] <= 0) {$title = "You have been warned";}
      elseif($bannedRow['length'] < 60) {$title = "You have been banned for ".$bannedRow['length']." minutes";}
      elseif($bannedRow['length'] >= 60) {$title = "You have been banned for ".round($bannedRow['length']/60)." hours";}
      elseif($bannedRow['length'] >= 1440) {$title = "You have been banned for ".round($bannedRow['length']/1440)." days";}
      elseif($bannedRow['length'] >= 43200) {$title = "You have been banned for ".round($bannedRow['length']/43200)." months";}
      elseif($bannedRow['length'] >= 525600) {$title = "You have been banned for ".round($bannedRow['length']/525600)." years";}
      elseif($bannedRow['length'] >= 36792000) {$title = "You have been terminated";}
      echo '<head>
          <title>Banned - Brick Hill</title>
        </head>
        <body>
          <div id="body">
            <div id="box">
              <h3>'.$title.'</h3>
              <div style="margin:10px">
                Reviewed: ' . gmdate('m/d/Y',strtotime($bannedRow['issued'])) . '<br>
                Moderator Note:<br>
                <div style="border:1px solid;width:400px;height:150px;background-color:#F9FBFF">
                  ' . $bannedRow['admin_note'] . '
                </div>';
      
      if($currentDate >= $banEnd) {
        if(isset($_POST['unban'])) {
          $unbanSQL = "UPDATE `moderation` SET `active`='no' WHERE `id`='$banID'";
          $unban = $conn->query($unbanSQL);
          header("Refresh:0");
        }
        echo 'You can now reactivate your account<br>
        <form action="" method="POST">
          <input type="submit" name="unban" value="Reactivate my account">
        </form>';
      } else {
        echo 'Your account will be unbanned on ' . date('d-m-Y H:i:s',$banEnd);
      }
      echo '
              </div>
            </div>
          </div>
        </body>';
      exit;
    }
  }
  
  //kwame's testme
  /*else{
   echo"

   <Script>
  function testMe(){
     ";

     // Check if they are in the group - check userrow 
     $CheckIfInQ = mysqli_query($conn,"SELECT * FROM `clan_members` WHERE `group_id`='4' AND `user_id`='$UID' AND `status`='in'");
     $InGroup = mysqli_num_rows($CheckIfInQ);
     if ($InGroup > 0){ // they are in group
     
      // Check if they have egg
      $CheckEggQ = mysqli_query($conn,"SELECT * FROM `crate` WHERE `user_id`='$UID' AND `item_id`='913' AND `own`='no'");
      $HasEgg = mysqli_num_rows($CheckEggQ);
      if($HasEgg > 0){
        
        // Give them egg
        
        // Get current Serial and add 1
        $latestSerialQ = mysqli_query($conn,"SELECT * FROM  `crate` WHERE `item_id`='913' ORDER BY  `crate`.`serial` DESC LIMIT 1 ");
        $itemSerial = mysqli_fetch_array($latestSerialQ);
        $serial = $itemSerial[serial];
        $newSerial = $serial + 1;
        
        // Insert into their inventory
        //mysqli_query()
        echo "alert('u have egg')";
        }else{
          echo"alert('You already have this egg!')";
      }

      }else{
      echo "alert('You are not in BHH!')";
     }

     echo"
  };
</script>


    ";
  }*/
  
  }
  ////
?>