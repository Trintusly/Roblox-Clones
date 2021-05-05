<?php
include("../SiT_3/config.php");
include("../SiT_3/header.php");
include("../SiT_3/PHP/helper.php");

if($loggedIn) {
  $userID = $_SESSION['id'];
  $userSQL = "SELECT * FROM `beta_users` WHERE `id`='$userID'";
  $user = $conn->query($userSQL);
  $currentUserRow = $user->fetch_assoc();
}

if (isset($_GET['id'])) {
  $itemID = mysqli_real_escape_string($conn,intval($_GET['id']));
  $sql = "SELECT * FROM `shop_items` WHERE  `id` = '$itemID'";
  $result = $conn->query($sql);
  $shopRow = $searchRow=$result->fetch_assoc();
  if($_GET['id'] == $shopRow['id']) {} else { header('Location: /shop/');}
  $id = $searchRow['owner_id'];
  $sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
  $userResult = $conn->query($sqlUser);
  $userRow=$userResult->fetch_assoc();
} else {
  header('Location: /shop/');
}

if($loggedIn) {
  if (isset($_GET['approve']) && $currentUserRow['power'] >= 1) {
    $approveSQL = "UPDATE `shop_items` SET `approved`='yes' WHERE `id`='$itemID'";
    $approve = $conn->query($approveSQL);
    header('Location: item?id='.$itemID);
  }
  if (isset($_GET['decline']) && $currentUserRow['power'] >= 1) {
    $declineSQL = "UPDATE `shop_items` SET `approved`='declined' WHERE `id`='$itemID'";
    $decline = $conn->query($declineSQL);
    header('Location: item?id='.$itemID);
  }
  if (isset($_GET['desc']) && $currentUserRow['power'] >= 2) {
    $scrubSQL = "UPDATE `shop_items` SET `description`='[Content Removed]' WHERE `id`='$itemID'";
    $scrub = $conn->query($scrubSQL);
    
    $scrubSQL = "UPDATE `shop_items` SET `title`='[Content Removed]' WHERE `id`='$itemID'";
    $scrub = $conn->query($scrubSQL);
    header('Location: item?id='.$itemID);
  }
  if (isset($_GET['scrub_comment']) && $currentUserRow['power'] >= 2) {
    $comID = mysqli_real_escape_string($conn,intval($_GET['scrub_comment']));
    $scrubSQL = "UPDATE `item_comments` SET `comment`='[Content Removed]' WHERE  `id`='$comID'";
    $scrub = $conn->query($scrubSQL);
    header('Location: item?id='.$itemID);
  }
}

if ($shopRow['approved'] == 'yes') {$thumbnail = $searchRow['id'];}
elseif ($shopRow['approved'] == 'declined') {$thumbnail = 'declined';}
else {$thumbnail = 'pending';}

$soldSQL = "SELECT * FROM `crate` WHERE `item_id` = '$itemID' AND `user_id` !='$id' AND `own`='yes'";
$soldResult = $conn->query($soldSQL);
$amountSold = $soldResult->num_rows;

$realSoldSQL = "SELECT * FROM `crate` WHERE `item_id` = '$itemID' AND `own`='yes'";
$realSoldResult = $conn->query($realSoldSQL);
$realAmountSold = $realSoldResult->num_rows;

if($loggedIn) {
$currentUserID = $_SESSION['id'];
} else {
$currentUserID = 0;
}
$ownsSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' AND `user_id`='$currentUserID'";
$owns = $conn->query($ownsSQL);
if($owns->num_rows > 0) {$owns = true;} else {$owns = false;}

