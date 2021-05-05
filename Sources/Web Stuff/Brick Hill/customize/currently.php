<?php
session_name("BRICK-SESSION");
session_start();
include("../SiT_3/config.php");

$userId = $_SESSION['id'];

$findUserAvatarSQL = "SELECT * FROM `avatar` WHERE `user_id` = '$userId'";
$findUserAvatar = $conn->query($findUserAvatarSQL);
$userAvatar = (object) $findUserAvatar->fetch_assoc();


 //var_dump ( $userAvatar );
	$itemArray = array(
		"h1" => $userAvatar->{'hat1'},
		"h2" => $userAvatar->{'hat2'},
		"h3" => $userAvatar->{'hat3'},
		"h4" => $userAvatar->{'hat4'},
		"h5" => $userAvatar->{'hat5'},
		"s" => $userAvatar->{'shirt'},
		"tool" => $userAvatar->{'tool'},
		"p" => $userAvatar->{'pants'},
		"t" => $userAvatar->{'tshirt'},
		"f" => $userAvatar->{'face'}
	);
	
foreach ($itemArray as $potato => $item) {
$itemID = $item;
$findItemSQL = "SELECT * FROM `shop_items` WHERE `id` = $itemID";
$findItem = $conn->query($findItemSQL);
  if ($findItem->num_rows > 0) {
    $itemRow = (object) $findItem->fetch_assoc();
    
    if ($itemRow->{'approved'} == 'yes') {$thumbnail = $itemRow->{'id'};}
	elseif ($itemRow->{'approved'} == 'declined') {$thumbnail = 'declined';}
	else {$thumbnail = 'pending';}
    
		$kek = $potato;
  ?><div style="clear: both;margin: 10px;width: 142px;display:inline-block;position: relative;">
    <a href="/shop/item?id=<?php echo $itemRow->{"id"};?>">
			</a>
				<img id="shopItem" src="/shop_storage/thumbnails/<?php echo $thumbnail; ?>.png" ></a>
				<span style="text-align:center;display:inline-block;float:left;width: 100%;padding-left: 0;padding-right: 0;">
					<a class="shopTitle" href="/shop/item?id=<?php echo $itemRow->{"id"};?>">
						<?php echo htmlentities($itemRow->{'name'}); ?>
					</a>
				</span>
					<div style="text-align:center;">
						<button onclick="remove(<?php echo "'$potato'"; ?>)" style="color: #fff;background-color:red;margin:auto;margin: -135px;position: absolute;">Remove</button>
					</div>
				</div>
				<?php
 } 
	}
?>