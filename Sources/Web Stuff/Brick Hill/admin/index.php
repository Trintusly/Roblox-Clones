<?php
    include("../SiT_3/config.php");
    include("../SiT_3/header.php");
    include("../SiT_3/PHP/helper.php");
    
    if($power < 1) {header("Location: ../");die();}
    
    
    if(isset($_GET['seen'])) {
    	$seenID = mysqli_real_escape_string($conn,$_GET['seen']);
    	$seenSQL = "UPDATE `reports` SET `seen`='yes' WHERE `id`='$seenID'";
    	$seen = $conn->query($seenSQL);
    	header("Location: index");
    }
    
	if(isset($_POST['grant']) && isset($_POST['user']) && isset($_POST['item'])) {
		$userID = mysqli_real_escape_string($conn,intval($_POST['user']));
		$itemID = mysqli_real_escape_string($conn,$_POST['item']);
		
		if($userID != $_SESSION['id']) {
			$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
			$serialQ = $conn->query($serialSQL);
			$serialRow = $serialQ->fetch_assoc();
			$serial = $serialRow['serial']+1;
			
			$addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
			$add = $conn->query($addSQL);
			
			$admin = $_SESSION['id'];
			$action = 'Granted user'.$userID.' item '.$itemID;
			$date = date('d-m-Y H:i:s');
			$adminSQL = "INSERT INTO `admin` (`id`,`admin_id`,`action`,`time`) VALUES (NULL ,  '$admin',  '$action',  '$date')";
			$admin = $conn->query($adminSQL);
		}
	}
	
	if(isset($_POST['money']) && isset($_POST['user']) && isset($_POST['bits']) && isset($_POST['bucks'])) {
		$userID = mysqli_real_escape_string($conn,intval($_POST['user']));
		$bits = mysqli_real_escape_string($conn,$_POST['bits']);
		$bucks = mysqli_real_escape_string($conn,$_POST['bucks']);
		
		if($userID != $_SESSION['id']) {
			$userSQL = "SELECT * FROM `beta_users` WHERE `id`='$userID'";
			$user = $conn->query($userSQL);
			$userRow = $user->fetch_assoc();
			$newBits = $userRow['bits']+$bits;
			$newBucks = $userRow['bucks']+$bucks;
			
			$updateSQL = "UPDATE `beta_users` SET `bits`='$newBits', `bucks`='$newBucks' WHERE `id`='$userID'";
			$update = $conn->query($updateSQL);
			
			$admin = $_SESSION['id'];
			$action = 'Added '.$bucks.'bucks and '.$bits.' to user '.$userID;
			$date = date('d-m-Y H:i:s');
			$adminSQL = "INSERT INTO `admin` (`id`,`admin_id`,`action`,`time`) VALUES (NULL ,  '$admin',  '$action',  '$date')";
			$admin = $conn->query($adminSQL);
		}
	}
	
	if(isset($_POST['membership']) && isset($_POST['user']) && isset($_POST['value']) && isset($_POST['length'])) {
		$userID = mysqli_real_escape_string($conn,intval($_POST['user']));
		$value = mysqli_real_escape_string($conn,$_POST['value']);
		$length = mysqli_real_escape_string($conn,$_POST['length']);
		$date = date('d-m-Y H:i:s');
		
		if($userID != $_SESSION['id']) {
			$membershipSQL = "INSERT INTO `membership` (`id`,`user_id`,`membership`,`date`,`length`,`active`) VALUES (NULL,'$userID','$value','$date','$length','yes')";
			$membership = $conn->query($membershipSQL);
			
			$admin = $_SESSION['id'];
			$action = 'Granted user'.$userID.' membership '.$value.' for '.$length.' minutes';
			$date = date('d-m-Y H:i:s');
			$adminSQL = "INSERT INTO `admin` (`id`,`admin_id`,`action`,`time`) VALUES (NULL ,  '$admin',  '$action',  '$date')";
			$admin = $conn->query($adminSQL);
		}
	}
	
	if(isset($_POST['password']) && isset($_POST['user'])) {
		$userID = mysqli_real_escape_string($conn,intval($_POST['user']));
		
		function generateRandomString($length = 10) {
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}
		
		$newPass = generateRandomString();
		$newPassEncrypt = password_hash($newPass, PASSWORD_BCRYPT);
		$passSQL = "UPDATE `beta_users` SET `password`='$newPassEncrypt' WHERE `id`='$userID'";
		$pass = $conn->query($passSQL);
		
		echo '<script>prompt("User '.$userID.'","'.$newPass.'");</script>';
		
		$admin = $_SESSION['id'];
		$action = 'Reset password user'.$userID;
		$date = date('d-m-Y H:i:s');
		$adminSQL = "INSERT INTO `admin` (`id`,`admin_id`,`action`,`time`) VALUES (NULL ,  '$admin',  '$action',  '$date')";
		$admin = $conn->query($adminSQL);
	}

	if (isset($_GET['clan-approve'])) {
  $clandID = mysqli_real_escape_string($conn,intval($_GET['clan-approve']));
  $approveSQL = "UPDATE `clans` SET `approved`='yes' WHERE `id`='$clandID'";
  $approve = $conn->query($approveSQL);
  header('Location: index?approval=clan');
}
	
