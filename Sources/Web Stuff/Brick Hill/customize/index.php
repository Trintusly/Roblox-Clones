<?php
    include("../SiT_3/config.php");
    include("../SiT_3/header.php");
    
    if(!$loggedIn) {header("Location: index"); die();}
    
    $userId = $_SESSION['id'];
    
    
    if (isset($_POST['Purge'])) {
    	$purgeSQL = "UPDATE `avatar` SET `shirt`='0', `pants`='0', `tshirt`='0', `hat1`='0', `cache`='0' WHERE `user_id`='$userId'";
    	$purge = $conn->query($purgeSQL);
    	header("Location: /customize/?regen");
    }
  
  $findUserAvatarSQL = "SELECT * FROM `avatar` WHERE `user_id` = '$userId'";
  $findUserAvatar = $conn->query($findUserAvatarSQL);
  $userAvatar = (object) $findUserAvatar->fetch_assoc();
  
  $sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$userId'";
  $userResult = $conn->query($sqlUser);
  $userRow=$userResult->fetch_assoc();
  
  /*
  First Color = Head Color
  Second Color = Torso Color
  Third Color = Right Arm Color
  Fourth Color = Left Arm Color
  Fifth Color = Right Leg Color
  Sixth Color = Left Leg Color
  */
  
  if (isset($_POST['color'])) {
    
    if (isset($_GET['part'])) {
      
      $partArray = array(
        "head",
        "torso",
        "rightArm",
        "leftArm",
        "rightLeg",
        "leftLeg"
      );
      
      //echo $_GET['part'];
      
      if (in_array( $_GET['part'], $partArray )) {
        //echo'yay';
      } else {
        header('Location: /customize/?error=ip');
        die();
      }
      
      $colorArray = array (
        "f3b700",
        "d34a05",
        "c60000", 
        "c81879", 
        "1c4399",  
        "3292d3",  
        "c2dc7f",      
        "1d6a19",
        "85ad00",
        "441209",  
        "c15b2c",  
        "f1f1f1",  
        "fcfcc9",  
        "fcff81",  
        "e087b6",
        "815ea6",
        "7eb2e6",  
        "39b2ca", 
        "b9ded1",
        "caad64",
        "eab372",
        "ddddd0",
        "e58700",
        "810058",
        "ac93c6",
        "4578bb",
        "4f607a", 
        "507051", 
        "76603f",
        "ffffff",
        "897f7e",
        "7b8183", 
        "650013",  
        "220965", 
        "3b1e81",  
        "586e85",
        "248233",
        "6e703f", 
        "936941",  
        "8d290b",  
        "3b3f44",  
        "936b1c",  
        "0a1b32",
        "103a21",
        "210c07",
        "000000",
        "37302c", 
        "3b3f44",  
        "eeec9f",  
        "e1a479",
        "de9c93",
        "d97b87",
        "e4b9d4", 
        "b9b6d7",  
        "cbe2ec",  
        "9ec6eb",  
        "d7e3f3",
        "a2c8a5",
        "bff59e",
        "eeea98",  
        "bdb4b0",  
        "e9eaee",  
        "9ec6eb"  
      );
      
      if (in_array( $_POST['color'], $colorArray )) {
        
        $partReplace = array(
          "head" => "head_color",
          "torso" => "torso_color",
          "rightArm" => "right_arm_color",
          "leftArm" => "left_arm_color",
          "rightLeg" => "right_leg_color",
          "leftLeg" => "left_leg_color"
        );
        
        $part = strtr($_GET['part'], $partReplace);
        $color = mysqli_real_escape_string($conn, $_POST['color']);
        
        $updateColorSQL = "UPDATE `avatar` SET `$part` = '$color' WHERE `user_id` = '".$_SESSION['id']."'";
        $updateColor = $conn->query($updateColorSQL);
        if ($updateColor) {
          header("Location: /customize/?error=suc&regen");
          die();
        } else {
          header("Location: /customize/?error=ue");
          die();
        }
        
      } else {
        header('Location: /customize/?error=ihc');
        die();
      }
    }
  }
  
  if (isset($_POST['remove'])) {
	  
	  $hatNum = $_POST['remove'];

	  $hatThings = array(
		"h1",
		"h2",
		"h3",
		"h4",
		"h5",
		"s",
		"tool",
		"p",
		"t",
		"f"
	  );
	  
	  if (in_array($hatNum, $hatThings)) {
		  
		  $hatTypes = array(
			"h1" => "hat1",
			"h2" => "hat2",
			"h3" => "hat3",
			"h4" => "hat4",
			"h5" => "hat5",
			"s" => "shirt",
			"tool" => "tool",
			"p" => "pants",
			"t" => "tshirt",
			"f" => "face"
		  );
		  
		  $hatNumber = strtr($hatNum, $hatTypes);
		  
		  $removeHatSQL = "UPDATE `avatar` SET `$hatNumber` = '0' WHERE `user_id` = '".$_SESSION['id']."'";
		  $removeHat = $conn->query($removeHatSQL);
		  
		  if (!$removeHat) {
			  die("luke did 9/11");
			  header("Location: ?msg=ue");
			  die();
		  } else {
		  
		  header("Location: ?msg=srh");
		  die();
		  
		  }
	  }
	  
  }
  
  if (isset($_POST['wear'])) {
	  
	  $userCurrentItems = array(
		$userAvatar->{'hat1'},
		$userAvatar->{'hat2'},
		$userAvatar->{'hat3'},
		$userAvatar->{'hat4'},
		$userAvatar->{'hat5'},
		$userAvatar->{'shirt'},
		$userAvatar->{'tool'},
		$userAvatar->{'pants'},
		$userAvatar->{'tshirt'}
	  );
	  
	  $itemID = $_POST['wear'];
	  $itemIDSafe = mysqli_real_escape_string($conn , $itemID); // Make it safe to query
	  
	  if (in_array($itemID, $userCurrentItems)) {
		  header("Location: ?msg=ue");
		  die();
	  }
	  
	  $itemExistsSQL = "SELECT * FROM `shop_items` WHERE `id` = '$itemIDSafe'";
	  $itemExists = $conn->query($itemExistsSQL);
	
	  if ($itemExists->num_rows > 0) {
		  
		  $userHasItemSQL = "SELECT * FROM `crate` WHERE `item_id` = '$itemIDSafe' AND `own`='yes' AND `user_id` = '" . $_SESSION['id'] ."'";
		  $userHasItem = $conn->query($userHasItemSQL);

		  if ($userHasItem->num_rows > 0) {
			  
			  $itemRow = (object) $itemExists->fetch_assoc();
			  if ($itemRow->{'approved'} !== "yes") {
				  die("no u");
			  }
			  $itemType = $itemRow->{'type'};
				if ($itemType == "hat") {
					
				  if ($userAvatar->{'hat1'} == 0) {
					$equipHatSQL = "UPDATE `avatar` SET `hat1` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
				  } elseif ($userAvatar->{'hat2'} == 0) {
					$equipHatSQL = "UPDATE `avatar` SET `hat2` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
				  } elseif ($userAvatar->{'hat3'} == 0) {
					$equipHatSQL = "UPDATE `avatar` SET `hat3` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
				  } elseif ($userAvatar->{'hat4'} == 0) {
					$equipHatSQL = "UPDATE `avatar` SET `hat4` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
				  } elseif ($userAvatar->{'hat5'} == 0) {
					$equipHatSQL = "UPDATE `avatar` SET `hat5` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
				  } else {
					$equipHatSQL = "UPDATE `avatar` SET `hat1` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
				  }
				  
				  $equipHat = $conn->query($equipHatSQL);
				  
				  if (!$equipHat) {
					//header("Location: ?msg=ue2");
					die('error');
				  } else {
					header("Location: ?msg=swh");
					die();
				  }
				} elseif ($itemType == "shirt") {
					
					$equipShirtSQL = "UPDATE `avatar` SET `shirt` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
					
					$equipHat = $conn->query($equipShirtSQL);
				} elseif ($itemType == "pants") {
					
					$equipPantsSQL = "UPDATE `avatar` SET `pants` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
					
					$equipPants = $conn->query($equipPantsSQL);
					
				} elseif ($itemType == "tool") {
					
					$equipToolSQL = "UPDATE `avatar` SET `tool` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
					
					$equipTool = $conn->query($equipToolSQL);
					
					if (!$equipHat) {
						header("Location: ?msg=ue2");
						die();
					} else {
						header("Location: ?msg=swh");
						die();
					}
						
				}  elseif ($itemType == "tshirt") {
					
					$equipTShirtSQL = "UPDATE `avatar` SET `tshirt` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
					
					$equipTShirt = $conn->query($equipTShirtSQL);
				} elseif ($itemType == "face") {
					$equipFaceSQL = "UPDATE `avatar` SET `face` = '$itemIDSafe' WHERE `user_id` = '". $_SESSION['id'] ."'";
					
					$equipFace = $conn->query($equipFaceSQL);
				} 
				
		  } else {
			  header("Location: ?msg=ue3");
			die();
		  }
		  
	  } else {
		  
		header("Location: ?msg=ue1");
		die();
		
	  }
	  
  }
  

  
    ?>