if($loggedIn && (isset($_POST['buyBucks']) || isset($_POST['buyBits']) || isset($_POST['buyFree']))) { //if they sent a buy request

  $serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC"; //find the serial SQL
  $serialQ = $conn->query($serialSQL); //
  $serialRow = $serialQ->fetch_assoc(); //
  $serial = $serialRow['serial']+1; //find the serial
  
  $currentUserSQL = "SELECT * FROM `beta_users` WHERE `id`='$currentUserID'";
  $currentUser = $conn->query($currentUserSQL);
  $currentRow = $currentUser->fetch_assoc();
  
  if(isset($_POST['buyBucks'])) {$type = 'bucks'; $price = $shopRow['bucks'];}
  if(isset($_POST['buyBits'])) {$type = 'bits'; $price = $shopRow['bits'];}
  if(isset($_POST['buyFree'])) {$type = 'bits'; $price = '0';}
  
  $buySQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`,`payment`,`price`) VALUES (NULL,'$currentUserID','$itemID','$serial','$type','$price')"; //get ready to give item
  
  
  $newBucks = $currentRow['bucks']-$shopRow['bucks']; //take bucks from customer
  $newBucksSQL = "UPDATE `beta_users` SET `bucks`='$newBucks' WHERE `id`='$currentUserID'"; //prep query for taking bucks
  $sellerBucks = $userRow['bucks']+(int)($shopRow['bucks']*0.8); //give bucks to seller 80% tax
  $sellerBucksSQL = "UPDATE `beta_users` SET `bucks`='$sellerBucks' WHERE `id`='$id'"; //prep query for giving bucks
  
  
  $newBits = $currentRow['bits']-$shopRow['bits']; //take bits from customer
  $newBitsSQL = "UPDATE `beta_users` SET `bits`='$newBits' WHERE `id`='$currentUserID'"; //prep query for taking bits
  $sellerBits = $userRow['bits']+(int)($shopRow['bits']*0.8); //give bits to seller 80% tax
  $sellerBitsSQL = "UPDATE `beta_users` SET `bits`='$sellerBits' WHERE `id`='$id'"; //prep query for giving bits
  

  if(!($owns)) {
    if($shopRow['collectible'] == 'yes') { //if it is a collectible
      if($amountSold >= $shopRow['collectible_q']) { //if it's out of still in stock
        header('Location: item?id='.$itemID.'&msg=stock');
      }
    }
    
    if(isset($_POST['buyFree'])) { //if they tried to buy it for free
      if($shopRow['bucks'] == 0 || $shopRow['bits'] == 0) { //if it is indeed free
        $buy = $conn->query($buySQL);
        header('Location: item?id='.$itemID.'&msg=success');
      } else {
        header('Location: item?id='.$itemID.'&msg=error');
      }
    }
    elseif(isset($_POST['buyBucks'])) { //tried to buy for bucks
      if($currentRow['bucks'] >= $shopRow['bucks'] && $shopRow['bucks'] > 0) { //check they have enough bucks AND if it was on sale for bucks
        $buy = $conn->query($buySQL);
        $newBucksQ = $conn->query($newBucksSQL);
        $sellerBucksQ = $conn->query($sellerBucksSQL);
        header('Location: item?id='.$itemID.'&msg=success');
      } else {
        header('Location: item?id='.$itemID.'&msg=money');
      }
    }
    elseif(isset($_POST['buyBits'])) { //tried to buy for bucks
      if($currentRow['bits'] >= $shopRow['bits'] && $shopRow['bits'] > 0) { //check they have enough bucks AND if it was on sale for bucks
        $buy = $conn->query($buySQL);
        $newBitsQ = $conn->query($newBitsSQL);
        $sellerBitsQ = $conn->query($sellerBitsSQL);
        header('Location: item?id='.$itemID.'&msg=success');
      } else {
        header('Location: item?id='.$itemID.'&msg=money');
      }
    }
  } else {
    header('Location: item?id='.$itemID.'&msg=have');
  }
}

if($loggedIn && isset($_POST['sell'])) {
  $bucks = mysqli_real_escape_string($conn,intval($_POST['sell']));

  $crateSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' AND `user_id`='$currentUserID' AND `own`='yes'";
  $crate = $conn->query($crateSQL);
  
  $sellSQL = "SELECT * FROM `special_sellers` WHERE `item_id`='$itemID' AND `user_id`='$currentUserID' AND `active`='yes'";
  $sell = $conn->query($sellSQL);
  
  if($crate->num_rows > $sell->num_rows && $bucks >= 1) {
    $crateRow = $crate->fetch_assoc();
    $serial = $crateRow['serial'];
    $listSQL = "INSERT INTO `special_sellers` (`id`,`user_id`,`item_id`,`serial`,`bucks`,`active`) VALUES (NULL,'$currentUserID','$itemID','$serial','$bucks','yes')";
    $list = $conn->query($listSQL);
  }
  
  header("Location: item?id=".$itemID);
}
if($loggedIn && isset($_POST['remove'])) {
  $sale = mysqli_real_escape_string($conn,intval($_POST['sale']));
  
  $currentUserSQL = "SELECT * FROM `beta_users` WHERE `id`='$currentUserID'";
  $currentUser = $conn->query($currentUserSQL);
  $currentRow = $currentUser->fetch_assoc();
  
  $sellSQL = "SELECT * FROM `special_sellers` WHERE `id`='$sale'";
  $sell = $conn->query($sellSQL);
  $sellRow = $sell->fetch_assoc();
  
  if($currentRow['id'] == $sellRow['user_id']) {
    $updateSaleSQL = "UPDATE `special_sellers` SET `active`='no' WHERE `id`='$sale'";
    $updateSale = $conn->query($updateSaleSQL);
  }
  header("Location: item?id=".$itemID);
}

if($loggedIn && isset($_POST['buySale'])) { ///NOT TESTED YET
  $sale = mysqli_real_escape_string($conn,intval($_POST['buySale']));
  
  $currentUserSQL = "SELECT * FROM `beta_users` WHERE `id`='$currentUserID'";
  $currentUser = $conn->query($currentUserSQL);
  $currentRow = $currentUser->fetch_assoc();
  
  $sellSQL = "SELECT * FROM `special_sellers` WHERE `id`='$sale'";
  $sell = $conn->query($sellSQL);
  $sellRow = $sell->fetch_assoc();
  
  $bucks = $sellRow['bucks'];
  if($sellRow['user_id'] != $_SESSION['id'] && $bucks <= $currentRow['bucks'] && $sellRow['active'] == 'yes') {
    $newBucks = $currentRow['bucks']-$bucks;
    
    $updateSaleSQL = "UPDATE `special_sellers` SET `active`='no' WHERE `id`='$sale'";
    $updateSale = $conn->query($updateSaleSQL);
    
    $sellerID = $sellRow['user_id'];
    $sellItemID = $sellRow['item_id'];
    $sellSerial = $sellRow['serial'];
    
    $sellerSQL = "SELECT * FROM `beta_users` WHERE `id`='$sellerID'";
    $seller = $conn->query($sellerSQL);
    $sellerRow = $seller->fetch_assoc();
    $sellerBucks = $sellerRow['bucks']+round(0.8*$bucks);
    
    $removeSQL = "UPDATE `crate` SET `own`='no' WHERE `user_id`='$sellerID' AND `item_id`='$sellItemID' AND `serial`='$sellSerial'";
    $remove = $conn->query($removeSQL);
    
    $addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`,`payment`,`price`) VALUES (NULL,'$currentUserID','$sellItemID','$sellSerial','bucks','$bucks')";
    $add = $conn->query($addSQL);
    
    $newSellerMoneySQL = "UPDATE `beta_users` SET `bucks`='$sellerBucks' WHERE `id`='$sellerID'";
    $newSellerMoney = $conn->query($newSellerMoneySQL);
    $newBuyerMoneySQL = "UPDATE `beta_users` SET `bucks`='$newBucks' WHERE `id`='$currentUserID'";
    $newBuyerMoney = $conn->query($newBuyerMoneySQL);
  }
}

