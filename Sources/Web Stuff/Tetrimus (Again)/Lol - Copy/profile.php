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


if ($fetchuser == 0) { 
    header("Location: ../");
}

if($fetchuser->username !== $user->username) {
$updateviews = $conn->query("UPDATE `users` SET `profile_views` = `profile_views` + 1 WHERE username = '$fetchuser->username'");    
}

$getUviews = $conn->query("SELECT `profile_views` FROM `users` WHERE username = '$fetchuser->username'");

while($row = mysqli_fetch_array($getUviews)) {
    $profileviews = $row['profile_views']; //$db-query("SELECT `profile_views` FROM `users` WHERE username='$fetch_user->username'");
}

?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo "".$fetchuser->username.""; ?> | Tetrimus</title>
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
<?php
include'func/navbar.php';
?>
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
    echo"<button name='#' type='submit' style='margin-left: 10px;' class='btn btn-success'>Add</button>";
}
}
//Not displayed on own profile
if($loggedIn){
if ($user->id != $fetchuser->id) {
	echo"<button name='#' type='submit' style='margin-left: 10px;' class='btn btn-primary'>Send Message</button>"; //thing for sending messages needs form

    //Send and remove friends
    if (isset($_POST['send'])) {

    }
    if (isset($_POST['remove'])) {
        
    }
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
if($fetchuser->id < 100){
    echo"<img src='https://tetrimus.com/storage/badges/100u.png' style='width:100px;height:100px;' class='tooltiptext' data-toggle='tooltip' data-placement='top' title='Earn this badge by registering amongst the first 100 players.'>
    ";
}else{
    //over 100
}
if($fetchuser->id <= 20){
        echo"<img src='https://tetrimus.com/storage/badges/20u.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='Earn this badge by registering amongst the first 20 players.'>";
}else{
    //over 20
}
if($fetchuser->power >1){
    echo"<img src='https://tetrimus.com/storage/badges/adminu.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is for administrators on Tetrimus.'>";
}
if($fetchuser->membership == "platinum"){
    echo"<img src='https://tetrimus.com/storage/badges/platinum.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have a platinum membership.'>";
}
if($fetchuser->donator == 1){
    echo"<img src='https://tetrimus.com/storage/badges/donator.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have donated to Tetrimus.'>";
}
if($fetchuser->membership =="bronze"){
    echo"<img src='https://tetrimus.com/storage/badges/bonze.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have a basic membership.'>";
}
if($fetchuser->membership =="Diamond"){
    echo"<img src='https://tetrimus.com/storage/badges/diamond.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who have a diamond membership.'>";
}
if($fetchuser->verified == 1){
    echo"<img src='https://tetrimus.com/storage/badges/verified.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to all users who are verified personally by our staff.'>";
}
if($fetchuser->tokens >= 1500){
    echo"<img src='https://tetrimus.com/storage/badges/rich.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 1500 or more bucks.'>";
}
if($fetchuser->total >= 100){
    echo"<img src='https://tetrimus.com/storage/badges/100.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 100 or more combined replies and threads.'>";
}
if($fetchuser->total >= 500){
    echo"<img src='https://tetrimus.com/storage/badges/500.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 500 or more combined replies and threads.'>";
}
if($fetchuser->total >= 1000){
    echo"<img src='https://tetrimus.com/storage/badges/1000.png' style='width:100px;height:100px;' data-toggle='tooltip' data-placement='top' title='This badge is given to users who have 1000 or more combined replies and threads.'>";
}
?>
</div>
</div>
</div>
 <div style="height: 15px;"></div>
         <div class="card">
            <div class="card-body">
            <div style="border-bottom: 1px solid #eee;">
             <font style='font-size: 20px;'>Friends</font>
            </div>
            <div style="height: 15px;"></div>
            <div class="row">
            <?php
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

?>
            
            </div>
            </div>
            </div>
            <div style="height: 15px;"></div>
    </div>

</div>
</div>
</div>