<!DOCTYPE html>
<html>
<head>
  <title>Customize - Brick Hill</title>
</head>
<body>
  <div id="body">
	
	 <div style="border: 1px solid #b57500;background-color: #ffa500;color: #fff;text-align:center;padding: 3px;">
          Customizing is in maintenance. Errors may occur.
      </div>
	<div style="height:10px;"></div>
    <?php if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "ihc") {?>
      <div style="border: 1px solid red;background-color: #E9EBF3;text-align:center;padding: 3px;">
          Invalid Hex Color!
      </div>
      <div style="height: 10px;"></div>
        <?php }  elseif ($_GET['msg'] === "ip") {
        ?>
        <div style="border: 1px solid green;background-color: #E9EBF3;text-align:center;padding: 3px;">
          Sucessfully changed color!
          </div>
          <div style="height: 10px;"></div>
        <?php
        } elseif ($_GET['msg'] == "ue") { 
        ?>
        <div style="border: 1px solid red;background-color: #E9EBF3;text-align:center;padding: 3px;">
          Unknown Error!
        </div>
        <div style="height: 10px;"></div>
        <?php
        } elseif ($_GET['msg'] == "suc") {
          ?>
          <div style="border: 1px solid green;background-color: #E9EBF3;text-align:center;padding: 3px;">
          Sucessfully changed color!
          </div>
          <div style="height: 10px;"></div>
          <?php
        } elseif ($_GET['msg'] == "na") {
			?>
			<div style="border: 1px solid green;background-color: #E9EBF3;text-align:center;padding: 3px;">
			Item is either not approved or has been declined.
			</div>
			<div style="height: 10px;"></div>
			<?php
		}
        } ?>
    <div id="column" style="width: 55%;float:right;">
      <div id="box" style="width:100%;">
        <div id="subsect" style="text-align:center;">
          <h3>Crate</h3>
        </div>
		<style>
			.getPageClicker:hover {
				cursor: pointer;
			}
		</style>
        <div style=" color: black; font-weight: 600; padding-bottom: 15px;text-align:center;">
          <span><a class="getPageClicker" onclick="getPage('hat', 0)" style=" color: black; font-weight: 600;">Hats</a></span>
          <span>|</span> <span><a class="getPageClicker" onclick="getPage('face', 0)" style=" color: black; font-weight: 600;">Faces</a></span>
          <span>|</span> <span><a class="getPageClicker" onclick="getPage('tool', 0)" style=" color: black; font-weight: 600;">Tools</a></span>
          <span>|</span> <span><a class="getPageClicker" onclick="getPage('shirt', 0)" style=" color: black; font-weight: 600;">Shirts</a></span>
          <span>|</span> <span><a class="getPageClicker" onclick="getPage('pants', 0)" style=" color: black; font-weight: 600;">Pants</a></span>
          <span>|</span> <span><a class="getPageClicker" onclick="getPage('tshirt', 0)" style=" color: black; font-weight: 600;">T-Shirts</a></span>
          <span>|</span> <span><a href="/shop/upload/" style=" color: black; font-weight: 600;">Create</a></span><br>
          </div>
          <div id="inventory" style="margin-left:25px;text-align:center;">
          <?php 
		  
		  $curItemArray = array(
			$userAvatar->{'hat1'},
			$userAvatar->{'hat2'},
			$userAvatar->{'hat3'},
			$userAvatar->{'hat4'},
			$userAvatar->{'hat5'},
			$userAvatar->{'shirt'},
			$userAvatar->{'tool'},
			$userAvatar->{'pants'}
		);
		  
         /* $userRowQuery = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id` = '$userId' ");
          $userRow = mysqli_fetch_array($userRowQuery);
          $crate = mysqli_query($conn, "SELECT * FROM `crate` WHERE `user_id` = '$userRow[id]'");
          if (mysqli_num_rows($crate) > 0) { 
            while($crateRow = mysqli_fetch_assoc($crate)) {
                // Get item information
                  $item = mysqli_query($conn,"SELECT * FROM `shop_items` WHERE `id` = '$crateRow[item_id]'");
                  $itemRow = mysqli_fetch_array($item);
                  $itemSpecialName = str_replace("'","\'",$itemRow['name']);
				  
                  ?>
					<div style="clear: both;margin: 10px;width: 142px;display:inline-block;">
						<a href="/shop/item.php?id=<?php echo $itemRow['id']; ?>"></a>
							<img id="shopItem" <?php 
							if ($itemRow['type'] == "shirt") {
								?>
								style="padding-left:10px;padding-right:10px;width:120px;"
								<?php
							} else {};
							?><?php if ($itemRow['type'] == "shirt") {
								?>
								style="padding-left:10px;padding-right:10px;width:120px;"
								<?php } else{}; ?> src="/shop_storage/thumbnails/<?php echo $itemRow['id']; ?>.png"></a>
							<span style="text-align:center;display:inline-block;float:left;width: 100%;padding-left: 0;padding-right: 0;">
								<a class="shopTitle" href="/shop/item.php?id=<?php echo $itemRow['id']; ?>">
									<?php echo $itemRow['name']; ?><br>
								</a>
							</span>
							
							<?php 
							if (in_array($itemRow['id'], $curItemArray, true)) {
								echo '<form style="margin: 0px;">
									<button style="color: #fff;background-color:green;margin:auto;margin: -135px;position: absolute;">Wearing</button>
			 				</form>';
							} else {
							
							?>
									<button onclick="wear(<?php echo $itemRow['id'];  ?>)" style="color: #fff;background-color:green;margin:auto;margin: -135px;position: absolute;">Wear</button>
			 				
							<?php 
							}
							?>
				 	</div>
                  
                 
                  <?php
                  //echo '</div></a>';
              }
          } else {
              echo"<div style='text-align:center;'><p>You have no items in your crate! Go to the <a style='color:#5585b7;' href='/shop'>shop</a> to purchase hats!</p></div>";
          }  */
          ?>
        </div>
      </div>
      <div id="box" style="width:100%; margin-top:10px;">
        <div id="subsect" style="text-align:center;">
          <h3>Currently Wearing</h3>
        </div>
        <div id="wearing">
        </div>
      
        
      </div>
      <div id="box" style="width:100%;margin-top:10px;text-align:center;position: relative;height: 325px;">
        <div id="subsect">
          <h3>Avatar Colors</h3><i style=" font-size: 13px; font-weight: 600; color: #555555;">Pick a body part, then click the a color in the color palette.</i>
        </div>
        <div style=" position: absolute; left: 45%; top: 69px;">
          <button onclick="headColor()" style="background-color: #<?php echo $userAvatar->{'head_color'}; ?>;padding: 25px;margin-top: -1px;">
        </div>
        <div style=" position: absolute; left: 40.1%; top: 121px;">
          <button onclick="torsoColor()" style="background-color: #<?php echo $userAvatar->{'torso_color'}; ?>;padding: 50px;">
        </div>
        <div style=" position: absolute; left: 29.1%; top: 121px;">
          <button onclick="lArmColor()" style="background-color: #<?php echo $userAvatar->{'left_arm_color'}; ?>;padding: 50px;padding-right: 0px;">
        </div>
        