?>




<!DOCTYPE html>
  <head>
    <title><?php echo htmlentities($shopRow['name']); ?> - Brick Hill</title>
  </head>
  <body>
    <div id="body">
    
    <?php
  if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    if($msg == "money"){
      echo "<h5 style='text-align:center; background-color:red; color:white; margin-top:5px; margin-left: 0px; margin-right: 0px; padding-top: 5px; padding-bottom: 5px;'>You dont have enough money to buy $shopRow[name].</h5>";
    } elseif ($msg == "have") {
      echo "<h5 style='text-align:center;background-color:red;color:white;margin-top:5px; margin-left: 0px; margin-right: 0px; padding-top: 5px; padding-bottom: 5px;'>You already own $shopRow[name].</h5>";
    } elseif ($msg == "stock"){
      echo "<h5 style='text-align:center;background-color:red;color:white;margin-top:5px; margin-left: 0px; margin-right: 0px; padding-top: 5px; padding-bottom: 5px;'>This item is out of stock.</h5>";
    } elseif ($msg == "success") {
      echo "<h5 style='text-align:center;background-color:green;color:white;margin-top:5px; margin-left: 0px; margin-right: 0px; padding-top: 5px; padding-bottom: 5px;'>You have successfully bought $shopRow[name]!</h5>";
    } elseif ($msg == "error") {
      echo "<h5 style='text-align:center;background-color:green;color:white;margin-top:5px; margin-left: 0px; margin-right: 0px; padding-top: 5px; padding-bottom: 5px;'>An unknown error occurred.</h5>";
    }
  }
    ?>
    
      <div id="box">
        <?php 
          echo '<h3 style="margin-left: 12px;">' . htmlentities($shopRow['name']) ;
            if ($loggedIn) {
      if ($power > 3) {
        echo '<span style="font-size:15px;">('.shopItemHash($shopRow['id']).')</span>';
      }
    }
      echo '</h3>';
        ?>
        <span style="display:inline-block; float:left; width:640px;">
          <?php
          if(isset($_GET['render']) && ($shopRow['owner_id'] == $_SESSION['id'] || $currentUserRow['power'] >= 1)) {
            echo '<iframe style="background-color:#FFF;float:left;border:1px #000 solid;width:340px;height:340px;" src="/avatar/render/shop_render?id='.$shopRow['id'].'"></iframe>';
          }
          else {
            echo '<img id="shopItem" src="/shop_storage/thumbnails/'.$thumbnail.'.png?c='. rand() .'" style="float:left; margin: 0px 10px 0px 10px; width: 340px; height: 340px;';
            if($shopRow['collectable-edition'] == 'yes'){echo 'background-image:url(\'speciale_big.png\'); background-size:cover; border:0px; width:342px; height:342px;';}
            elseif($shopRow['collectible'] == 'yes'){echo 'background-image:url(\'special_big.png\'); background-size:cover; border:0px; width:342px; height:342px;';}
            elseif($shopRow['bits'] == '0' || $shopRow['bucks'] == '0'){echo 'background-image:url(\'free_big.png\'); background-size:cover; border:0px; width:342px; height:342px;';}
            echo '">';
          }
        
            ?>
          <?php
            if ($shopRow['collectible'] == 'yes' || $shopRow['collectable-edition'] == 'yes') {
              $remaining = $shopRow['collectible_q']-$realAmountSold;
              echo "<span style=";
              if($remaining > 0) {echo 'font-weight:bold;';}
              echo "display:block;color:red;'>Special:<br>";
              echo $remaining." out of ".$shopRow['collectible_q']." remaining</span>";
            } else {$remaining = 1;}
            
            if($remaining > 0 && $loggedIn) {
      if ($shopRow['bucks'] == 0 || $shopRow['bits'] == 0) { 
        echo "<span style='display:inline-block;'>
          <a style='color:#44A4EE;'>FREE</a><br>
          <form method='post' action=''>
            <input style='border:1px solid #000; background-color:#44A4EE; color:#FFF;'' type='submit' name='buyFree' value='Take one'>
          </form>
        </span>";
      }
      
      if ($shopRow['bucks'] >= 1) {
        echo "<span style='display:inline-block;''>
          <a style='color:Green;'><i class='fa fa-money' style='padding-right: 5px;'></i>$shopRow[bucks]</a>
          <br>
          <form method='post' action=''>
            <input style='border:1px solid #000; background-color:Green; color:#FFF;' type='submit' name='buyBucks' value='Buy with Bucks'>
          </form>
        </span>";
      }
      
      if ($shopRow['bits'] >= 1) {
        echo "<span style='display:inline-block;''><a style='color:Orange;''><i class='fa fa-circle' style='padding-right: 5px;'></i>$shopRow[bits]</a>
          <br>
          <form method='post' action=''>
            <input style='border:1px solid #000; background-color:Orange; color:#FFF;' type='submit' name='buyBits' value='Buy with Bits'>
          </form>
        </span>";
      }
    }
            
          ?>
          <p><?php echo str_replace("\n","<br>",str_replace("<","&lt;",str_replace(">","&gt;",$shopRow['description']))); ?></p>
          <br>
          <?php
    if($loggedIn) {
      if($power >= 2) {
        echo '<span><a class="label" href="item?id='.$shopRow['id'].'&desc">Scrub</a></span>';
      }
    }
    ?>
          <h6>Created: <?php echo $shopRow['date']; ?>
          <br>Last Updated: <?php echo $shopRow['last_updated']; ?>
          <br>Sold: <?php echo $amountSold; ?></h6><br>
          <?php
          if($loggedIn) {
            echo '<span><a href="/report?type=item&id='.$shopRow['id'].'"><i style="color:#444;font-size:13px;" class="fa fa-flag"></i></a></span>';
            
            if($shopRow['owner_id'] == $_SESSION['id'] or $currentUserRow['power'] >= 1) {
              echo '<span><a href="?id='.$shopRow['id'].'&render"><i style="color:#444;font-size:13px;" class="fa fa-refresh"></i></a></span>';
              echo '<span><a href="edit?id='.$shopRow['id'].'"><i style="color:#444;font-size:13px;" class="fa fa-pencil"></i></a></span>';
            }
            
            if($shopRow['approved'] != 'yes' && $currentUserRow['power'] >= 1) {
              echo '<br><a style="color:#444;" href="?id='.$shopRow['id'].'&approve">Approve</a>';
            }
            if($currentUserRow['power'] >= 1) {
              echo '<br><a style="color:#444;" href="?id='.$shopRow['id'].'&decline">Decline</a>';
            }
          }
        ?>
        </span>
        <span style="display:inline-block; float:right;">
          <img style="width:225px; background-color:transparent;" src="http://storage.brick-hill.com/images/avatars/<?php echo $userRow['id']; ?>.png?c=<?php echo $userRow['avatar_id']; ?>">
          <h5>Created by:</h5>
          <a href="http://www.brick-hill.com/user?id=<?php echo $userRow['id']; ?>" style="color:#222;"><h4><?php echo $userRow['username']; ?></h4></a>
        </span>
      </div>
      <?php
        if($remaining <= 0) {
      ?>
      <div id="box" style="margin-top:10px;">
        <div id="subsect" style="overflow:auto;">
          <h3 style="margin-left:5px;float:left;">Sellers</h3>
          <?php
            $crateSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' AND `user_id`='$currentUserID' AND `own`='yes'";
            $crate = $conn->query($crateSQL);
            if($crate->num_rows >= 1) {
              echo '<form style="float:right;margin:10px;" action="" method="POST">
              <input type="text" name="sell" type="number" min="1">
              <input type="submit" value="Sell">
              </form>';
            }
          ?>
        </div>
        <?php
    $sellersSQL = "SELECT * FROM `special_sellers` WHERE `item_id`='$itemID' ORDER BY `bucks` ASC";
    $sellers = $conn->query($sellersSQL);
    while($sellRow = $sellers->fetch_assoc()) {
      $sellerID = $sellRow['user_id'];
      $bucks = $sellRow['bucks'];
      
      if($sellRow['active'] == 'yes') {
        $sellerSQL = "SELECT * FROM `beta_users` WHERE `id`='$sellerID'";
        $seller = $conn->query($sellerSQL);
        $sellerRow = $seller->fetch_assoc();
        
        //NEEDS CSS MAGIC
        echo '
        <div id="subsect" style="overflow:auto;">
          <form action="" method="POST">
          <div style="width:100px;float:left;">
            <a href="/user?id='.$sellerID.'"><img style="width:70px;" src="http://storage.brick-hill.com/images/avatars/'.$sellerID.'.png?c='.$sellerRow['avatar_id'].'"></a>
            <br><a href="/user?id='.$sellerID.'">'.$sellerRow['username'].'</a>
           </div>
            <input type="hidden" name="buySale" value="'.$sellRow['id'].'">
            <label class="label">#'.$sellRow['serial'].'</label><br>';
          if($sellerID != $_SESSION['id']) {
            echo '<button>Buy for  <i class="fa fa-money"></i> '.number_format($bucks).'</button>';
        } else {
            echo '<input type="hidden" name="sale" value="'.$sellRow['id'].'">
            <button class="red-button" name="remove">Remove  <i class="fa fa-money"></i> '.number_format($bucks).'</button>';
        }
        echo '</form>
        </div>';
      }
    }
        ?>
      </div>
      <?php
        }
      ?>
      <div id="box" style="margin-top:10px;">
        <div id="subsect">
        <h3 style="margin-left:5px;">Comments</h3>

        <?php
        if($loggedIn && isset($_POST['comment'])) {
          $lastCommentSQL = "SELECT * FROM `item_comments` WHERE `author_id`='$userID' ORDER BY `id` DESC";
          $lastCommentQ = $conn->query($lastCommentSQL);
          if($lastCommentQ->num_rows > 0) {
            $lastCommentRow = $lastCommentQ->fetch_assoc();
            $lastComment = $lastCommentRow['time'];
          } else {
            $lastComment = 0;
          }
          
          if(time()-strtotime($lastComment) >= 30) {//they can post
            $comment = mysqli_real_escape_string($conn,$_POST['comment']);
            if(strlen($comment) >= 2 && strlen($comment) <= 100) {
              $commentSQL = "INSERT INTO `item_comments` (`id`,`author_id`,`item_id`,`comment`,`time`) VALUES (NULL,'$userID','$itemID','$comment',CURRENT_TIMESTAMP)";
              $commentQ = $conn->query($commentSQL);
              header("Location: item?id=".$itemID);
      } else {
        echo 'Comment must be between 2 and 100 characters';
      }
          } else {
            echo 'Please wait before posting again';
          }
        }
        
        
        /*
        if(isset($_POST['CommentTxT'])){
          // check if there LATEST comment older than 30seconds
          // i cant have $Comments variable as ive used it later on in the code so i called it $PostedComments
          // BUT WAIT! Check if they even have a comment on the item?!?
          $CommentTxT = mysqli_real_escape_string($conn,$_POST['CommentTxT']);
          $hasCommentQ = mysqli_query($conn,"SELECT * FROM `item_comments` WHERE `USER_ID`='$userID' AND `ITEM_ID`='$itemID'");
          $hasComment = mysqli_num_rows($hasCommentQ);

          if($hasComment > 0){
            // yes they do
            // check if there LATEST comment older than 30seconds
              
              $PostedCommentsQ = mysqli_query($conn,"SELECT * FROM `item_comments` WHERE `USER_ID`='$userID' AND `ITEM_ID`='$itemID' ORDER BY `TIME` DESC");
              $LatestComment = mysqli_fetch_array($PostedCommentsQ);
              
              // Latest comment found. check time aganist this incoming comment
              $CurrentTime = time();
              $LastPostTime = strtotime($LatestComment['TIME']);
              // Both times are now in seconds

              $TimeCheck = $CurrentTime - $LastPostTime;
              
              if($TimeCheck > 60){
                  // Older than 60 seconds lol, they can post comment
                mysqli_query($conn,"INSERT INTO `item_comments` VALUES(NULL,'$userID','$itemID','$CommentTxT',CURRENT_TIMESTAMP())");
                  echo"<center>
                  <form action='' method='post'>
                    <textarea name='CommentTxT' style='width:790;height:80;' rows='5' cols='120' maxlength='500' disabled>Posted successfully!</textarea>
                    <button disabled>Post</button>
                  </form>
                </center>";
              }else{
                echo"<center>
                  <form action='' method='post'>
                    <textarea name='CommentTxT' style='width:790;height:80;' rows='5' cols='120' maxlength='500' disabled>Please wait!</textarea>
                    <button disabled>Post</button>
                  </form>
                </center>";
              }
              /*


                <center>
                  <form action='' method='post'>
                    <textarea name='CommentTxT' style='width:790;height:80;' rows='5' cols='120' maxlength='500' disabled>Please do not spam!</textarea>
                    <button disabled>Post</button>
                  </form>
                </center>"
            * /}else{
              // They havent posted before. let them post
              mysqli_query($conn,"INSERT INTO `item_comments` VALUES(NULL,'$userID','$itemID','$CommentTxT',CURRENT_TIMESTAMP())");
              echo"<script>location.reload();</script>";
            }
          }else{
              // They can post
              echo"<form action='' method='post'>
                    <textarea name='CommentTxT' style='width:790;height:80;' rows='5' cols='120' maxlength='500'></textarea>
                    <button>Post</button>
                  </form>";
            }*/
            ?>
            <?php if ($loggedIn) { ?>
            <form action="" method="POST" style="margin:5px;">
              <textarea name="comment" style="width: 99.3%; height: 80px; margin: 0px; resize: vertical;"></textarea><br>
              <input type="submit" value="Comment">
            </form>
<?php } ?>

        </div>
        <?php
        $comments = mysqli_query($conn, "SELECT * FROM `item_comments` WHERE `item_id`='$itemID' ORDER BY `id` DESC");

        while($commentRow = mysqli_fetch_assoc($comments)) {
              $commentUserID = $commentRow['author_id'];
              $userDataQ = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id`='$commentUserID'");
              $userData = mysqli_fetch_array($userDataQ);
              echo'<div id="subsect" style="overflow:auto;"><span style="float:left;"><a href="/user?id='.$commentUserID.'" style="color:#333;"><img style="width:55px;" src="http://storage.brick-hill.com/images/avatars/'.$commentUserID.'.png?c='.rand().'"><br>'.$userData['username'].'</a></span><span><span style="font-size:12px;">'.$commentRow['time'].'</span><br>'. htmlentities($commentRow['comment']).'</span>';
              if($loggedIn && $power >= 1) {
                echo '<div><a class="label" href="item?id='.$shopRow['id'].'&scrub_comment='.$commentRow['id'].'">Scrub</a></div>';
              }
              echo '</div>';
        }
        ?>
      </div>
    </div>
  <?php
  include("../SiT_3/footer.php");
  ?>
  </body>
</html>