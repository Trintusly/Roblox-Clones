<?php
require_once("../Header.php");
if (!$User){
	header('location: ../index.php');
}
if ($_GET['acceptRequest']){
	$id = mysql_real_escape_string($_GET['acceptRequest']);
	$myqr = mysql_fetch_array(mysql_query("SELECT * FROM `Trade` WHERE `id`='$id'"));
	if ($myqr == '0'){
		die("Something went wrong. Try again later.");
	}
	if ($myqr['requesteeid'] != $myU->ID){
		die("You can't accept a trade you don't own.");
	}
	$Iwillget = $myqr['myitemid'];
	$Youwillget = $myqr['youritemid'];
	$IwillgetYourStore = $myqr['MyStore'];
	$YouwillgetMyStore = $myqr['YourStore'];
	$RequesterId = $myqr['requesterid'];
	$RequesteeId = $myqr['requesteeid'];
	$RequesteeArray = mysql_fetch_array(mysql_query("SELECT * FROM `Users` WHERE `ID`='$RequesteeId'"));
	$requesteename = $RequesteeArray['Username'];
	$get = mysql_fetch_array(mysql_query("SELECT * FROM `Inventory` WHERE `UserID`='$RequesterId' AND `ItemID`='$Iwillget'")) or die("Something went wrong - sorry! ERROR: 3");
	if ($get == '0'){
		die("Something went wrong - sorry! ERROR: 1");
	}
	$get2 = mysql_fetch_array(mysql_query("SELECT * FROM `Inventory` WHERE `UserID`='$RequesteeId' AND `ItemID`='$Youwillget'")) or die("Something went wrong - sorry! ERROR: 4");
	if ($get2 == '0'){
		die("Something went wrong - sorry! ERROR: 2");
	}
	mysql_query("INSERT INTO `PMs`(`SenderID`, `ReceiveID`, `Title`, `Body`) VALUES ('1', '$RequesterId', 'Your trade was accepted!', '$requesteename has accepted your trade request!')");
	mysql_query("UPDATE `Inventory` SET `UserID`='$RequesteeId' WHERE `ItemID`='$Iwillget' AND `UserID`='$get[UserID]'") or die("qq");
	mysql_query("UPDATE `Inventory` SET `UserID`='$RequesterId' WHERE `ItemID`='$Youwillget' AND `UserID`='$get2[UserID]'") or die("qqqqqq");
	mysql_query("DELETE FROM `Trade` WHERE `id`='$id'");
	ob_end_clean();
	header('location: index.php?traded=true');
}
if ($_GET['declineRequest']){
	$id = mysql_real_escape_string($_GET['declineRequest']);
	$myqr = mysql_fetch_array(mysql_query("SELECT * FROM `Trade` WHERE `id`='$id'"));
	if ($myqr == '0'){
		die("Something went wrong. Try again later.");
	}
	if ($myqr['requesteeid'] != $myU->ID){
		die("You can't decline a trade you don't own.");
	}
	mysql_query("INSERT INTO `PMs`(`SenderID`, `ReceiveID`, `Title`, `Body`) VALUES ('1', '$myqr[requesterid]', 'Your trade was declined!', '$myqr[requesterid] has declined your trade request.')");
	mysql_query("DELETE FROM `Trade` WHERE `id`='$id'");
	ob_end_clean();
	header('location: index.php');
}
if ($_GET['done']){
?>
Your trade request was sent.
<?php	
}
if ($_GET['traded']){
	?>
    Your trade has been completed.
    <?php
}
if ($_GET['tradeWith']){
	$tradeWith = strip_tags(mysql_real_escape_string($_GET['tradeWith']));
	$myid = $myU->ID;
	if ($tradeWith == $myU->ID){
		die("You cannot trade with yourself!");
	}
	$tradeWithArray = mysql_fetch_array(mysql_query("SELECT * FROM `Users` WHERE `ID`='$tradeWith'"));
	$j = mysql_query("SELECT * FROM `Inventory` WHERE `UserID`='$myid' ORDER BY `ID`");
	$jj = mysql_num_rows($j);
	for ($count = 1; $count <= $jj; $count ++){
		$jr = mysql_fetch_array($j);
		$itm = $jr['ItemID'];
		$id = $jr['ID'];
		$file = $jr['File'];
		$using = 1;
		$mainstore = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$itm' AND `File`='$file'"));
		if ($mainstore == 0){
			$userstore = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$itm' AND `File`='$file'")) or die("Error for `UserStore`: `ID`='" . $itm . "' AND `File`='" . $file . "'");
			$using = 2;
			if ($userstore == 0){
				mysql_query("DELETE FROM `Inventory` WHERE `ID`='$id'");
			}
		}
		if ($using == 2 && $mainstore == 0 && $userstore == 0){
			mysql_query("DELETE FROM `Inventory` WHERE `ID`='$id'");
		}
		if ($using == 1){
			if ($mainstore['saletype'] == 'limited'){
				mysql_query("UPDATE `Inventory` SET `limited`='1' WHERE `ID`='$id'");
			}
		}
	}
	$j = mysql_query("SELECT * FROM `Inventory` WHERE `UserID`='$tradeWith' ORDER BY `ID`");
	$jj = mysql_num_rows($j);
	for ($count = 1; $count <= $jj; $count ++){
		$jr = mysql_fetch_array($j);
		$itm = $jr['ItemID'];
		$id = $jr['ID'];
		$file = $jr['File'];
		$using = 1;
		$mainstore = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$itm' AND `File`='$file'"));
		if ($mainstore == 0){
			$userstore = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$itm' AND `File`='$file'")) or die("Error for `UserStore`: `ID`='" . $itm . "' AND `File`='" . $file . "'");
			$using = 2;
			if ($userstore == 0){
				mysql_query("DELETE FROM `Inventory` WHERE `ID`='$id'");
			}
		}
		if ($using == 2 && $mainstore == 0 && $userstore == 0){
			mysql_query("DELETE FROM `Inventory` WHERE `ID`='$id'");
		}
		if ($using == 1){
			if ($mainstore['saletype'] == 'limited'){
				mysql_query("UPDATE `Inventory` SET `limited`='1' WHERE `ID`='$id'");
			}
		}
	}
	?>
    <table width="98%"><tr>
<td><fieldset><legend><b>Trading with <?php print_r($tradeWithArray['Username']); ?></b></legend>
<table width="98%"><tr>
<td width="50%">
<fieldset><legend><b><?php print_r($tradeWithArray['Username']); ?>'s Items</b></legend>
<?php
$qr = mysql_query("SELECT * FROM `Inventory` WHERE `UserID`='$tradeWith' AND `limited`='1' ORDER BY `ID`");
$qr2 = mysql_num_rows($qr);
?>
<table width="98%" style="height: auto; max-width: 98%;">
<tr>
<?php
for ($count = 1; $count <= $qr2; $count ++){
	$qrr = mysql_fetch_array($qr);
	$itemid = $qrr['ItemID'];
	$using = 1; //1 = main store; 2 = user store
	$mainstore = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$itemid'"));
	if ($mainstore == '0'){
		$userstore = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$itemid'"));
		$using = 2;
	}
	if ($using == 1){
		$itemidd = $mainstore['ID'];
		$path    = $mainstore['File'];
		$name    = $mainstore['Name'];
	}
	if ($using == 2){
		$itemidd = $userstore['ID'];
		$path    = $userstore['File'];
		$name    = $userstore['Name'];
	}
	?>
   <td width="100" style="text-align:center;"> <a href="?tradeWith=<?php print_r($tradeWith); ?>&add=<?php print_r($itemidd); ?>&myadd=<?php if ($_GET['myadd']){ print_r($_GET['myadd']); } ?>"><img src="/Store/Dir/<?php print_r($path); ?>" border="0" /><br /><?php print_r($name); ?><br />[Add]</a> </td></tr><tr>
<?php
}
?>
</tr>
</table>
</fieldset>
</td>
<td width="50%">
<fieldset><legend><b>Your Items</b></legend>
<table width="98%" style="height: auto; max-width: 98%;">
<tr>
<?php
$qra = mysql_query("SELECT * FROM `Inventory` WHERE `UserID`='$myU->ID' AND `limited`='1' ORDER BY `ID`");
$qr2a = mysql_num_rows($qr);
for ($count = 1; $count <= $qr2a; $count ++){
	$qrra = mysql_fetch_array($qra);
	$itemid = $qrra['ItemID'];
	$using = 1; //1 = main store; 2 = user store
	$mainstore = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$itemid'"));
	if ($mainstore == '0'){
		$userstore = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$itemid'"));
		$using = 2;
	}
	if ($using == 1){
		$itemidd = $mainstore['ID'];
		$path    = $mainstore['File'];
		$name    = $mainstore['Name'];
	}
	if ($using == 2){
		$itemidd = $userstore['ID'];
		$path    = $userstore['File'];
		$name    = $userstore['Name'];
	}
	?>
    <td width="100" style="text-align:center;"> <a href="?tradeWith=<?php print_r($tradeWith); ?>&myadd=<?php print_r($itemidd); ?>&add=<?php if ($_GET['add']){ print_r($_GET['add']); } ?>"><img src="/Store/Dir/<?php print_r($path); ?>" border="0" /><br /><?php print_r($name); ?><br />[Add]</a> </td></tr><tr>
<?php
}
?>
</tr>
</table>
</fieldset>
</td>
</tr>
</table>
<center>
<?php
if ($_GET['add'] && $_GET['myadd']){
	$add = mysql_real_escape_string($_GET['add']);
	$myadd = mysql_real_escape_string($_GET['myadd']);
	$using = 1; //1 = main store; 2 = user store
	$mainstore = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$add'"));
	if ($mainstore == '0'){
		$userstore = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$add'"));
		$using = 2;
		if ($userstore == '0'){
			die("Sorry, something went wrong. Please try again later.");
		}
	}
	$myusing = 1; //1 = main store; 2 = user store
	$mymainstore = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$myadd'"));
	if ($mymainstore == '0'){
		$myuserstore = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$myadd'"));
		$myusing = 2;
		if ($myuserstore == '0'){
			die("Sorry, something went wrong. Please try again later.");
		}
	}
	if ($_POST['trade']){
		$requesterid = $myU->ID;
		$requesteeid = $tradeWith;
		$youritemid  = $add;
		$myitemid    = $myadd;
		if ($myusing == '1'){
			if ($mymainstore['saletype'] == 'regular'){
				$limited = 0;
			}
			if ($mymainstore['saletype'] == 'limited'){
				$limited = 1;
			}
		}
		if ($using == '1'){
			if ($mainstore['saletype'] == 'regular'){
				$elimited = 0;
			}
			if ($mainstore['saletype'] == 'limited'){
				$elimited = 1;
			}
		}
		if ($using == '2'){
			$elimited = 0;
		}
		if ($myusing == '1'){
			$creatorid = $mymainstore['CreatorID'];
		}
		if ($myusing == '2'){
			$creatorid = $myuserstore['CreatorID'];
		}
		if ($using == '1'){
			$YourStore = '1';
		}
		if ($using == '2'){
			$YourStore = '2';
		}
		if ($myusing == '1'){
			$MyStore = '1';
		}
		if ($myusing == '2'){
			$MyStore = '2';
		}
		if ($limited == '0'){
			die("You can only trade limiteds.");
		}
		if ($elimited == '0'){
			die("You can only trade limiteds.");
		}
		mysql_query("INSERT INTO `PMs`(`SenderID`, `ReceiveID`, `Title`, `Body`) VALUES ('1', '$requesteeid', 'You have pending trade requests!', 'You have a pending trade request. Click \"My Trade Requests\" at the top to view them.')");
		mysql_query("INSERT INTO `Trade` (`requesterid`, `requesteeid`, `youritemid`, `myitemid`, `limited`, `creatorid`, `YourStore`, `MyStore`) VALUES ('$requesterid', '$requesteeid', '$youritemid', '$myitemid', '$limited', '$creatorid', '$YourStore', '$MyStore')");
		ob_end_clean();
		header('location: index.php?done=true');
	}
	?>
<form action="?tradeWith=<?php print_r($tradeWith); ?>&add=<?php print_r($add); ?>&myadd=<?php print_r($myadd); ?>" method="post">
<input type="submit" id="buttonsmall" value="Request Trade" name="trade">
</form>
<?php
}else{
	?>
    Please select an item from both inventories before continuing...
    <?php
}
?>
</center>
</fieldset>
</td>
</tr>
</table>
    <?php
}else{
?>
<table width="98%"><tr>
<td><fieldset><legend><b>Trade Items</b></legend>
<table width="98%"><tr><td width="100" style="text-align:center;">User</td><td width="200" style="text-align:center;">Giving</td><td width="200" style="text-align:center;">Receiving</td><td style="text-align:center;">Details</td><td style="text-align:center;">Actions</td></tr>
<?php
$requesteeid = $myU->ID;
$myq = mysql_query("SELECT * FROM `Trade` WHERE `requesteeid`='$requesteeid' ORDER BY `id` DESC") or die(mysql_error());
$myqq = mysql_num_rows($myq);
for ($count = 1; $count <= $myqq; $count ++){
	$myqr = mysql_fetch_array($myq);
	$requesterid = $myqr['requesterid'];
	$requesterarray = mysql_fetch_array(mysql_query("SELECT * FROM `Users` WHERE `ID`='$requesterid'")) or die(mysql_error());
	$youritemid = $myqr['youritemid'];
	$myitemid   = $myqr['myitemid'];
	$store = $myqr['YourStore'];
	if ($store == '1'){
		$youritemarray = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$youritemid'")) or die(mysql_error());
	}
	if ($store == '2'){
		$youritemarray = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$youritemid'")) or die(mysql_error());
	}
	$iownthisitem = false;
	$myinventory = mysql_fetch_array(mysql_query("SELECT * FROM `Inventory` WHERE `ItemID`='$youritemid' AND `UserID`='$requesteeid'")) or die(mysql_error());
	if ($myinventory != '0'){
		$iownthisitem = true;
	}
	if ($iownthisitem == true){
		$mystore = $myqr['MyStore'];
		if ($mystore == '1'){
			$myitemarray = mysql_fetch_array(mysql_query("SELECT * FROM `Items` WHERE `ID`='$myitemid'")) or die(mysql_error());
		}
		if ($mystore == '2'){
			$myitemarray = mysql_fetch_array(mysql_query("SELECT * FROM `UserStore` WHERE `ID`='$myitemid'")) or die(mysql_error());
		}
		$youownthisitem = false;
		$yourinventory = mysql_fetch_array(mysql_query("SELECT * FROM `Inventory` WHERE `ItemID`='$myitemid' AND `UserID`='$requesterid'")) or die(mysql_error());
		if ($yourinventory != '0'){
			$youownthisitem = true;
		}
		if ($youownthisitem == true){
			$limited = $myqr['limited'];
			$creatorid = $myqr['creatorid'];
			$creatorArray = mysql_fetch_array(mysql_query("SELECT * FROM `Users` WHERE `ID`='$creatorid'")) or die(mysql_error());
			
			?>
	
<tr>
<td style="max-width: 100px; width: 100px; overflow: hidden; text-align: center;">
<a href="/user.php?ID=<?php print_r($requesterid); ?>"><?php print_r($requesterarray['Username']); ?></a>
</td>
<td style="max-width: 200px; width: 200px; overflow: hidden; height: auto; text-align: center;">
<a href="/Store/<?php
if ($store == '1'){
	print_r("Item.php");
}
if ($store == '2'){
	print_r("UserItem.php");
} ?>?ID=<?php print_r($youritemarray['ID']); ?>"><img src="/Store/Dir/<?php print_r($youritemarray['File']); ?>" border="0" /><br>
<?php print_r($youritemarray['Name']); ?></a>
</td>
<td style="max-width: 200px; width: 200px; overflow: hidden; height: auto; text-align: center;">
<a href="/Store/<?php
if ($mystore == '1'){
	print_r("Item.php");
}
if ($mystore == '2'){
	print_r("UserItem.php");
} ?>?ID=<?php print_r($myitemarray['ID']); ?>"><img src="/Store/Dir/<?php print_r($myitemarray['File']); ?>" border="0" /><br>
<?php print_r($myitemarray['Name']); ?></a>
</td>
<td>
<?php
if ($myqr['limited'] == '0'){
	print_r("Not Limited");
}
if ($myqr['limited'] == '1'){
	print_r("Limited");
}
?><br>
Creator: <a href="/user.php?ID=<?php print_r($creatorArray['ID']); ?>"><?php print_r($creatorArray['Username']); ?></a>
</td>
<td>
<a href="?acceptRequest=<?php print_r($myqr['id']); ?>" id="buttonsmall">Accept</a> or <a href="?declineRequest=<?php print_r($myqr['id']); ?>" id="buttonsmall">Decline</a>
</td>
</tr>
<?php
		}
	}
}
?>
</table>

</fieldset>
</td>
</tr>

</table>
<?php
}