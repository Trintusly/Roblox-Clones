<?php
$page = 'inbox';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
	if (empty($myU->ChatId)) {
		generateRandomChatId($myU->ID);
		
		header("Location: ".$serverName."/inbox/user/" . $gU->Username);
		die;
	}
	
	echo '
	<script>
		document.title = "Inbox - Brick Create";
		var scrolled = false;
		var ChatId = '.$myU->ChatId.'; // Do not share this with anyone under any circumstances.
		
		function openUserChatMessage(Username) {
			window.location.assign("'.$serverName.'/inbox/user/" + Username);
		}
		
		function openGroupChatMessage(Id) {
			window.location.assign("'.$serverName.'/inbox/group/" + Id);
		}
		
		function openNotificationMessage(Id) {
			window.location.assign("'.$serverName.'/inbox/notification/" + Id);
		}
		
		function refreshRecentChats() {
			var newHtml = "";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "'.$serverName.'/api/chats/get-chats-summary", true);
			xhr.onload = function (e) {
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						var json = xhr.responseText;
						json = JSON.parse(json);
						for (var i = 0; i < json.length; i++) {
							var row = json[i];
							if (i > 0) { newHtml += `<div class="user-chat-row-divider"></div>`; }
							newHtml += `
							<div class="chats-row" onclick="openUserChatMessage(\'` + row.name + `\')">
								<div class="grid-x grid-margin-x align-middle">
									<div class="shrink cell">
										<div class="user-chat-user-thumbnail-64 relative" style="background-image:url(` + row.avatar + `);background-size:64px 64px;">
											`;
											if (row.type == 0) {
												newHtml += `<div class="user-chat-user-activity-status" style="background:#` + row.timelastseen + `;" title="` + row.name + ` is online"></div>`;
											}
											if (row.unread > 0) {
												newHtml += `<div class="user-chat-unread">` + row.unread + `</div>`;
											}
											if (row.type == 1) {
												newHtml += `<div class="user-chat-group" title="This is a group chat"><i class="material-icons">group</i></div>`;
											}
											newHtml += `
										</div>
									</div>
									<div class="auto cell">
										<span><a href="'.$serverName.'/users/` + row.name + `/"><strong>` + row.name + `</strong></a></span>
										<span>&nbsp;&bullet;&nbsp;</span>
										<span class="chats-row-time">` + row.timechat + `</span>
										<div class="chats-row-snippet">
											` + row.message + `
										</div>
									</div>
								</div>
							</div>
							`;
							if ((i + 1) == json.length && document.getElementById("recent-chats").innerHTML != newHtml) {
								document.getElementById("recent-chats").innerHTML = newHtml;
							}
						}
					}
				}
			};
			xhr.send(null);
		}
		
		function refreshRecentGroupChats() {
			var newHtml = "";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "'.$serverName.'/api/chats/get-group-chats-summary", true);
			xhr.onload = function (e) {
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						var json = xhr.responseText;
						json = JSON.parse(json);
						for (var i = 0; i < json.length; i++) {
							var row = json[i];
							if (i > 0) { newHtml += `<div class="user-chat-row-divider"></div>`; }
							newHtml += `
							<div class="chats-row" onclick="openGroupChatMessage(` + row.groupChatId + `)">
								<div class="grid-x grid-margin-x align-middle">
									<div class="shrink cell">
										<div class="user-chat-user-thumbnail-64 relative" style="background-image:url(` + row.avatar + `);background-size:64px 64px;">
											`;
											if (row.type == 0) {
												newHtml += `<div class="user-chat-user-activity-status" style="background:#` + row.timelastseen + `;" title="` + row.name + ` is online"></div>`;
											}
											if (row.unread > 0) {
												newHtml += `<div class="user-chat-unread">` + row.unread + `</div>`;
											}
											if (row.type == 1) {
												newHtml += `<div class="user-chat-group" title="This is a group chat"><i class="material-icons">group</i></div>`;
											}
											newHtml += `
										</div>
									</div>
									<div class="auto cell">
										<span><a href="'.$serverName.'/users/` + row.name + `/"><strong>` + row.name + `</strong></a></span>
										<span>&nbsp;&bullet;&nbsp;</span>
										<span class="chats-row-time">` + row.timechat + `</span>
										<div class="chats-row-snippet">
											` + row.message + `
										</div>
									</div>
								</div>
							</div>
							`;
							if ((i + 1) == json.length && document.getElementById("recent-group-chats").innerHTML != newHtml) {
								document.getElementById("recent-group-chats").innerHTML = newHtml;
							}
						}
					}
				}
			};
			xhr.send(null);
		}
		
		function refreshNotifications() {
			var newHtml = "";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "'.$serverName.'/api/chats/get-notifications-summary", true);
			xhr.onload = function (e) {
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						var json = xhr.responseText;
						json = JSON.parse(json);
						for (var i = 0; i < json.length; i++) {
							var row = json[i];
							if (i > 0) { newHtml += `<div class="user-chat-row-divider"></div>`; }
							newHtml += `
							<div class="chats-row" onclick="openNotificationMessage(` + row.notificationId + `)">
								<div class="grid-x grid-margin-x align-middle">
									<div class="shrink cell">
										<div class="user-chat-user-thumbnail-64 relative" style="background-image:url(` + row.avatar + `);background-size:64px 64px;">
											`;
											if (row.type == 0) {
												newHtml += `<div class="user-chat-user-activity-status" style="background:#` + row.timelastseen + `;" title="` + row.name + ` is online"></div>`;
											}
											if (row.unread > 0) {
												newHtml += `<div class="user-chat-unread">` + row.unread + `</div>`;
											}
											if (row.type == 1) {
												newHtml += `<div class="user-chat-group" title="This is a group chat"><i class="material-icons">group</i></div>`;
											}
											newHtml += `
										</div>
									</div>
									<div class="auto cell">
										<span><a href="'.$serverName.'/users/` + row.name + `/"><strong>` + row.name + `</strong></a></span>
										<span>&nbsp;&bullet;&nbsp;</span>
										<span class="chats-row-time">` + row.timechat + `</span>
										<div class="chats-row-snippet">
											` + row.message + `
										</div>
									</div>
								</div>
							</div>
							`;
							if ((i + 1) == json.length && document.getElementById("recent-notifications").innerHTML != newHtml) {
								document.getElementById("recent-notifications").innerHTML = newHtml;
							}
						}
					}
				}
			};
			xhr.send(null);
		}
		
		function chk_scroll(e) {
			var elem = $(e.currentTarget);
			if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
				scrolled = false;
			}
			else {
				scrolled = true;
			}
		}
		
		function setScroll() {
			if (!scrolled) {
				var div = document.getElementById("recent-chats");
				div.scrollTop = div.scrollHeight;
			}
		}
		
		$(document).ready(function () {
			$("#recent-chats").bind("scroll", chk_scroll);
			setScroll();
			refreshRecentChats();
			refreshRecentGroupChats();
			refreshNotifications();
			setInterval(refreshRecentChats, 10000);
			setInterval(refreshRecentGroupChats, 10000);
			setInterval(refreshNotifications, 10000);
		});
	</script>
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell">
			<h4>Inbox</h4>
			<div class="push-15"></div>
		</div>
	</div>
	<div class="grid-x grid-margin-x">
		<div class="small-12 medium-12 large-4 cell">
			<div class="container-header md-padding">
				<strong>Chats</strong>
			</div>
			<div class="container border-wh">
				<div id="recent-chats" class="recent-chats"></div>
			</div>
		</div>
		<div class="small-12 medium-12 large-4 cell">
			<div class="container-header md-padding">
				<strong>Group Chats</strong>
			</div>
			<div class="container border-wh">
				<div id="recent-group-chats" class="recent-chats"></div>
			</div>
		</div>
		<div class="small-12 medium-12 large-4 cell">
			<div class="container-header md-padding">
				<strong>Notifications</strong>
			</div>
			<div class="container border-wh">
				<div id="recent-notifications" class="recent-chats"></div>
			</div>
		</div>
	</div>
	';
	echo $sneak;

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");