<div style=" position: absolute; left: 61.3%; top: 121px;">
          <button onclick="rArmColor()" style="background-color: #<?php echo $userAvatar->{'right_arm_color'}; ?>;padding: 50px;padding-right: 0px;">
        </div>

<div style="position: absolute;left: 40.2%;top: 226px;">
         <button onclick="lLegColor()" style="background-color: #<?php echo $userAvatar->{'left_leg_color'}; ?>;padding: 50px;padding-right: 0px;padding-left: 47px;">
        </div><div style="position: absolute;left: 51.0%;top: 226px;margin-left: -2px;">
          <button onclick="rLegColor()" style="background-color: #<?php echo $userAvatar->{'right_leg_color'}; ?>;padding: 50px;padding-right: 0px;padding-left: 47px;">
        </div>
        
        
      </div>
    </div>
    <div id="column" style="width:394px; float:left;">
      <div id="box" style="width:100%; text-align:center;position: relative;">
      <div id="subsect">
        <h3>Customize</h3>
      </div>
      <h5>Your Avatar:</h5>
      <div id="avatar"><img src="http://storage.brick-hill.com/images/avatars/<?php echo $userRow['id']; ?>.png?c=<?php echo $userRow['avatar_id']; ?>"></div>
      <button onClick="avatarRedraw()">Refresh</button>
      <form action="" method="POST" style="display:inline-block;">
      	<input class="red-button" type="submit" name="Purge" value="Purge">
      </form>
      </div>
      <div id="box" style="width:100%; margin-top:10px;">
        <div id="subsect" style="text-align:center;">
          <h3>Color Pallete</h3>
        </div>
        <div id="subsect" style="text-align:center;">
          <h3>Editing: <span id="ce">Head</span></h3>
        </div>
        <form action="?regen&part=head" method="POST" id="colors">
        <div style="padding: 5px;">
          <div style=" position: relative; height: 492px; overflow-x: hidden; margin-left: 1px;">
            <div>
              <button class="colorPallete" style=" position: absolute; padding: 25px; background: #f3b700;" name="color" value="f3b700"></button>
              <button class="colorPallete" style=" position: absolute; padding: 25px; background: #d34a05; left: 55px;" name="color" value="d34a05"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #c60000; left: 110px;" name="color" value="c60000"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #c81879; left: 165px;" name="color" value="c81879"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #1c4399; left: 220px;" name="color" value="1c4399"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #3292d3; left: 275px;" name="color" value="3292d3"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #c2dc7f; left: 330px;" name="color" value="c2dc7f"></button>
            </div>
            <div style=" padding-top: 55px;">
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #1d6a19;" name="color" value="1d6a19"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #85ad00; left: 55px;" name="color" value="85ad00"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #441209; left: 110px;" name="color" value="441209"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #c15b2c; left: 165px;" name="color" value="c15b2c"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #f1f1f1; left: 220px;" name="color" value="f1f1f1"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #fcfcc9; left: 275px;" name="color" value="fcfcc9"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #fcff81; left: 330px;" name="color" value="fcff81"></button>
            </div>
            <div style=" padding-top: 55px;">
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #e087b6;" name="color" value="e087b6"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #815ea6; left: 55px;" name="color" value="815ea6"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #7eb2e6; left: 110px;" name="color" value="7eb2e6"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #39b2ca; left: 165px;" name="color" value="39b2ca"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #b9ded1; left: 220px;" name="color" value="b9ded1"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #caad64; left: 275px;" name="color" value="caad64"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #eab372; left: 330px;" name="color" value="eab372"></button>
            </div>
            <div style=" padding-top: 55px;">
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #ddddd0;" name="color" value="ddddd0"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #e58700; left: 55px;" name="color" value="e58700"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #810058; left: 110px;" name="color" value="810058"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #ac93c6; left: 165px;" name="color" value="ac93c6"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #4578bb; left: 220px;" name="color" value="4578bb"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #4f607a; left: 275px;" name="color" value="4f607a"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #507051; left: 330px;" name="color" value="507051"></button>
            </div>
            <div style=" padding-top: 55px;">
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #76603f;" name="color" value="76603f"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #ffffff; left: 55px;" name="color" value="ffffff"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #897f7e; left: 110px;" name="color" value="897f7e"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #7b8183; left: 165px;" name="color" value="7b8183"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #650013; left: 220px;" name="color" value="650013"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #220965; left: 275px;" name="color" value="220965"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #3b1e81; left: 330px;" name="color" value="3b1e81"></button>
            </div>
            <div style=" padding-top: 55px;">
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #586e85;" name="color" value="586e85"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #248233; left: 55px;" name="color" value="248233"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #6e703f; left: 110px;" name="color" value="6e703f"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #936941; left: 165px;" name="color" value="936941"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #8d290b; left: 220px;" name="color" value="8d290b"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #3b3f44; left: 275px;" name="color" value="3b3f44"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #936b1c; left: 330px;" name="color" value="936b1c"></button>
            </div>
            <div style=" padding-top: 55px;">
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #0a1b32;" name="color" value="0a1b32"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #103a21; left: 55px;" name="color" value="103a21"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #210c07; left: 110px;" name="color" value="210c07"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #000000; left: 165px;" name="color" value="000000"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #37302c; left: 220px;" name="color" value="37302c"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #3b3f44; left: 275px;" name="color" value="3b3f44"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #eeec9f; left: 330px;" name="color" value="eeec9f"></button>
            </div>
            <div style=" padding-top: 55px;">
              <button class="colorPallete"  style=" position: //absolute; padding: 25px; background: #e1a479;" name="color" value="e1a479"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #de9c93; left: 55px;" name="color" value="de9c93"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #d97b87; left: 110px;" name="color" value="d97b87"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #e4b9d4; left: 165px;" name="color" value="e4b9d4"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #b9b6d7; left: 220px;" name="color" value="b9b6d7"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #cbe2ec; left: 275px;" name="color" value="cbe2ec"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #9ec6eb; left: 330px;" name="color" value="9ec6eb"></button>
            </div>
            <div style=" padding-top: 3px;">
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #d7e3f3;" name="color" value="d7e3f3"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #a2c8a5; left: 55px;" name="color" value="a2c8a5"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #bff59e; left: 110px;" name="color" value="bff59e"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #eeea98; left: 165px;" name="color" value="eeea98"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #bdb4b0; left: 220px;" name="color" value="bdb4b0"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #e9eaee; left: 275px;" name="color" value="e9eaee"></button>
              <button class="colorPallete"  style=" position: absolute; padding: 25px; background: #9ec6eb; left: 330px;" name="color" value="9ec6eb"></button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <script src="javascript/color.js">
  </script>
  <script>
	window.onload = function() {
		getWearing();
		getPage('hat',0);
		<?php if(isset($_GET['regen'])) {echo 'avatarRedraw();';} ?>
	};
  
  	function avatarRedraw() {
  	document.getElementById("avatar").innerHTML = '<iframe style="width:235px;height:280px;border:0px;" src="http://www.brick-hill.com/avatar/render/<?php if ($_SESSION['id'] == 4) { echo 'isaiah'; } ?>"></iframe>';
  	};
  	
  	function wear(item_id) {
	  	$.post("", {wear: item_id}, function(result){
			avatarRedraw();
			getWearing();
		});
	  	
  	};
  	
  	function remove(item_id2) {
	  	$.post("", {remove: item_id2}, function(result){
			avatarRedraw();
	  	getWearing();
		});
	  	
  	};
	
	function getWearing() {
		$("#wearing").load("http://www.brick-hill.com/customize/currently");
	};
	
	function getPage(type, page) {
		$("#inventory").load("http://www.brick-hill.com/customize/inventory?type="+type+"&page="+page);
	};
  </script>
  <?php
	include("../SiT_3/footer.php");
	?>
</body>
</html>	