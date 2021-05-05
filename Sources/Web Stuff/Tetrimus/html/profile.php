<?php
include 'func/connect.php';
$RefreshRate = rand(0,100000);

include 'func/filter.php';
$id = trim($conn->real_escape_string($_GET['id']));

if(!$id || !is_numeric($id)) {
    header("Location: profile.php?id=1");
    die();
}else{
    $checkExists = $conn->query("SELECT * FROM `users` WHERE `id`='$id'");
    $exists = mysqli_num_rows($checkExists);
    if($exists == 0) {
        header("Location: profile.php?id=1");
        die();	
    }
}

$select = $conn->query("SELECT * FROM users WHERE id='".$id."'");
$fetchuser = mysqli_fetch_object($select);

if (!$fetchuser) { 
    header("Location: ../");
}

/*
Hi, this is noynac aka Sushi!
I'll be adding friends here

Sorry if I get some stuff wrong, I've been doing a lot of PDO recently 
rather than MySQLi so I've gotten used to using prepared statements.

Anyways, if you have any questions about it just ask me!
*/

/*
I added this during testing but now I'm done so it's not needed.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

//start friends 

$displayAdd = false;
$displayRemove = false;
$displayPending = false;

if ($loggedIn) {
    
    if (isset($_POST['sendFR'])) {
        $fetchFriendsStatus = $conn->query("SELECT * FROM friends WHERE sender = '$user->id' AND receiver = '$fetchuser->id' OR receiver = '$user->id' AND sender = '$fetchuser->id'");
        $isFriends = mysqli_num_rows($fetchFriendsStatus);

        if ($isFriends == 0) {
            $sql  = "INSERT INTO friends (sender, receiver, accepted) VALUES ('$user->id','$fetchuser->id','0')";
            $stmt = $conn->query($sql);
            echo "<center>Friend Request sent.</center>";
        } else {
            echo "<center>You can't do that.!</center>";
        }
        echo '<meta http-equiv="refresh" content="2">';
    }
    
    if (isset($_POST['removeFR'])) {
        $fetchFriendsStatus = $conn->query("SELECT * FROM friends WHERE sender = '$user->id' AND receiver = '$fetchuser->id' AND accepted = '1' OR receiver = '$user->id' AND sender = '$fetchuser->id' AND accepted = '1'");
        $isFriends = mysqli_num_rows($fetchFriendsStatus);

        if ($isFriends > 0) {
            
            $whoSent = mysqli_fetch_object($fetchFriendsStatus);
            
            if ($whoSent->sender == $fetchuser->id) {
                $deleteFriend = "DELETE FROM friends WHERE sender = '$fetchuser->id' AND receiver='$user->id'";
            } else if ($whoSent->sender == $user->id) {
                $deleteFriend = "DELETE FROM friends WHERE sender = '$user->id' AND receiver='$fetchuser->id'";
            }
            if($conn->query($deleteFriend) === TRUE) {
                echo "<center>You have removed " . $fetchuser->username . " as a friend!</center>";
            }
        } else {
            echo "You cant remove someone who is not your friend!";
        }
        echo '<meta http-equiv="refresh" content="2">';
    }
    
    
    if ($fetchuser->id != $user->id) {
        $fetchFriendsStatus = $conn->query("SELECT * FROM friends WHERE sender = '$user->id' AND receiver = '$fetchuser->id' AND accepted = '1' OR receiver = '$user->id' AND sender = '$fetchuser->id' AND accepted = '1'");
        $fetchFriendsStatus1 = $conn->query("SELECT * FROM friends WHERE sender = '$user->id' AND receiver = '$fetchuser->id' AND accepted = '0' OR receiver = '$user->id' AND sender = '$fetchuser->id' AND accepted = '0'");
        $isFriends = mysqli_num_rows($fetchFriendsStatus);
        $isFriends1 = mysqli_num_rows($fetchFriendsStatus1);
        if ($isFriends > 0) {
            $displayRemove = true;
        } else if($isFriends1 > 0){
            $displayPending = true;
        }else{
            $displayAdd = true;
        }
    }
}

// end friends
/*if (isset($_GET["friends"])) {
    $friends = htmlspecialchars($_GET['friends']);
    }else{
    header("Location: south.php");
    exit();
    }
    $sel = $db->prepare("SELECT");
    $sel->execute(array(":defineUser" => $var)); //execute is okay but binding parameters ensures maximum security
    $assoc = $sel->fetch(PDO::FETCH_ASSOC);
    echo "".$sel->rowCount()." Friends"; //num
    echo $assoc['users'];
    //instead of assoc you can put in a while or foreach
    */
    

