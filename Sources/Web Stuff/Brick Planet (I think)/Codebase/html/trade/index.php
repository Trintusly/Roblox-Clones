<?php
require_once("/var/www/html/root/private/header.php");
	
	requireLogin();
	
	if ($SiteSettings->AllowTrades == 0) {
		
		echo '
		<h4>Temporarily unavailable</h4>
		<div class="container border-r md-padding">
			We\'re sorry, account trades are temporarily unavailable at this moment. Try again later.
		</div>
		';
		
		require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
		die;
		
	}
	
	if ($myU->Username == $_GET['Username']) {
		
		header("Location: ".$serverName."/users/".$myU->Username."/");
		die;
		
	}

	$getUser = $db->prepare("SELECT Username, AvatarURL, TradeSettings, (SELECT COUNT(*) FROM Friend WHERE SenderID = ".$myU->ID." AND ReceiverID = User.ID AND Accepted = 1) AS CheckFriend, (SELECT COUNT(*) FROM BlockedUser WHERE (RequesterID = ".$myU->ID." AND BlockedID = User.ID) OR (RequesterID = User.ID AND BlockedID = ".$myU->ID.")) AS CheckBlocked, (SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.UserID = ".$myU->ID." AND UserInventory.CanTrade = 1) AS SenderCollectibles, (SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.UserID = User.ID AND UserInventory.CanTrade = 1) AS ReceiverCollectibles FROM User WHERE Username = ?");
	$getUser->bindValue(1, $_GET['Username'], PDO::PARAM_STR);
	$getUser->execute();
	
	if ($getUser->rowCount() == 0) {
		
		echo 'We\'re sorry, this user was not found.';
		
	} else {
		
		$gU = $getUser->fetch(PDO::FETCH_OBJ);
		
		if ($gU->TradeSettings == 1 && $gU->CheckFriend == 0 || $gU->CheckBlocked > 0 || $gU->TradeSettings == 2) {
			
			echo 'We\'re sorry, this user\'s privacy settings restricts you from trading with them.';
			
		} else if ($gU->SenderCollectibles == 0 || $gU->ReceiverCollectibles == 0) {
			
			echo 'We\'re sorry, both parties must have at least one (1) collectible in order to trade.';
			
		} else {
			
			echo '
			<script>
				document.title = "Trade with '.$gU->Username.' - Brick Create";
				var GivingCount = 0;
				var RequestingCount = 0;
				var GivingList = {};
				var GivingInventoryList = [];
				var RequestingList = {};
				var RequestingInventoryList = [];
				var MyPage = 1;
				var TheirPage = 1;
				var GivingCredits;
				var RequestingCredits;
			
				Element.prototype.getElementById = function(id) {
					return document.getElementById(id);
				}
				
				function GetElementInsideContainer(containerID, childID) {
					var elm = document.getElementById(childID);
					var parent = elm ? elm.parentNode : {};
					return (parent.id && parent.id === containerID) ? elm : {};
				}
			
				function numberWithCommas(x) {
					return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				}

				function loadMyInventory(Page) {
					if (Page == undefined) {
						Page = 1;
					} else {
						MyPage = Page;
					}
					
					if (GivingCount > 0) {
						var Link = "'.$serverName.'/user/trade/inventory/?Username='.$myU->Username.'&Type=My&Page=" + Page + "&Disinclude=" + GivingInventoryList.toString();
					} else {
						var Link = "'.$serverName.'/user/trade/inventory/?Username='.$myU->Username.'&Type=My&Page=" + Page;
					}
					$.get(Link, function(data, status) {
						document.getElementById("MyInventory").innerHTML = data;
						if (document.getElementById("MyPages").value < MyPage) { 
							MyPage = document.getElementById("MyPages").value;
							loadMyInventory(MyPage);
						}
					});
				}
				
				function loadTheirInventory(Page) {
					if (Page == undefined) {
						Page = 1;
					} else {
						TheirPage = Page;
					}
					
					if (RequestingCount > 0) {
						var Link = "'.$serverName.'/user/trade/inventory/?Username='.$gU->Username.'&Type=Their&Page=" + Page + "&Disinclude=" + RequestingInventoryList.toString();
					} else {
						var Link = "'.$serverName.'/user/trade/inventory/?Username='.$gU->Username.'&Type=Their&Page=" + Page;
					}
					$.get(Link, function(data, status) {
						document.getElementById("TheirInventory").innerHTML = data;
						if (document.getElementById("TheirPages").value < TheirPage) { 
							TheirPage = document.getElementById("TheirPages").value;
							loadTheirInventory(TheirPage);
						}
					});
				}
				
				function addMyCredits() {
					var Credits = document.getElementById("MyCreditsAmt").value;
					if (Credits == 0) {
						document.getElementById("GivingCredits").innerHTML = "";
					} else if (Credits <= '.$myU->CurrencyCredits.') {
						document.getElementById("GivingCredits").innerHTML = numberWithCommas(parseFloat(((Credits))).toFixed(0)) + " Credits";
					}
				}

				function addTheirCredits() {
					var Credits = document.getElementById("TheirCreditsAmt").value;
					if (Credits == 0) {
						document.getElementById("RequestingCredits").innerHTML = "";
					} else {
						document.getElementById("RequestingCredits").innerHTML = numberWithCommas(parseFloat(((Credits))).toFixed(0)) + " Credits";
					}
				}
				
				function addMyItem(InventoryId, ItemId) {
					if (GivingCount < 4 && GivingInventoryList.includes(InventoryId) == false) {
						GivingInventoryList.push(InventoryId);
						if (GivingList[ItemId] == undefined) {
							GivingList[ItemId] = {InventoryIds: [InventoryId]};
						} else {
							GivingList[ItemId]["InventoryIds"].push(InventoryId);
						}
						GivingCount++;
						loadMyInventory(MyPage);
						if (GivingList[ItemId]["InventoryIds"].length == 1) {
							var code = "<div class=\"large-6 medium-6 cell trade-card\" id=\"Giving" + ItemId +"\" onclick=\"removeMyItem(" + ItemId + ")\" title=\"Click to remove\">" + document.getElementById("MyElement"+ItemId).innerHTML + "</div>";
							document.getElementById("GivingDiv").innerHTML = code + document.getElementById("GivingDiv").innerHTML;
							document.querySelector("#GivingDiv #Giving" + ItemId + " #number_copies").innerHTML = 1;
						} else {
							document.querySelector("#GivingDiv #Giving" + ItemId + " #number_copies").innerHTML = GivingList[ItemId]["InventoryIds"].length;
						}
					}
				}
				
				function addTheirItem(InventoryId, ItemId) {
					if (RequestingCount < 4 && RequestingInventoryList.includes(InventoryId) == false) {
						RequestingInventoryList.push(InventoryId);
						if (RequestingList[ItemId] == undefined) {
							RequestingList[ItemId] = {InventoryIds: [InventoryId]};
						} else {
							RequestingList[ItemId]["InventoryIds"].push(InventoryId);
						}
						RequestingCount++;
						loadTheirInventory(TheirPage);
						if (RequestingList[ItemId]["InventoryIds"].length == 1) {
							var code = "<div class=\"large-6 medium-6 cell trade-card\" id=\"Requesting" + ItemId +"\" onclick=\"removeTheirItem(" + ItemId + ")\" title=\"Click to remove\">" + document.getElementById("TheirElement"+ItemId).innerHTML + "</div>";
							document.getElementById("RequestingDiv").innerHTML = code + document.getElementById("RequestingDiv").innerHTML;
							document.querySelector("#RequestingDiv #Requesting" + ItemId + " #number_copies").innerHTML = 1;
						} else {
							document.querySelector("#RequestingDiv #Requesting" + ItemId + " #number_copies").innerHTML = RequestingList[ItemId]["InventoryIds"].length;
						}
					}
				}
				
				function removeMyItem(ItemId) {
					if (GivingList[ItemId]["InventoryIds"].length == 1) {
						document.getElementById("Giving" + ItemId).remove();
						GivingInventoryList.splice(GivingInventoryList.indexOf(GivingList[ItemId]["InventoryIds"][0]), 1);
						delete GivingList[ItemId];
					} else {
						GivingInventoryList.splice(GivingInventoryList.indexOf(GivingList[ItemId]["InventoryIds"][0]), 1);
						GivingList[ItemId]["InventoryIds"].splice(0, 1);
						document.querySelector("#GivingDiv #Giving" + ItemId + " #number_copies").innerHTML = GivingList[ItemId]["InventoryIds"].length;
					}
					GivingCount--;
					loadMyInventory(MyPage);
				}
				
				function removeTheirItem(ItemId) {
					if (RequestingList[ItemId]["InventoryIds"].length == 1) {
						document.getElementById("Requesting" + ItemId).remove();
						RequestingInventoryList.splice(RequestingInventoryList.indexOf(RequestingList[ItemId]["InventoryIds"][0]), 1);
						delete RequestingList[ItemId];
					} else {
						RequestingInventoryList.splice(RequestingInventoryList.indexOf(RequestingList[ItemId]["InventoryIds"][0]), 1);
						RequestingList[ItemId]["InventoryIds"].splice(0, 1);
						document.querySelector("#RequestingDiv #Requesting" + ItemId + " #number_copies").innerHTML = RequestingList[ItemId]["InventoryIds"].length;
					}
					RequestingCount--;
					loadTheirInventory(TheirPage);
				}
				
				function sendTrade() {
					GivingCredits = document.getElementById("MyCreditsAmt").value;
					RequestingCredits = document.getElementById("TheirCreditsAmt").value;
					var errorMsg = "";
					if (GivingCount < 1) {
						errorMsg = "You must offer at least one (1) item in a trade.";
					} else if (RequestingCount < 1) {
						errorMsg = "You must request at least one(1) item in a trade.";
					} else if (GivingCount > 4) {
						errorMsg = "You can only give up to four (4) items in a trade.";
					} else if (RequestingCount > 4) {
						errorMsg = "You can only request up to four (4) items in a trade.";
					} else if (GivingCredits > '.$myU->CurrencyCredits.') {
						errorMsg = "You can only offer up to '.number_format($myU->CurrencyCredits).' Credits to <strong>'.$gU->Username.'</strong>.";
					} else if (GivingCredits < 0 || RequestingCredits < 0) {
						errorMsg = "Invalid credits amount";
					}
					if (errorMsg) {
						var code = "<div class=\"grid-x grid-margin-x align-middle\"><div class=\"auto cell no-margin\"><div class=\"modal-title\">An error has occurred.</div></div><div class=\"shrink cell no-margin\"><button class=\"close-button\" data-close aria-label=\"Close modal\" type=\"button\"><span aria-hidden=\"true\">&times;</span></button></div></div><div class=\"bc-modal-contentText\"><p>" + errorMsg + "</p></div><div class=\"push-10\"></div><div align=\"center\"><input type=\"button\" data-close class=\"button button-grey store-button inline-block\" value=\"Go back\"></div>";
						document.getElementById("SendTrade").innerHTML = code;
					} else {
						var code = "<div class=\"grid-x grid-margin-x align-middle\"><div class=\"auto cell no-margin\"><div class=\"modal-title\">Confirm Trade</div></div><div class=\"shrink cell no-margin\"><button class=\"close-button\" data-close aria-label=\"Close modal\" type=\"button\"><span aria-hidden=\"true\">&times;</span></button></div></div><div class=\"bc-modal-contentText\"><p>Are you sure you wish to send this trade to <strong>'.$gU->Username.'</strong>?</p></div><div class=\"push-10\"></div><div align=\"center\"><input type=\"submit\" class=\"button button-green store-button inline-block\" value=\"Send Trade\" data-close onclick=\"submitTrade()\"><input type=\"button\" data-close class=\"button button-grey store-button inline-block\" value=\"Go back\"></div>";
						document.getElementById("SendTrade").innerHTML = code;
					}
				}
				
				function submitTrade() {
					GivingCredits = document.getElementById("MyCreditsAmt").value;
					RequestingCredits = document.getElementById("TheirCreditsAmt").value;
					$.post("'.$serverName.'/trade/process/", {username: "'.$gU->Username.'", giving_list: GivingInventoryList.toString(), requesting_list: RequestingInventoryList.toString(), giving_credits: GivingCredits, requesting_credits: RequestingCredits, csrf_token: "'.$_SESSION['csrf_token'].'"}, function(data, status) {
						if (data != "ok") {
							document.getElementById("error-message").style.display = "block";
							document.getElementById("error-message").innerHTML = data;
						} else if (data == "ok") {
							document.getElementById("success-message").style.display = "block";
							document.getElementById("success-message").innerHTML = "You have successfully sent a trade to <strong>'.$gU->Username.'</strong>. Redirecting...";
							setTimeout(function() {
								window.location.href = "'.$serverName.'/users/'.$gU->Username.'/";
							}, 2000);
						}
					});
				}
				
				window.onload = function() {
					loadMyInventory(1);
					loadTheirInventory(1);
				}
			</script>
			<div class="grid-x grid-margin-x align-middle">
				<div class="auto cell">
					<h4>Trade with <strong>'.$gU->Username.'</h4>
				</div>
				<div class="shrink cell right">
					<a href="'.$serverName.'/users/'.$gU->Username.'/" class="button button-grey" style="padding: 8px 15px;font-size:13px;line-height:1.25;margin-left:0.9375rem;margin-right:0.9375rem;">Return to Profile</a>
				</div>
			</div>
			<div class="push-10"></div>
			<div class="reveal item-modal" id="AddMyCredits" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
				<form action="" method="POST">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Add Credits</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="bc-modal-contentText">
						<p>Please choose how many Credits you would like to offer to <strong>'.$gU->Username.'</strong>.</p>
						<input type="text" class="normal-input" id="MyCreditsAmt" value="0">
					</div>
					<div class="push-15"></div>
					<div align="center">
						<input type="button" data-close class="button button-green store-button inline-block" value="Add to Trade" onclick="addMyCredits()">
						<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
					</div>
				</form>
			</div>
			<div class="reveal item-modal" id="AddTheirCredits" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
				<form action="" method="POST">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Add Credits</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="bc-modal-contentText">
						<p>Please choose how many Credits you would like to request from <strong>'.$gU->Username.'</strong>.</p>
						<input type="text" class="normal-input" id="TheirCreditsAmt" value="0">
					</div>
					<div class="push-15"></div>
					<div align="center">
						<input type="button" data-close class="button button-green store-button inline-block" value="Add to Trade" onclick="addTheirCredits()">
						<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
					</div>
				</form>
			</div>
			<div class="reveal item-modal" id="SendTrade" data-reveal data-animation-in="fade-in" data-animation-out="fade-out"></div>
			<div class="error-message" id="error-message" style="display:none;"></div>
			<div class="success-message" id="success-message" style="display:none;"></div>
			<div class="grid-x grid-margin-x">
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>'.$myU->Username.'</strong>
					</div>
					<div class="container border-wh sm-padding">
						<img src="'.$cdnName . $myU->AvatarURL.'.png">
					</div>
					<div class="push-10"></div>
					<button class="button button-grey" style="width:100%;" data-open="AddMyCredits">Add Credits</button>
				</div>
				<div class="large-6 medium-6 cell">
					<div class="container-header md-padding">
						<strong>Your Inventory</strong>
					</div>
					<div class="container border-wh">
						<div id="MyInventory"></div>
					</div>
				</div>
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>Giving</strong>
					</div>
					<div class="container border-wh">
						<div class="grid-x grid-margin-x" id="GivingDiv">
						</div>
						<div id="GivingCredits" class="trade-credits text-center"></div>
					</div>
				</div>
			</div>
			<div class="push-15"></div>
			<div class="grid-x grid-margin-x">
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>'.$gU->Username.'</strong>
					</div>
					<div class="container border-wh sm-padding">
						<img src="'.$cdnName . $gU->AvatarURL.'.png">
					</div>
					<div class="push-10"></div>
					<button class="button button-grey" style="width:100%;" data-open="AddTheirCredits">Add Credits</button>
				</div>
				<div class="large-6 medium-6 cell">
					<div class="container-header md-padding">
						<strong>Their Inventory</strong>
					</div>
					<div class="container border-wh">
						<div id="TheirInventory"></div>
					</div>
				</div>
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>Requesting</strong>
					</div>
					<div class="container border-wh">
						<div class="grid-x grid-margin-x" id="RequestingDiv">
						</div>
						<div id="RequestingCredits" class="trade-credits text-center"></div>
					</div>
				</div>
			</div>
			<div class="push-25"></div>
			<div align="center">
				<input type="button" class="button button-green store-button inline-block" value="Send Trade" data-open="SendTrade" onclick="sendTrade()">
				<input type="button" class="button button-grey store-button inline-block" value="Cancel Trade" onclick="window.location.assign(\''.$serverName.'/users/'.$gU->Username.'/\')">
			</div>
			';
		
		}
	
	}
	
require_once("/var/www/html/root/private/footer.php");;