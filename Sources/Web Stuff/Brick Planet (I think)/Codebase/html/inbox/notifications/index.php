<?php
$page = 'inbox';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
	$MarkAllAsRead = (!empty($_POST['mark_all_as_read'])) ? true : false;
	$CSRFToken = (!empty($_POST['csrf_token'])) ? $_POST['csrf_token'] : false;
	
	if ($MarkAllAsRead && $CSRFToken && $CSRFToken == $_SESSION['csrf_token']) {
		
		$UpdateUserNotification = $db->prepare("UPDATE UserNotification SET TimeRead = UNIX_TIMESTAMP() WHERE ReceiverID = ".$myU->ID." AND TimeRead = 0");
		$UpdateUserNotification->execute();
		$cache->delete($myU->ID);
		
		header("Location: ".$serverName."/inbox/notifications");
		die;
		
	}
	
	echo '
	<script>
	var currentPage = 1;
	var maxPages = 0;
	function refreshNotifications(page) {
		if (!page) page = 1;
		if (page > 1) currentPage = page;
		var newHtml = "";
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "'.$serverName.'/api/user/get-notifications?p=" + page, true);
		xhr.onload = function (e) {
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					var json = xhr.responseText;
					if (!JSON.parse(json)) return;
					json = JSON.parse(json);
					if (json.status == "ok") {
						if (maxPages == 0) maxPages = json.notificationsPages;
						if (json.notificationsCount == 0) {
							// handle
							return;
						}
						for (var i = 0; i < json.content.length; i++) {
							console.log(row);
							var row = json.content[i];
							if (i > 0) { newHtml += `<div class="user-chat-row-divider"></div>`; }
							var message = (row.notificationTimeRead > 0) ? row.notificationMessage : "<strong>" + row.notificationMessage + "</strong>";
							newHtml += `
							<div class="chats-row" onclick="openNotification(` + row.notificationId + `, \'` + row.notificationUrl + `\')">
								<div class="grid-x grid-margin-x align-middle">
									<div class="shrink cell">
										<div class="user-chat-user-thumbnail-64 relative" style="background-image:url(` + row.senderAvatar + `);background-size:64px 64px;">
											`;
											if (row.senderTimeLastSeen) {
												newHtml += `<div class="user-chat-user-activity-status" style="background:#` + row.senderTimeLastSeen + `;" title="` + row.senderUsername + ` is online"></div>`;
											}
											newHtml += `
										</div>
									</div>
									<div class="auto cell">
										<span><a href="'.$serverName.'/users/` + row.senderUsername + `/"><strong>` + row.senderUsername + `</strong></a></span>
										<span>&nbsp;&bullet;&nbsp;</span>
										<span class="chats-row-time">` + row.notificationTime + `</span>
										<div class="chats-row-snippet">
										`;
										if (row.notificationTimeRead == 0) {
											newHtml += `<span class="notifications-red-dot"></span>`;
										}
										newHtml += `
										<span>` + message + `</span>
										</div>
									</div>
								</div>
							</div>
							`;
							if ((i + 1) == json.content.length && document.getElementById("recent-notifications").innerHTML != newHtml) {
								if (currentPage < maxPages) {
									document.getElementById("recent-notifications-load-more").innerHTML = `
									<div class="push-15"></div>
									<div align="center"><a onclick="refreshNotifications(` + (currentPage + 1) + `)" style="font-size:18px;">Load more...</a></div>
									<div class="push-15"></div>
									`;
								} else {
									document.getElementById("recent-notifications-load-more").innerHTML = "";
								}
								document.getElementById("recent-notifications").innerHTML += newHtml;
							}
						}
					}
				}
			}
		};
		xhr.send(null);
	}
	
	$(document).ready(function () {
		refreshNotifications();
	});
	</script>
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4>Notifications '; if ($myU->NumNotifications > 0) { echo '<span class="notification-badge badge-large" style="margin-left:5px;">'.shortNum($myU->NumNotifications).'</span>'; } echo '</h4>
		</div>
		<div class="shrink cell no-margin right">
			<form action="" method="POST">
				<button type="submit" class="button button-blue" style="padding:4px 15px;" name="mark_all_as_read" value="1">Mark All as Read</button>
				<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
			</form>
		</div>
	</div>
	<div class="push-10"></div>
	<div class="container border-r">
		<div id="recent-notifications"></div>
		<div id="recent-notifications-load-more"></div>
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");