if($fetchuser->description !== $user->description) {
}

if($fetchuser->username !== $user->username) {
$updateviews = $conn->query("UPDATE `users` SET `profile_views` = `profile_views` + 1 WHERE username = '$fetchuser->username'");    
}

$getUviews = $conn->query("SELECT `profile_views` FROM `users` WHERE username = '$fetchuser->username'");

while($row = mysqli_fetch_array($getUviews)) {
    $profileviews = $row['profile_views']; //$db-query("SELECT `profile_views` FROM `users` WHERE username='$fetch_user->username'");
}

?>
<?php
/*
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo "$fetchuser->username"?> | Tetrimus</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/tetrimus.png"/>
  <meta name="description" content='<?php echo "$fetchuser->description.;" ?>'>
<meta name="keywords" content="Tetrimus,"<?php echo "".$fetchuser->username.""; ?>">
<meta name="author" content="Tetrimus">
<meta property="og:image" content="<?php echo '$fetchuser->id;'?>.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">

<script>
    window.onload = function() {
    var image = document.getElementById("Avatar");

    function updateImage() {
        image.src = image.src.split("?")[0] + "?" + new Date().getTime();
    }

    setInterval(updateImage, 5000);
}
</script>
</head>
*/
?>
<?php
include'func/navbar.php';
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo "$fetchuser->username | Tetrimus" ?></title>
  <link rel="shortcut icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png"/>
  <meta name="description" content='<?php echo "$fetchuser->description" ?>'>
<meta name="keywords" content="Tetrimus,"<?php echo "".$fetchuser->username.""; ?>">
<meta name="author" content="Tetrimus">
<meta property="og:image" content='<?php echo "https://www.tetrimus.xyz/images/$fetchuser->id.png"?>'>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<center><div class="alert alert-primary" role="alert">
  Profiles is undergoing maintenance. Check the status at: <a href="https://www.tetrimus.xyz/discord">Our Discord</a>
</div></center>
<div class="container">
  <div class="row">
     <div class="col-md-5" style="margin: 0px auto; float: none;">
         <?php if($fetchuser->status!=""){?><div class="card">
            <div class="card-body">
        <b>Right now I'm:</b> <?php echo "".$fetchuser->status.""; ?>
        </div>
        </div>
<div style="height: 15px;"></div>
        <?php } ?>
         <div class="card">
            <div class="card-body">

<?php
$cleanuser = filter($fetchuser->username);
echo "
<div style='margin: 0px auto; text-align: center;'>
<font style='font-size: 20px;'>" . $cleanuser . "</font>
";
// Online/Offline
if (time() < $fetchuser->expireTime) {
    echo "<i style='color:#29d840;border-radius: 10px;width: 12px;height: 12px;' class='fa fa-circle' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='" . $cleanuser . " is online'></i>";
}
if (time() > $fetchuser->expireTime) {
    echo "<i style='color:#eaedeb;border-radius: 10px;width: 12px;height: 12px;' class='fa fa-circle' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='" . $cleanuser . " is offline'></i>";
}

if($fetchuser->power >1){
    echo"<i class='fa fa-check' aria-hidden='true' style='color: #1fc111;margin-left: 5px;font-size: 20px;' data-toggle='tooltip' data-placement='top' title='" . $cleanuser . " is verified!'></i>";

}

echo "</div>";
?>
            <div style="height: 15px;"></div>
            </div>
            
            <?php 

         echo"<center>
";
?>
<img id='avatar' class='Avatar' src='../images/<?php echo"" . $fetchuser->id . ""; ?>.png?r=<?php echo "$RefreshRate"; ?>' height='350' width='350' onerror="this.src='images/default.png'" />
<?php
echo "</center>
";
echo '<div style="height: 15px;"></div>';
echo "<div style='border-bottom: 1px solid #eee;'>";
echo "</div>";
echo '<div style="height: 15px;"></div>';
echo"
<font style='text-align: center;padding:15px;'>" . $fetchuser->description . "</font>
";
echo '<div style="height: 5px;"></div>';

