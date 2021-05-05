<?php
$page = 'inbox';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
	$Type = (!empty($_GET['type']) && ($_GET['type'] == 'user' || $_GET['type'] == 'group' || $_GET['type'] == 'notification')) ? $_GET['type'] : NULL;
	
	if ($Type == 'user') {
		
		$Username = (!empty($_GET['username'])) ? $_GET['username'] : NULL;
		$GetChatInfo = $db->prepare("SELECT User.ID, User.Username, User.PrivateMessageSettings, User.AvatarURL AS Image, (SELECT COUNT(*) FROM UserChat WHERE UserChat.SenderID = User.ID AND UserChat.ReceiverID = ".$myU->ID." AND UserChat.TimeRead = 0) AS UnreadMessages, (SELECT COUNT(*) FROM UserBlocked WHERE RequesterID = User.ID AND BlockedID = ".$myU->ID.") AS CheckBlocked, (SELECT COUNT(*) FROM Friend WHERE SenderID = User.ID AND ReceiverID = ".$myU->ID." AND Accepted = 1) AS CheckFriends FROM User WHERE User.Username = ?");
		$GetChatInfo->bindValue(1, $Username, PDO::PARAM_STR);
		$GetChatInfo->execute();
		
	} else if ($Type == 'group') {
		
		$GroupId = (!empty($_GET['groupId'])) ? $_GET['groupId'] : NULL;
		$GetChatInfo = $db->prepare("SELECT UserChatGroup.ID, UserChatGroup.Name, UserChatGroup.GroupImage, UserChatGroup.OwnerID, UserChatGroup.MemberCount, UserChatGroup.InviteCode, UserChatGroupMember.Role, UserChatGroupMember.UnreadMessageCount FROM UserChatGroup JOIN UserChatGroupMember ON UserChatGroup.ID = UserChatGroupMember.ChatGroupID WHERE UserChatGroup.ID = ? AND UserChatGroupMember.UserID = " . $myU->ID);
		$GetChatInfo->bindValue(1, $GroupId, PDO::PARAM_INT);
		$GetChatInfo->execute();
		
	} else if ($Type == 'notification') {
		
		$NotificationId = (!empty($_GET['notificationId'])) ? $_GET['notificationId'] : NULL;
		$GetChatInfo = $db->prepare("SELECT User.ID, User.Username, User.AvatarURL AS Image, (SELECT COUNT(*) FROM UserChat WHERE UserChat.SenderID = User.ID AND UserChat.ReceiverID = ".$myU->ID." AND UserChat.TimeRead = 0) AS UnreadMessages FROM UserNotificationMessage JOIN User ON User.ID = UserNotificationMessage.UserID JOIN UserNotification ON UserNotification.RelevanceID = UserNotificationMessage.ID WHERE UserNotificationMessage.ID = ? AND UserNotification.NotificationType = 4 AND UserNotification.ReceiverID = ".$myU->ID."");
		$GetChatInfo->bindValue(1, $NotificationId, PDO::PARAM_INT);
		$GetChatInfo->execute();
		
	}
	
	if ($GetChatInfo->rowCount() == 0) {
		
		header("Location: ".$serverName."/inbox");
		die;
		
	} else {
		
		$gCI = $GetChatInfo->fetch(PDO::FETCH_OBJ);
		$CanChat = true;
		
		if (empty($myU->ChatId)) {
			generateRandomChatId($myU->ID);
			
			header("Location: ".$serverName."/inbox/user/" . $gCI->Username);
			die;
		}
		
		if ($Type == 'user') {
			
			if ($gCI->PrivateMessageSettings == 1 && $gCI->CheckFriends == 0 || $gCI->PrivateMessageSettings == 2) {
				$CanChat = false;
			}
			
			if ($gCI->UnreadMessages > 0) {
				$UpdateUserChat = $db->prepare("UPDATE UserChat JOIN User ON User.ID = UserChat.ReceiverID SET UserChat.TimeRead = UNIX_TIMESTAMP(), User.NumChats = User.NumChats - ".$gCI->UnreadMessages." WHERE UserChat.SenderID = ".$gCI->ID." AND UserChat.ReceiverID = ".$myU->ID."");
				$UpdateUserChat->execute();
				$cache->delete($myU->ID);
				
				header("Location: ".$serverName."/inbox/user/" . $gCI->Username);
				die;
			}
			
		} else if ($Type == 'group') {
			
			if ($gCI->UnreadMessageCount > 0) {
				$UpdateUserChat = $db->prepare("UPDATE UserChatGroupMember JOIN User ON User.ID = UserChatGroupMember.UserID SET User.NumChats = User.NumChats - UserChatGroupMember.UnreadMessageCount, UserChatGroupMember.UnreadMessageCount = 0 WHERE UserChatGroupMember.ChatGroupID = ".$gCI->ID." AND UserChatGroupMember.UserID = ".$myU->ID);
				$UpdateUserChat->execute();
				$cache->delete($myU->ID);
				
				header("Location: ".$serverName."/inbox/group/" . $gCI->ID);
				die;
			}
			
		} else if ($Type == 'notification') {
			
			if ($gCI->UnreadMessages > 0) {
				$UpdateUserNotification = $db->prepare("UPDATE UserNotification JOIN User ON User.ID = UserNotification.ReceiverID SET UserNotification.TimeRead = UNIX_TIMESTAMP(), User.NumChats = User.NumChats - ".$gCI->UnreadMessages." WHERE UserNotification.SenderID = ".$gCI->ID." AND UserNotification.ReceiverID = ".$myU->ID." AND UserNotification.TimeRead = 0 AND UserNotification.NotificationType = 4");
				$UpdateUserNotification->execute();
				$cache->delete($myU->ID);
				
				header("Location: ".$serverName."/inbox/user/" . $gCI->Username);
				die;
			}
			
		}
		
		//
		
		$ChatServer = ($serverName == 'https://www.brickcreate.com') ? 'https://inbox.brickcreate.com' : 'https://inboxtest.brickcreate.com';
		echo '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
		<script src="'.$serverName.'/assets/js/jquery.timeago.js" type="text/javascript"></script>
		<script src="'.$serverName.'/assets/js/delivery.js"></script>
		<script>
		document.title = "Chat with '; if ($Type == 'user' || $Type == 'notification') { echo $gCI->Username; } else { echo $gCI->Name; } echo ' - Brick Create";
		var scrolled = false;
		var ChatId = '.$myU->ChatId.'; // Do not share this with anyone under any circumstances.
		var socket = io.connect("'.$ChatServer.'", {
			reconnection: true,
			reconnectionDelay: 1000,
			reconnectionDelayMax : 5000,
			reconnectionAttempts: 99999
		});
		var chatPage = 1;
		
		function openUserChatMessage(Username) {
			window.location.assign("'.$serverName.'/inbox/user/" + Username);
		}
		
		function openGroupChatMessage(Id) {
			window.location.assign("'.$serverName.'/inbox/group/" + Id);
		}
		
		function openNotificationMessage(Id) {
			window.location.assign("'.$serverName.'/inbox/notification/" + Id);
		}
		
		function LoadChats() {
			var newChatHtml = "";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "'.$serverName.'/api/chats/get-chats/'.$Type.'/'; if ($Type == 'user' || $Type == 'notification') { echo $gCI->Username; } else { echo $gCI->ID; } echo '/" + chatPage, true);
			xhr.onload = function (e) {
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						if (!JSON.parse(xhr.responseText)) return;
						var json = JSON.parse(xhr.responseText);
						if (json.results.count == 0) return;
						for (var i = 0; i < json.results.length; i++) {
							var res = json.results[i]
							if (res.orientation == "self") {
								newChatHtml = `
								<div class="user-chat-message-row">
									<div class="grid-x grid-margin-x">
										<div class="auto cell">&nbsp;</div>
										<div class="shrink cell no-margin" style="font-size:0;">
											<div class="user-chat-message right">
												` + res.message + `
											</div>
											<div class="clearfix"></div>
											<div class="user-chat-message-time position-self"><a>You</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<time class="timeago" datetime="` + res.timeChat + `">` + res.timeChat + `</time></div>
										</div>
										<div class="shrink cell no-margin">
											<div class="arrow-right"></div>
										</div>
										<div class="shrink cell no-margin">
											<a href="'.$serverName.'/users/` + res.username + `/" title="` + res.username + `" target="_blank"><div class="user-chat-user-thumbnail-42" style="background-image:url('.$cdnName.'` + res.image + `-thumb.png);background-size:42px 42px;"></div></a>
										</div>
									</div>
								</div>
								` + newChatHtml;
							} else if (res.orientation == "other") {
								newChatHtml = `
								<div class="user-chat-message-row">
									<div class="grid-x grid-margin-x">
										<div class="shrink cell no-margin">
											<a href="'.$serverName.'/users/` + res.username + `/" title="` + res.username + `" target="_blank"><div class="user-chat-user-thumbnail-42" style="background-image:url('.$cdnName.'` + res.image + `-thumb.png);background-size:42px 42px;"></div></a>
										</div>
										<div class="shrink cell no-margin">
											<div class="arrow-left"></div>
										</div>
										<div class="shrink cell no-margin" style="font-size:0;">
											<div class="user-chat-message">
												` + res.message + `
											</div>
											<div class="user-chat-message-time position-other"><a href="'.$serverName.'/users/` +  res.username + `/" target="_blank">` +  res.username + `</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<time class="timeago" datetime="` + res.timeChat + `">` + res.timeChat + `</time></div>
										</div>
									</div>
								</div>
								` + newChatHtml;
							}
						}
						if (chatPage == 1) {
							document.getElementById("chat_window").innerHTML = newChatHtml;
							setScroll();
						} else {
							var $current_top_element = $("#chat_window .user-chat-message-row:first");
							$("#chat_window").prepend(newChatHtml);
							var previous_height = 0;
							$current_top_element.prevAll().each(function() {
							  previous_height += $(this).outerHeight();
							});
							$("#chat_window").scrollTop(previous_height);
						}
						$("#chat_window .timeago").timeago();
					}
				}
			};
			xhr.send(null);
		}
		
		function LoadMoreChats(element) {
			var top = element.scrollTop;
			if (top == 0) {
				chatPage++;
				LoadChats();
			}
		}
		
		function refreshRecentChats() {
			var newHtml = "";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "'.$serverName.'/api/chats/get-recent-chats", true);
			xhr.onload = function (e) {
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						var json = xhr.responseText;
						json = JSON.parse(json);
						for (var i = 0; i < json.length; i++) {
							var row = json[i];
							var className = (row.name == "'; if ($Type == 'user' || $Type == 'notification') { echo $gCI->Username; } else { echo $gCI->Name; } echo '") ? "chats-row chat-active" : "chats-row";
							if (i > 0) { newHtml += `<div class="user-chat-row-divider"></div>`; }
							newHtml += `
							<div class="` + className +`" onclick="`; if (row.type == 0) { newHtml += `openUserChatMessage(\'` + row.name + `\')`; } else if (row.type == 1) { newHtml += ` openGroupChatMessage(\'` + row.groupChatId + `\')`; } else if (row.type == 2) { newHtml += ` openNotificationMessage(\'` + row.groupChatId + `\')`; } newHtml += `">
								<div class="grid-x grid-margin-x align-middle">
									<div class="shrink cell">
										<div class="user-chat-user-thumbnail-64 relative" style="background-image:url(` + row.avatar + `);background-size:64px 64px;">
											`;
											if (row.type == 0 || row.type == 2) {
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
								$("#chat_window .timeago:last").timeago();
							}
						}
					}
				}
			};
			xhr.send(null);
		}
		
		function sendChat(reference, event) {
			var ok = 0;
			if (reference && event) {
				if (event.keyCode == 13 && event.ShiftKey) {
					document.execCommand("insertHTML", false, "<br><br>");
				} else if (event.keyCode == 13 && !event.shiftKey) {
					event.preventDefault();
					ok = 1;
				} else {
					document.execCommand("insertHTML", false, "");
				}
			} else {
				reference = document.getElementById("send-chat-input");
				ok = 1;
			}
			var Message = reference.innerHTML;
			if (ok != 1 || !reference || !Message) return;
			var ChatDivId = Math.random();
			var iso8601 = new Date().toISOString();
			document.getElementById("chat_window").innerHTML += `
			<div class="user-chat-message-row" id="` + ChatDivId + `">
				<div class="grid-x grid-margin-x">
					<div class="auto cell">&nbsp;</div>
					<div class="shrink cell no-margin" style="font-size:0;">
						<div class="user-chat-message right">
							<font class="message-pending">` + Message + `</font>
						</div>
						<div class="clearfix"></div>
						<div class="user-chat-message-time position-self"><a>You</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<time class="timeago" datetime="` + iso8601 + `"></time></div>
					</div>
					<div class="shrink cell no-margin">
						<div class="arrow-right"></div>
					</div>
					<div class="shrink cell no-margin">
						<a href="'.$serverName.'/users/'.$myU->Username.'/" title="'.$myU->Username.'" target="_blank"><div class="user-chat-user-thumbnail-42" style="background-image:url('.$cdnName . $myU->AvatarURL.'-thumb.png);background-size:42px 42px;"></div></a>
					</div>
				</div>
			</div>
			`;
			
			$("#chat_window .timeago").timeago();
			$("#send-chat-input").empty();
			setScroll();
			
			socket.emit("chat", Message, function(data) {
				if (!data || !data.status) return;
				if (data.status == true) {
					document.getElementById(ChatDivId).getElementsByClassName("user-chat-message")[0].innerHTML = data.message;
					refreshRecentChats();
				} else {
					document.getElementById(ChatDivId).remove();
				}
			});
		}
		
		socket.on("chat", function(json) {
			if (!json) return;
			var iso8601 = new Date().toISOString();
			document.getElementById("chat_window").innerHTML += `
			<div class="user-chat-message-row">
				<div class="grid-x grid-margin-x">
					<div class="shrink cell no-margin">
						<a href="'.$serverName.'/users/` + json.username + `/" title="` + json.username + `" target="_blank"><div class="user-chat-user-thumbnail-42" style="background-image:url('.$cdnName.'` + json.avatar + `);background-size:42px 42px;"></div></a>
					</div>
					<div class="shrink cell no-margin">
						<div class="arrow-left"></div>
					</div>
					<div class="shrink cell no-margin" style="font-size:0;">
						<div class="user-chat-message">
							` + json.message + `
						</div>
						<div class="user-chat-message-time position-other"><a href="'.$serverName.'/users/` + json.username + `/" title="` + json.username + `" target="_blank">` + json.username + `</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<time class="timeago" datetime="` + iso8601 + `"></time></div>
					</div>
				</div>
			</div>
			`;
			$("#chat_window .timeago:last").timeago();
			setScroll();
		});
		
		socket.on("fetch recent chats", function(data) {
			refreshRecentChats();
		});
		
		socket.on("connect", function() {
			';
			
			$ChatName = ($Type == 'user' || $Type == 'notification') ? $gCI->Username : $gCI->ID;
			
			echo '
			socket.emit("authenticate", [ChatId, "'.$Type.'", "'.$ChatName.'"], function(data) {
				setInterval(sendPing, 30000);
			});
		});
		
		socket.on("kicked", function(data) {
			alert("You have been kicked from the group chat.");
			window.location.href = "'.$serverName.'/inbox";
			return false;
		});
		
		socket.on("connect", function() {
			document.getElementById("error").style.display = "none";
		});
		
		socket.on("disconnect", function() {
			document.getElementById("error").style.display = "block";
			clearInterval(sendPing);
		});
		
		function chk_scroll(e) {
			var elem = $(e.currentTarget);
			if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
				scrolled = false;
			} else {
				scrolled = true;
			}
		}
		
		function setScroll() {
			if (!scrolled) {
				var div = document.getElementById("chat_window");
				div.scrollTop = div.scrollHeight;
			}
		}
		
		function ViewMembers(page) {
			if (!page) page = 1;
			var viewMembersHtml = "";
			var lastSearchedUsername = "";
			var kickableMembers = [];
			document.getElementById("view-members-html").innerHTML = "Loading...";
			
			var http = new XMLHttpRequest();
			http.open("GET", "'.$serverName.'/api/chats/group/get-members?chatGroupId='.$gCI->ID.'&p=" + page, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4 && http.status == 200) {
					var res = JSON.parse(http.responseText);
					if (res.status == "ok") {
						var rows = res.data;
						for (var i = 0; i < rows.length; i++) {
							var row = rows[i];
							if (i > 0) { viewMembersHtml += `<div class="chat-group-manage-members-divider"></div>`; }
							viewMembersHtml += `
							<div class="grid-x grid-margin-x align-middle">
								<div class="shrink cell">
									<div class="chat-group-manage-members-user-thumb" style="background-image:url('.$cdnName . '` + row.avatar + `-thumb.png);background-size:cover;"></div>
								</div>
								<div class="auto cell">
									<span><a href="'.$serverName.'/users/` + row.username + `/" class="chat-group-manage-members-username">` + row.username + `</a></span>
									`;
									if (row.role == 1) {
										viewMembersHtml += `
										<span class="chat-group-manage-members-role-mod">MODERATOR</span>
										`;
									} else if (row.role == 2) {
										viewMembersHtml += `
										<span class="chat-group-manage-members-role-owner">OWNER</span>
										`;
									}
									viewMembersHtml += `
								</div>
							</div>
							`;
						}
						if (res.pages > 1) {
							viewMembersHtml += `
							<div class="push-25"></div>
							<ul class="pagination" role="navigation" aria-label="Pagination">
								<li class="pagination-previous`; if (page == 1) { viewMembersHtml += ` disabled">Previous <span class="show-for-sr">page</span>`; } else { viewMembersHtml += `" onclick="ViewMembers(` + (page-1) + `)">Previous <span class="show-for-sr">page</span>`; } viewMembersHtml += `</li>
								`;
								for (var i = Math.max(1, page-5); i <= Math.min(page+5, res.pages); i++) {
									if (i <= res.pages) {
										viewMembersHtml += `<li`; if (page == i) { viewMembersHtml += ` class="current"`; } viewMembersHtml += ` aria-label="Page ` + i +`" onclick="ViewMembers(` + i + `)">` + i + `</li>`;
									}
								}
								viewMembersHtml += `
								<li class="pagination-next`; if (page == res.pages) { viewMembersHtml += ` disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>`; } else { viewMembersHtml += `" onclick="ViewMembers(` + (page+1) + `)">Next <span class="show-for-sr">page</span>`; } viewMembersHtml += `</li>
							</ul>
							`;
						}
						document.getElementById("view-members-html").innerHTML = viewMembersHtml;
						document.getElementById("view-members-title").innerHTML = "View Members (" + res.totalCount + ")";
						for (var i = 0; i < kickableMembers.length; i++) {
							$("#KickUser" + kickableMembers[i]).foundation();
						}
					} else {
						document.getElementById("view-members-html").innerHTML = res.msg;
					}
				}
			}
			http.send();
		}
		
		function sendPing() {
			socket.emit("ping", 1);
		}
		
		$(document).ready(function () {
			$("#chat_window").bind("scroll", chk_scroll);
			LoadChats();
			refreshRecentChats();
			setInterval(refreshRecentChats, 10000);
		});
		';
		
		if ($Type == 'group') {
			
			echo '
			socket.on("new chat name", function(newName) {
				document.title = "Chat with " + newName + " - Brick Create";
				document.getElementById("chat-name").innerHTML = newName;
			});
			
			';
			
			if ($gCI->Role == 2) {
				
				echo '
				socket.on("new chat image", function(newImage) {
					var location = "'.$cdnName.'" + newImage;
					document.getElementById("edit-group-chat-image").style.backgroundImage = "url(" + location + ")";
					document.getElementById("edit-group-chat-image").style.backgroundSize = "cover";
				});
				';
				
			}
			
			if ($gCI->Role > 0) {
			
				echo '
				function CopyGroupInviteCode() {
					var InviteCode = document.getElementById("invite-code");
					InviteCode.select();
					document.execCommand("Copy");
				}
				
				function RefreshGroupInviteCode() {
					var http = new XMLHttpRequest();
					http.open("POST", "'.$serverName.'/api/chats/group/edit-group", true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					http.onreadystatechange = function() {
						if (http.readyState == 4 && http.status == 200) {
							var res = JSON.parse(http.responseText);
							if (res.status == "ok") {
								document.getElementById("invite-code").value = res.msg;
								document.getElementById("chat-group-form-inline-message").innerHTML = "You have successfully generated a new invite code: <strong>" + res.code + "</strong>";
							} else {
								document.getElementById("chat-group-form-inline-message").innerHTML = res.msg;
							}
						}
					}
					http.send("action=refresh-invite-code&chatGroupId='.$gCI->ID.'");
				}
				
				function ManageMembers(page) {
					if (!page) page = 1;
					var manageMembersHtml = "";
					var lastSearchedUsername = "";
					var kickableMembers = [];
					var searchInput = document.getElementById("manage-members-search").value;
					document.getElementById("manage-members-html").innerHTML = "Loading...";
					
					var http = new XMLHttpRequest();
					var params = "action=get-members&chatGroupId='.$gCI->ID.'&p=" + page;
					if (searchInput && searchInput != lastSearchedUsername) { params += "&username=" + searchInput; lastSearchedUsername = searchInput; }
					http.open("POST", "'.$serverName.'/api/chats/group/manage-members", true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					http.onreadystatechange = function() {
						if (http.readyState == 4 && http.status == 200) {
							var res = JSON.parse(http.responseText);
							if (res.status == "ok") {
								var rows = res.data;
								for (var i = 0; i < rows.length; i++) {
									var row = rows[i];
									if (i > 0) { manageMembersHtml += `<div class="chat-group-manage-members-divider"></div>`; }
									manageMembersHtml += `
									<div class="grid-x grid-margin-x align-middle">
										<div class="shrink cell">
											<div class="chat-group-manage-members-user-thumb" style="background-image:url('.$cdnName . '` + row.avatar + `-thumb.png);background-size:cover;"></div>
										</div>
										<div class="auto cell">
											<span><a href="'.$serverName.'/users/` + row.username + `/" class="chat-group-manage-members-username">` + row.username + `</a></span>
											`;
											if (row.role == 1) {
												manageMembersHtml += `
												<span class="chat-group-manage-members-role-mod">MODERATOR</span>
												`;
											} else if (row.role == 2) {
												manageMembersHtml += `
												<span class="chat-group-manage-members-role-owner">OWNER</span>
												`;
											}
											manageMembersHtml += `
										</div>
										`;
										if (row.role < '.$gCI->Role.') {
											manageMembersHtml += `
											<div class="shrink cell right" title="Click to kick member">
												<i class="material-icons chat-group-manage-members-kick" data-open="KickUser` + row.username + `">close</i>
											</div>
											<div class="reveal item-modal" id="KickUser` + row.username +`" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
												<div class="grid-x grid-margin-x align-middle">
													<div class="auto cell no-margin">
														<div class="modal-title">Kick user</div>
													</div>
													<div class="shrink cell no-margin">
														<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
													</div>
												</div>
												<div class="push-15"></div>
												<p>Are you sure that you wish to kick <strong>` + row.username + `</strong> from the group chat?</p>
												<div class="push-15"></div>
												<div align="center">
													<input type="button" data-close="" data-open="ManageMembersModal" class="button button-grey store-button inline-block" value="Go Back">
													<input type="button" class="button button-red store-button inline-block" value="Kick Member" onclick="KickMember(\'` + row.username + `\')">
												</div>
											</div>
											`;
											kickableMembers.push(row.username);
										}
										manageMembersHtml += `
									</div>
									`;
								}
								if (res.pages > 1) {
									manageMembersHtml += `
									<div class="push-25"></div>
									<ul class="pagination" role="navigation" aria-label="Pagination">
										<li class="pagination-previous`; if (page == 1) { manageMembersHtml += ` disabled">Previous <span class="show-for-sr">page</span>`; } else { manageMembersHtml += `" onclick="ManageMembers(` + (page-1) + `)">Previous <span class="show-for-sr">page</span>`; } manageMembersHtml += `</li>
										`;
										for (var i = Math.max(1, page-5); i <= Math.min(page+5, res.pages); i++) {
											if (i <= res.pages) {
												manageMembersHtml += `<li`; if (page == i) { manageMembersHtml += ` class="current"`; } manageMembersHtml += ` aria-label="Page ` + i +`" onclick="ManageMembers(` + i + `)">` + i + `</li>`;
											}
										}
										manageMembersHtml += `
										<li class="pagination-next`; if (page == res.pages) { manageMembersHtml += ` disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>`; } else { manageMembersHtml += `" onclick="ManageMembers(` + (page+1) + `)">Next <span class="show-for-sr">page</span>`; } manageMembersHtml += `</li>
									</ul>
									`;
								}
								document.getElementById("manage-members-html").innerHTML = manageMembersHtml;
								for (var i = 0; i < kickableMembers.length; i++) {
									$("#KickUser" + kickableMembers[i]).foundation();
								}
							} else {
								document.getElementById("manage-members-html").innerHTML = res.msg;
							}
						}
					}
					http.send(params);
				}
			
				function KickMember(Username) {
					var http = new XMLHttpRequest();
					http.open("POST", "'.$serverName.'/api/chats/group/manage-members", true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.onreadystatechange = function() {
						if (http.readyState == 4 && http.status == 200) {
							socket.emit("kick member", Username);
							$("#KickUser" + Username).foundation("close");
							$("#ManageMembersModal").foundation("open");
							ManageMembers();
						}
					}
					http.send("action=kick-member&chatGroupId='.$gCI->ID.'&username=" + Username);
				}
				';
			
			}
			
			if ($gCI->Role == 2) {
				
				echo '
				function UpdateGroupName() {
					var newName = document.getElementById("edit-group-chat-name").value;
					socket.emit("change chat name", newName, function(data) {
						if (data.status == false) {
							document.getElementById("edit-group-chat-name-success").innerHTML = "";
							document.getElementById("edit-group-chat-name-error").innerHTML = data.msg;
						} else {
							document.getElementById("edit-group-chat-name-error").innerHTML = "";
							document.getElementById("edit-group-chat-name-success").innerHTML = "Your group chat name has been updated.";
						}
					});
				}
				
				var delivery = new Delivery(socket);
				delivery.on("delivery.connect", function(delivery) {
					$("#edit-image-button").click(function(evt) {
						var file = $("#edit-image-file")[0].files[0];
						if (file) {
							delivery.send(file);
							document.getElementById("edit-group-chat-image-success").innerHTML = "Uploading...";
						} else {
							document.getElementById("edit-group-chat-image-error").innerHTML = "Please select an image to upload.";
						}
						evt.preventDefault();
					});
				});
				
				delivery.on("send.success", function(fileUId) {
					document.getElementById("edit-group-chat-image-error").innerHTML = "";
					document.getElementById("edit-group-chat-image-success").innerHTML = "Uploaded.";
				});
				
				socket.on("new chat image error",function(errorMsg) {
					document.getElementById("edit-group-chat-image-success").innerHTML = "";
					document.getElementById("edit-group-chat-image-error").innerHTML = errorMsg;
				});
				';
				
			}
			
		}
		
		if ($myU->VIP > 0) {
			
			echo '
			function CreateGroupChat() {
				var groupChatName = document.getElementById("create-group-chat-name").value;
				socket.emit("create group chat", groupChatName, function(res) {
					if (!res.status) return;
					if (res.status == "fail") {
						document.getElementById("create-group-chat-error").innerHTML = res.msg;
					} else {
						window.location.href = "'.$serverName.'/inbox/group/" + res.chatId;
					}
				});
			}
			';
			
		}
		
		echo '
		</script>
		<div class="grid-x grid-margin-x">
			<div class="small-12 medium-12 large-4 cell">
				<div class="container recent-chats">
					<div class="grid-x grid-margin-x align-middle chats-header">
						<div class="auto cell no-margin">
							<h5>Chats</h5>
						</div>
						';
						if ($myU->VIP > 0) {
							echo '
							<div class="shrink cell right no-margin">
								<button class="button button-green create-group-chat-button" data-open="CreateGroupChatModal">
									<span><i class="material-icons">add</i></span>
									<span>Create Group Chat</span>
								</button>
								<div class="reveal item-modal" id="CreateGroupChatModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
									<div class="grid-x grid-margin-x align-middle">
										<div class="auto cell no-margin">
											<div class="modal-title">Create Group Chat</div>
										</div>
										<div class="shrink cell no-margin">
											<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
										</div>
									</div>
									<div class="push-25"></div>
									<div class="grid-x grid-margin-x align-middle">
										<div class="shrink cell">
											<strong style="line-height:35px;">Name:</strong>
										</div>
										<div class="auto cell">
											<input type="text" class="normal-input" id="create-group-chat-name" style="font-size:14px;padding:7px 20px;" placeholder="Group Chat Name">
											<div class="user-chat-error" id="create-group-chat-error"></div>
										</div>
									</div>
									<div class="push-25"></div>
									<div align="center">
										<input type="button" class="button button-green store-button inline-block" value="Create" onclick="CreateGroupChat()">
										<input type="button" data-close="" class="button button-grey store-button inline-block" value="Go Back">
									</div>
								</div>
							</div>
							';
						} else {
							echo '
							<div class="shrink cell right no-margin">
								<span class="has-tip" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="1" title="Upgrade your account today to create a group chat">
								<button class="button button-green create-group-chat-button" disabled>
									<span><i class="material-icons">add</i></span>
									<span>Create Group Chat</span>
								</button>
								</span>
							</div>
							';
						}
						echo '
					</div>
					<div id="recent-chats"></div>
				</div>
			</div>
			<div class="small-12 medium-12 large-8 cell">
				<div class="error-message" id="error" style="display:none;">You have been disconnected from the chat server. Trying to reconnect...</div>
				<div class="container-header md-padding" style="height:51px;line-height:31px;">
					';
					
					if ($Type == 'user' || $Type == 'notification') {
						
						echo '
						Chat with <strong>'.$gCI->Username.'</strong>
						';
						
					} else if ($Type == 'group') {
						
						echo '
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								Chat with <div id="chat-name" class="chat-name">'.$gCI->Name.'</div> (Group)
							</div>
							<div class="shrink cell no-margin">
								<i class="material-icons chat-group-settings" title="View group chat members" data-open="ViewMembersModal" onclick="ViewMembers()">group</i>
								<div class="reveal item-modal" id="ViewMembersModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
									<div class="grid-x grid-margin-x align-middle">
										<div class="auto cell no-margin">
											<div class="modal-title" id="view-members-title">View Members</div>
										</div>
										<div class="shrink cell no-margin">
											<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
										</div>
									</div>
									<div class="push-15"></div>
									<div id="view-members-html">
										Loading...
									</div>
								</div>
							</div>
							';
							
							if ($gCI->Role > 0) {
							
								echo '
								<div class="shrink cell no-margin right">
									<i class="material-icons chat-group-settings" title="Manage your group chat" data-toggle="dropdown">settings</i>
									<div class="dropdown-pane creator-area-dropdown" id="dropdown" data-dropdown data-hover="true" data-hover-pane="true" style="font-size:14px;">
											<ul>
												<li><a data-open="AddNewMemberModal">Add New Member</a></li>
												<li><a data-open="ManageMembersModal" onclick="ManageMembers()">Manage Members</a></li>
											</ul>
											';
											
											if ($gCI->Role == 2) {
											
												echo '
												<div class="creator-area-dropdown-divider"></div>
												<ul>
													<li><a data-open="EditGroupModal">Edit Group</a></li>
												</ul>
												';
											
											}
										
										echo '
									</div>
									<div class="reveal item-modal" id="AddNewMemberModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
										<div class="grid-x grid-margin-x align-middle">
											<div class="auto cell no-margin">
												<div class="modal-title">Invite Members To Group Chat</div>
											</div>
											<div class="shrink cell no-margin">
												<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
											</div>
										</div>
										<p>To invite a user to your group chat, send them this invite link.</p>
										<p class="text-center" style="font-size:16px;">
											<div class="grid-x grid-margin-x align-middle">
												<div class="auto cell">
													<input type="text" value="'.$serverName.'/inbox/group-invite/'.$gCI->InviteCode.'" id="invite-code" class="normal-input">
												</div>
												<div class="shrink cell right">
													<i class="material-icons chat-group-settings" onclick="RefreshGroupInviteCode()">refresh</i>
												</div>
											</div>
											<div class="grid-x grid-margin-x">
												<div class="chat-group-form-inline-message auto cell" id="chat-group-form-inline-message"></div>
											</div>
										</p>
										<div class="push-15"></div>
										<div align="center">
											<input type="button" class="button button-green store-button inline-block" value="Copy to Clipboard" onclick="CopyGroupInviteCode()">
											<input type="button" data-close="" class="button button-grey store-button inline-block" value="Close">
										</div>
									</div>
									<div class="reveal item-modal" id="ManageMembersModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
										<div class="grid-x grid-margin-x align-middle">
											<div class="auto cell no-margin">
												<div class="modal-title">Manage Members</div>
											</div>
											<div class="shrink cell no-margin">
												<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
											</div>
										</div>
										<div class="push-15"></div>
										<div class="grid-x grid-margin-x align-middle">
											<div class="auto cell">
												<input type="text" class="normal-input" placeholder="Search by Username" id="manage-members-search" style="font-size:14px;">
											</div>
											<div class="shrink cell">
												<input type="button" class="button button-green" value="Search" onclick="ManageMembers()">
											</div>
										</div>
										<div class="push-25"></div>
										<div id="manage-members-html">
											Loading...
										</div>
									</div>
									';
									
									if ($gCI->Role == 2) {
									
										echo '
										<div class="reveal item-modal" id="EditGroupModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
											<div class="grid-x grid-margin-x align-middle">
												<div class="auto cell no-margin">
													<div class="modal-title">Edit Group Chat</div>
												</div>
												<div class="shrink cell no-margin">
													<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
												</div>
											</div>
											<div class="push-25"></div>
											<div class="grid-x grid-margin-x">
												<div class="shrink cell">
													<strong style="line-height:35px;">Name:</strong>
												</div>
												<div class="auto cell">
													<input type="text" class="normal-input" id="edit-group-chat-name" style="font-size:14px;padding:7px 20px;" value="'.$gCI->Name.'">
													<div class="user-chat-error" id="edit-group-chat-name-error"></div>
													<div class="user-chat-success" id="edit-group-chat-name-success"></div>
												</div>
												<div class="shrink cell">
													<input type="button" class="button button-green" value="Update" onclick="UpdateGroupName()">
												</div>
											</div>
											<div class="edit-group-chat-divider"></div>
											<form action="" method="POST" id="update-group-image">
												<div class="grid-x grid-margin-x">
													<div class="shrink cell">
														<strong style="line-height:48px;">Image:</strong>
													</div>
													<div class="shrink cell">
														<div class="edit-group-chat-image" id="edit-group-chat-image" style="'; if (!$gCI->GroupImage) { echo 'background-color:#363740;'; } else { echo 'background-image:url('.$cdnName . $gCI->GroupImage.');background-size:cover;'; } echo '"></div>
													</div>
													<div class="auto cell">
														<input type="file" id="edit-image-file" class="edit-group-chat-image-file">
													<div class="user-chat-error" id="edit-group-chat-image-error"></div>
													<div class="user-chat-success" id="edit-group-chat-image-success"></div>
													</div>
													<div class="shrink cell">
														<input type="button" id="edit-image-button" class="button button-green" value="Update" style="margin-top:6.5px;">
													</div>
												</div>
											</form>
										</div>
										';
									
									}
									
									echo '
								</div>
								';
								
							}
						
						echo '
						</div>
						';
						
					}
					echo '
				</div>
				<div class="container chat-scroll" id="chat_window" onscroll="LoadMoreChats(this)"></div>
				<div class="push-15"></div>
				';
				if ($Type != 'notification' && $CanChat == true) {
					echo '
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="send-chat-input normal-input" id="send-chat-input" onkeypress="sendChat(this, event)" contenteditable="true" autofocus onfocus="this.value = this.value;" placeholder="Type your message..."></div>
						</div>
						<div class="shrink cell no-margin">
							<button class="button button-blue send-chat-button" id="send-chat-button" onclick="sendChat()">Send</button>
						</div>
					</div>
					';
				} else if ($CanChat == false) {
					echo '
					<strong>We\'re sorry, this user\'s privacy settings restricts you from chatting with them.</strong>
					';
				}
				echo '
			</div>
		</div>
		';
	
	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");