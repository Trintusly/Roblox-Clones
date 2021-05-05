<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

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
	
	/*
	Received
	*/
	
	$countReceivedTrades = $db->prepare("SELECT COUNT(*) FROM UserTrade JOIN User ON UserTrade.RequesterID = User.ID WHERE UserTrade.ReceiverID = ".$myU->ID." AND UserTrade.Status = 0");
	$countReceivedTrades->execute();
	$countReceivedTrades = $countReceivedTrades->fetchColumn();
	
	$ReceivedLimit = 10;
		
	$ReceivedPages = ceil($countReceivedTrades / $ReceivedLimit);
		
	$ReceivedPage = min($ReceivedPages, filter_input(INPUT_GET, 'ReceivedPage', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
		
	$ReceivedOffset = ($ReceivedPage - 1)  * $ReceivedLimit;
	if ($ReceivedOffset < 0) { $ReceivedOffset = 0; }
	if ($ReceivedPage == 0) { $ReceivedPage = 1; }
	
	$getReceivedTrades = $db->prepare("SELECT UserTrade.ID, UserTrade.RequesterID, UserTrade.ReceiverID, User.Username, User.AvatarURL, UserTrade.Time FROM UserTrade JOIN User ON UserTrade.RequesterID = User.ID WHERE UserTrade.ReceiverID = ".$myU->ID." AND UserTrade.Status = 0 ORDER BY UserTrade.UpdatedOn DESC LIMIT ? OFFSET ?");
	$getReceivedTrades->bindValue(1, $ReceivedLimit, PDO::PARAM_INT);
	$getReceivedTrades->bindValue(2, $ReceivedOffset, PDO::PARAM_INT);
	$getReceivedTrades->execute();
	
	/*
	Sent
	*/
	
	$countSentTrades = $db->prepare("SELECT COUNT(*) FROM UserTrade JOIN User ON UserTrade.ReceiverID = User.ID WHERE UserTrade.RequesterID = ".$myU->ID." AND UserTrade.Status = 0");
	$countSentTrades->execute();
	$countSentTrades = $countSentTrades->fetchColumn();
	
	$SentLimit = 10;
		
	$SentPages = ceil($countSentTrades / $SentLimit);
		
	$SentPage = min($SentPages, filter_input(INPUT_GET, 'SentPage', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
		
	$SentOffset = ($SentPage - 1)  * $SentLimit;
	if ($SentOffset < 0) { $SentOffset = 0; }
	if ($SentPage == 0) { $SentPage = 1; }
	
	$getSentTrades = $db->prepare("SELECT UserTrade.ID, UserTrade.RequesterID, UserTrade.ReceiverID, User.Username, User.AvatarURL, UserTrade.Time FROM UserTrade JOIN User ON UserTrade.ReceiverID = User.ID WHERE UserTrade.RequesterID = ".$myU->ID." AND UserTrade.Status = 0 ORDER BY UserTrade.UpdatedOn DESC LIMIT ? OFFSET ?");
	$getSentTrades->bindValue(1, $SentLimit, PDO::PARAM_INT);
	$getSentTrades->bindValue(2, $SentOffset, PDO::PARAM_INT);
	$getSentTrades->execute();
	
	/*
	History
	*/
	
	$countHistoryTrades = $db->prepare("SELECT COUNT(*) FROM UserTrade JOIN User ON UserTrade.RequesterID = User.ID WHERE (UserTrade.RequesterID = ".$myU->ID." OR UserTrade.ReceiverID = ".$myU->ID.") AND (UserTrade.Status IN(1,2,3) OR UserTrade.Expires < ".time().")");
	$countHistoryTrades->execute();
	$countHistoryTrades = $countHistoryTrades->fetchColumn();
	
	$HistoryLimit = 10;
		
	$HistoryPages = ceil($countHistoryTrades / $HistoryLimit);
		
	$HistoryPage = min($HistoryPages, filter_input(INPUT_GET, 'HistoryPage', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
		
	$HistoryOffset = ($HistoryPage - 1)  * $HistoryLimit;
	if ($HistoryOffset < 0) { $HistoryOffset = 0; }
	if ($HistoryPage == 0) { $HistoryPage = 1; }
	
	$getHistoryTrades = $db->prepare("SELECT UserTrade.ID, UserTrade.RequesterID, UserTrade.ReceiverID, User.Username, User.AvatarURL, UserTrade.Time FROM UserTrade JOIN User ON (CASE WHEN UserTrade.RequesterID = ".$myU->ID." THEN UserTrade.ReceiverID ELSE UserTrade.RequesterID END) = User.ID WHERE (UserTrade.RequesterID = ".$myU->ID." OR UserTrade.ReceiverID = ".$myU->ID.") AND (UserTrade.Status IN(1,2,3) OR UserTrade.Expires < ".time().") ORDER BY UserTrade.UpdatedOn DESC LIMIT ? OFFSET ?");
	$getHistoryTrades->bindValue(1, $HistoryLimit, PDO::PARAM_INT);
	$getHistoryTrades->bindValue(2, $HistoryOffset, PDO::PARAM_INT);
	$getHistoryTrades->execute();
	
	echo '
	<script>
	document.title = "Trades - Brick Create";
	
	function OpenTrade(TradeId) {
		window.location.assign("'.$serverName.'/trade/view/" + TradeId + "/");
	}
	
	var ReceivedNum = "'.number_format($countReceivedTrades).'";
	var SentNum = "'.number_format($countSentTrades).'";
	var HistoryNum = "'.number_format($countHistoryTrades).'";
	
	window.onload = function() {
		';
		
		if (!empty($_GET['ReceivedPage'])) {
			echo '$("#tabs").foundation("selectTab", "received"); received();';
			$jumped = 1;
		} else if (!empty($_GET['SentPage'])) {
			echo '$("#tabs").foundation("selectTab", "sent"); sent();';
			$jumped = 1;
		} else if (!empty($_GET['HistoryPage'])) {
			echo '$("#tabs").foundation("selectTab", "history"); history();';
			$jumped = 1;
		} else {
			echo '
			document.getElementById("received-tab").innerHTML = "Received (" + ReceivedNum + ")";
			';
		}
		
		
		
		echo '
	}
	
	function received() {
		document.getElementById("received-tab").innerHTML = "Received (" + ReceivedNum + ")";
		document.getElementById("sent-tab").innerHTML = "Sent";
		document.getElementById("history-tab").innerHTML = "History";
	}
	
	function sent() {
		document.getElementById("sent-tab").innerHTML = "Sent (" + SentNum + ")";
		document.getElementById("received-tab").innerHTML = "Received";
		document.getElementById("history-tab").innerHTML = "History";
	}
	
	function history() {
		document.getElementById("history-tab").innerHTML = "History (" + HistoryNum + ")";
		document.getElementById("received-tab").innerHTML = "Received";
		document.getElementById("sent-tab").innerHTML = "Sent";
	}
	</script>
	<h4>Trades</h4>
	<div class="push-10"></div>
	<ul class="tabs grid-x grid-margin-x inbox-tabs" data-tabs id="tabs">
		<li class="no-margin tabs-title cell'; if (!isset($jumped)) { echo ' is-active'; } echo '"><a href="#received" id="received-tab" onclick="received()">Received</a></li>
		<li class="no-margin tabs-title cell"><a href="#sent" id="sent-tab" onclick="sent()">Sent</a></li>
		<li class="no-margin tabs-title cell"><a href="#history" class="no-right-border" id="history-tab" onclick="history()">History</a></li>
	</ul>
	<div class="tabs-content" data-tabs-content="tabs">
		<div id="received" class="tabs-panel'; if (!isset($jumped)) { echo ' is-active'; } echo '">
			<div class="container border-wh">
			';
			
			if ($countReceivedTrades == 0) {
				
				echo '
				<div style="padding:15px;">
					No trades found here.
				</div>
				';
				
			} else {
			
				while ($gR = $getReceivedTrades->fetch(PDO::FETCH_OBJ)) {
					
					echo '
					<div class="grid-x grid-margin-x align-middle inbox-block" onclick="OpenTrade('.$gR->ID.')">
						<div class="shrink cell">
							<div class="inbox-avatar" style="background:url('.$cdnName . $gR->AvatarURL.'-thumb.png);background-size:cover;"></div>
						</div>
						<div class="auto cell">
							Incoming trade from <strong>'.$gR->Username.'</strong>
						</div>
						<div class="shrink cell right">
							<span class="message-time">Received '.date('m/d/Y g:iA', $gR->Time).'</span>
						</div>
					</div>
					';
					
				}
			
			}
			
			echo '
			</div>
			';
			
			if ($countReceivedTrades > 0 && $ReceivedPages > 1) {
				
				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($ReceivedPage == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/trades/?ReceivedPage='.($ReceivedPage-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
					';

					for ($i = max(1, $ReceivedPage - 5); $i <= min($ReceivedPage + 5, $ReceivedPages); $i++) {
						
						if ($i <= $ReceivedPages) {
						
							echo '<li'; if ($ReceivedPage == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/account/trades/?ReceivedPage='.($i).'">'.$i.'</a></li>';

						}
						
					}

					echo '
					<li class="pagination-next'; if ($ReceivedPage == $ReceivedPAges) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/trades/?ReceivedPage='.($ReceivedPage+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
				</ul>
				';
				
			}
			
			echo '
		</div>
		<div id="sent" class="tabs-panel">
			<div class="container border-wh">
			';
			
			if ($countSentTrades == 0) {
				
				echo '
				<div style="padding:15px;">
					No trades found here.
				</div>
				';
				
			} else {
			
				while ($gS = $getSentTrades->fetch(PDO::FETCH_OBJ)) {
					
					echo '
					<div class="grid-x grid-margin-x align-middle inbox-block" onclick="OpenTrade('.$gS->ID.')">
						<div class="shrink cell">
							<div class="inbox-avatar" style="background:url('.$cdnName . $gS->AvatarURL.'-thumb.png);background-size:cover;"></div>
						</div>
						<div class="auto cell">
							Outbound trade request to <strong>'.$gS->Username.'</strong>
						</div>
						<div class="shrink cell right">
							<span class="message-time">Sent '.date('m/d/Y g:iA', $gS->Time).'</span>
						</div>
					</div>
					';
					
				}
			
			}
			
			echo '
			</div>
			';
			
			if ($countSentTrades > 0 && $SentPages > 1) {
				
				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($SentPage == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/trades/?SentPage='.($SentPage-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
					';

					for ($i = max(1, $SentPage - 5); $i <= min($SentPage + 5, $SentPages); $i++) {
						
						if ($i <= $SentPages) {
						
							echo '<li'; if ($SentPage == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/account/trades/?SentPage='.($i).'">'.$i.'</a></li>';

						}
						
					}

					echo '
					<li class="pagination-next'; if ($SentPage == $SentPages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/trades/?SentPage='.($SentPage+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
				</ul>
				';
				
			}
			
			echo '
		</div>
		<div id="history" class="tabs-panel">
			<div class="container border-wh">
			';
			
			if ($countHistoryTrades == 0) {
				
				echo '
				<div style="padding:15px;">
					No trades found here.
				</div>
				';
				
			} else {
			
				while ($gH = $getHistoryTrades->fetch(PDO::FETCH_OBJ)) {
					
					if ($gH->RequesterID == $myU->ID) {
						$Text = 'Outbound trade request to <strong>'.$gH->Username.'</strong>';
						$Time = 'Sent';
					} else {
						$Text = 'Incoming trade from <strong>'.$gH->Username.'</strong>';
						$Time = 'Received';
					}
					
					echo '
					<div class="grid-x grid-margin-x align-middle inbox-block" onclick="OpenTrade('.$gH->ID.')">
						<div class="shrink cell">
							<div class="inbox-avatar" style="background:url('.$cdnName . $gH->AvatarURL.'-thumb.png);background-size:cover;"></div>
						</div>
						<div class="auto cell">
							'.$Text.'
						</div>
						<div class="shrink cell right">
							<span class="message-time">'.$Time.' '.date('m/d/Y g:iA', $gH->Time).'</span>
						</div>
					</div>
					';
					
				}
			
			}
			
			echo '
			</div>
			';
			
			if ($countHistoryTrades > 0 && $HistoryPages > 1) {
				
				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($HistoryPage == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/trades/?HistoryPage='.($HistoryPage-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
					';

					for ($i = max(1, $HistoryPage - 5); $i <= min($HistoryPage + 5, $HistoryPages); $i++) {
						
						if ($i <= $HistoryPages) {
						
							echo '<li'; if ($HistoryPage == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/account/trades/?HistoryPage='.($i).'">'.$i.'</a></li>';

						}
						
					}

					echo '
					<li class="pagination-next'; if ($HistoryPage == $HistoryPages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/trades/?ReceivedPage='.$ReceivedPage.'&SentPage='.$SentPage.'&HistoryPage='.($HistoryPage+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
				</ul>
				';
				
			}
			
			echo '
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");