echo "<center>";

$ban = $_POST['ban'];
if ($ban) {
    $reason = strip_tags($_POST['reason']);
    $reason = trim($conn->real_escape_string($reason));
    $reason = htmlentities($reason);
	
    $bTime = strip_tags($_POST['BanTime']);
    $bTime = trim($conn->real_escape_string($bTime));
    $bTime = htmlentities($bTime);
	
	switch($bTime) {
		case "1minute":
		$banTime = strtotime("1 minute");
		break;
	    case "1day":
		$banTime = strtotime("1 day");
		break;
	    case "1week":
		$banTime = strtotime("1 week");
		break;
	    case "1month":
		$banTime = strtotime("4 week");
		break;
	    case "6months":
		$banTime = strtotime("26 week");
		break;
	}
    $conn->query("UPDATE users SET banned='1' WHERE id='$fetchuser->id'");
    $conn->query("INSERT INTO bans (banned_user, reason, ban_time, banned_by)
VALUES ('$id','$reason','$banTime','$user->id')");
	
echo"$fetchuser->username has been banned! Refresh to see.";
	}
if ($user->id != $fetchuser->id) {
if($user->power >=1){

	?>
	<form name="ban" action="#" method="POST">
<select name="BanTime">
  <option value="1minute">one minute</option>
  <option value="1day">one day</option>
  <option value="1week">one week</option>
  <option value="1month">one month</option>
  <option value="6months">six months</option>
</select>
<input type="text" placeholder="Reason" name="reason">
<input type="submit" class="btn btn-danger" value="Ban" name="ban">
	
	</form>
<?php
}
}
if($loggedIn){
    if ($user->id != $fetchuser->id) {
        if($displayAdd == true) {
            echo '
                <form action="#" method="POST">
                    <button class="btn btn-success" type="submit" name="sendFR">Send Friend Request</button>
                </form>
            ';
        }else if($displayRemove == true) {
            echo '
               <form action="#" method="POST">
                  <button class="btn btn-danger" name="removeFR">Remove Friend</button>
               </form>
            ';        
        }else if($displayPending == true) {
            echo '
               <form action="#" method="POST">
                  <button class="btn btn-secondary" name="b-baka dont touch this"disabled>Friend Request Pending</button>
               </form>
            ';  
        }else{
            echo "wtf have you done";
        }
    }
}
//Not displayed on own profile
if($loggedIn){
    if ($user->id != $fetchuser->id) {
        //Some broken code, <a href="https://www.tetrimus.xyz/chat/"".$fetchuser->username."";><button class='btn btn-primary'>Send Message</button></a>
        
        echo"<button name='#' type='submit' style='margin-left: 10px;' class='btn btn-primary'>Send Message</button>"; 
        
        //I tried adding the following code, <a href="https://www.tetrimus.xyz/chat/" "".$fetchuser->username."";"</a> but apparently it breaks echo since the ""
        
        //I tried - South
    }
}
echo "<div style='height: 25px;'></div>";
?>

  </div>
  <div style="height: 15px;"></div>
         <div class="card">
            <div class="card-body">
             <div style="border-bottom: 1px solid #eee;">
             <font style='font-size: 20px;'>Statistics</font>
            </div>
            <?php $pfpviews = number_format($profileviews);?>
            Profile views: <?php echo $pfpviews; ?><br>
            Last Seen: <?php echo "$fetchuser->last_login"?><br>
            Join date: <?php echo date('m/d/Y', $fetchuser->join_date); ?><br>
            User status: <?php if (time() < $fetchuser->expireTime) {
    echo "Online";
}
if (time() > $fetchuser->expireTime) {
    echo "Offline";
}
?>
</div>
            <div style="height: 15px;"></div>
    </div>
</div>

  <div class="col-md-6" style="margin: 0px auto; float: none;">
         <div class="card">
            <div class="card-body">
            <div style="border-bottom: 1px solid #eee;">
             <font style='font-size: 20px;'>Badges</font>
            </div>
            <div style="height: 15px;"></div>
            <div class="row">
            
            
<?php 
// Badges.
echo"<center><h3>Badges are getting remade. Please check back soon to see this user's badges!</h3></center>";
/*

if($fetchuser->id < 100){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664769659600906/100u.png' style='width:100px;height:100px;' class='tooltiptext' data-toggle='tooltip' data-placement='top' title='Earn this badge by registering amongst the first 100 players.'>
    ";
}else{
    //over 100
}
if($fetchuser->id <= 20){
        echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664767491276810/20u.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='Earn this badge by registering amongst the first 20 players.'>";
}else{
    //over 20
}
if($fetchuser->power >1){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664774135054336/adminu.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is for administrators on Tetrimus.'>";
}
if($fetchuser->membership == "platinum"){
    echo"<img src='http://tetrimus.xyz/storage/badges/platinum.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have a platinum membership.'>";
}
if($fetchuser->donator == 1){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664778752851999/donator.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have donated to Tetrimus.'>";
}
if($fetchuser->membership =="bronze"){
    echo"<img src='http://tetrimus.xyz/storage/badges/bonze.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have a basic membership.'>";
}
if($fetchuser->membership =="Diamond"){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664777507274753/diamond.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have a diamond membership.'>";
}
if($fetchuser->verified == 1){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664855701422131/verified.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who are verified personally by our staff.'>";
}
if($fetchuser->tokens >= 1500){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664829134700556/rich.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 1500 or more bucks.'>";
}
if($fetchuser->total >= 100){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486666874935836673/100.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 100 or more combined replies and threads.'>";
}
if($fetchuser->total >= 500){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664771521740819/500.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 500 or more combined replies and threads.'>";
}
if($fetchuser->total >= 1000){
    echo"<img src='https://cdn.discordapp.com/attachments/486312166060720129/486664772536893441/1000u.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 1000 or more combined replies and threads.'>";
}
*/
?>
</div>
</div>
</div>
<?php //<p>Last Seen: <?php echo"$user->last_login" ?>
 <div style="height: 15px;"></div>
         <div class="card">
            <div class="card-body">
            <div style="border-bottom: 1px solid #eee;">
             <font style='font-size: 20px;'>Friends</font>
            </div>
            <div style="height: 15px;"></div>
            <div class="row">
            <a href="https://www.tetrimus.xyz/users/<?php echo "".$fetchuser->username."";?>/friends">
              <button class="btn btn-success" id="va">View All</button></a><br>
              <div class="row">
             
              
            <div>
            <?php
            $currentDate = time();
            $conn->query('UPDATE `users` SET `last_login` = "' . $currentDate . '"');
            $fetchFriends = $conn->query("SELECT * FROM friends WHERE receiver = '$fetchuser->id' AND accepted = '1' OR sender = '$fetchuser->id' AND accepted = '1' LIMIT 9");
            $areFriends = mysqli_num_rows($fetchFriends);
            if($areFriends == 0) {
              echo 'This user does not have any friends!';
            }else{
              while($friend = mysqli_fetch_object($fetchFriends)) {
                  if($friend->receiver == $fetchuser->id) {
                      $gFriend = $conn->query("SELECT * FROM users WHERE id = '$friend->sender'");
                  }else if($friend->sender == $fetchuser->id) {
                      $gFriend = $conn->query("SELECT * FROM users WHERE id = '$friend->receiver'");
                  }
                  $friendInfo = mysqli_fetch_object($gFriend);
  
                  echo '
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../images/'.$friendInfo->id.'.png" width="120px"'?> onerror="this.src='images/default.png'"> <?php echo'</center>
                    <center><a href="../profile.php?id='.$friendInfo->id.'"">'.$friendInfo->username.'</a></center>
                    </div>
                ';
              }
            }
            ?>
    </div>
          </div>
              </div>
  
</h3></div>            
            </div></div></div>
            <?php
            /*Hi, noynac aka Sushi here again.
              This part is no longer needed

$getfriends = $conn->query("SELECT * FROM `friends` WHERE `user_to` = '".$fetchuser->id."' AND `status` = 'accepted' OR `user_from` = '".$fetchuser->id."' AND `status` = 'accepted'");
if($getfriends->num_rows > 0) {
    while ($friend = mysqli_fetch_assoc($getfriends)) {
        if($friend->user_from == $fetchuser->id) {
                echo "a";
        } else {
                echo "a";                
            }
        }
    } else {
        echo "<font style='margin: 0 auto;'>This user has no friends</font>";
    }
*/
?>
            
            </div>
            </div>
            </div>
            <div style="height: 15px;"></div>
    </div>

</div>
</div>