if (isset($_GET['approve'])) {
  $itemID = mysqli_real_escape_string($conn,intval($_GET['approve']));
  $approveSQL = "UPDATE `shop_items` SET `approved`='yes' WHERE `id`='$itemID'";
  $approve = $conn->query($approveSQL);
  header('Location: index?approval=shop');
}
if (isset($_GET['decline'])) {
  $itemID = mysqli_real_escape_string($conn,intval($_GET['decline']));
  $declineSQL = "UPDATE `shop_items` SET `approved`='declined' WHERE `id`='$itemID'";
  $decline = $conn->query($declineSQL);
  header('Location: index');
}

$econSQL = "SELECT SUM(`bits`) AS 'totalBits' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBits = $econRow['totalBits'];

$econSQL = "SELECT SUM(`bucks`) AS 'totalBucks' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBucks = $econRow['totalBucks'];

$econ = $totalBits+($totalBucks*10);
?>
<!DOCTYPE html>
<html>
<head>

	<style>
	#center {
	text-align:center;
	}
	</style>
	<title>Admin Panel - Brick Hill</title>
</head>
<body>
	<script>
		function viewPage(url) {
			var mainElement = $(".page");
			$.get(url, function( data ) {
				mainElement.html(data);
			});
		}
		$( document ).ajaxError(function( event, request, settings ) {
			var mainElement = $(".page");
			mainElement.html('<div id="box" class="center-text" style="padding: 10px;">Error loading!</div>');
		});
	</script>
	<div id="body">
		<div id="column" style="float:left; width:195px;">
				<div id="box" style="padding-bottom:0px;">
					<div id="subsect">
						<h2 style="padding:5px;">Admin</h2>
					</div>
					<h6 style="padding-left:5px;margin-bottom:10px;">Pages:</h6>
					<div>
		<?php 
					$sortByArray = array(
					"Main" => "/admin/pages/main",
					"Approval" => "/admin/pages/approval",
					"Reports" => "/admin/pages/reports",
					"Funds" => "/admin/pages/funds"
					);
					foreach ($sortByArray as $sortByValue => $jsValue) {
					?>
						<a class="nav" onclick="viewPage('<?php echo $jsValue; ?>','<?php echo $searchQ; ?>',0);">
							<div class="shopSideBarButton">
								<?php echo $sortByValue; ?>
							</div>
						</a>
					<?php 
					}
					?>
					</div>
				</div>
		</div>
		<div id="column" style="float:right;width:695px;" class="page">
			<?php 
			if (isset($_GET['approval'])) {
				include('pages/approval.php');
			} else {
			include('pages/main.php');
			}
			?>
		</div>
	</div>
	<?php include("../SiT_3/footer.php"); ?>
</body>
</html>	