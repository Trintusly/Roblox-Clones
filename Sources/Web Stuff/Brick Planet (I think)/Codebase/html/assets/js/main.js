
var dropdown_open = 0;
var emoji_dropdown_open = 0;
var emojis_loaded = 0;
var fetchedNotifications = 0;
var csrfToken = document.getElementById("csrf_token").value;

$(document).ready(function($){
    $(document).foundation();
	fetchUnreadUserNotifications();
	
	var dropdownOpen = 0;
	
	window.onclick = function(event) {
		if (event.target.matches ? event.target.matches('#menu-search') : event.target.msMatchesSelector("#menu-search")) {
			if (document.getElementById("search-dropdown").style.display == "none") {
				$('#search-dropdown').foundation('toggle', 'off');
			}
		}
		
		if (document.getElementById("user-dropdown-all").style.display != "none") {
			if (event.target.matches ? !event.target.matches('#user-dropdown-all, #user-dropdown-all *, .menu-avatar-preview-thumbnail') : !event.target.msMatchesSelector("#user-dropdown-all, #user-dropdown-all *, .menu-avatar-preview-thumbnail")) {
				$('#user-dropdown-all').foundation('toggle', 'off');
			}
		}
		
		if (document.getElementById("user-notifications").style.display != "none") {
			if (event.target.matches ? !event.target.matches('#user-notifications, #user-notifications *') : !event.target.msMatchesSelector("#user-notifications, #user-notifications *")) {
				$('#user-notifications').foundation('toggle', 'off');
			}
		}
		
		if (document.getElementById("EmojiDropdown") ? document.getElementById("EmojiDropdown").style.display != "none" : 1 == 2) {
			if (event.target.matches ? !event.target.matches('#EmojiDropdown, #EmojiDropdown *') : !event.target.msMatchesSelector("#EmojiDropdown, #EmojiDropdown *")) {
				$('#EmojiDropdown').foundation('toggle', 'off');
			}
		}
		
		if (document.getElementById("search-dropdown").style.display != "none") {
			if (event.target.matches ? !event.target.matches('#search-dropdown, #search-dropdown *, #menu-search') : !event.target.msMatchesSelector("#search-dropdown, #search-dropdown *, #menu-search")) {
				$('#search-dropdown').foundation('toggle', 'off');
			}
		}
	}

});

function searchSite(query) {
	if (query.length >= 3 && query != " ") {
		document.getElementById("show-recent").style.display = "none";
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "https://www.brickcreate.com/search/fetch/" + query, true);
		xhr.onload = function (e) {
		  if (xhr.readyState === 4) {
			if (xhr.status === 200) {
				if (xhr.responseText != '<div class="search-dropdown-title">QUICK RESULTS</div><ul><div class="search-dropdown-error">No results found.</div></ul>') {
					document.getElementById('search-dropdown-content').innerHTML = xhr.responseText;
				}
			}
		  }
		};
		xhr.send(null);
	} else if (!query || query.length < 3 || query == " ") {
		document.getElementById("search-dropdown-content").innerHTML = "";
		document.getElementById("show-recent").style.display = "block";
	}
}

function openNotification(Id, url) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "https://test.brickcreate.com/inbox/view-notification/" + Id, true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onload = function (e) {
		if (xhr.readyState === 4) {
			if (xhr.status === 200) {
				window.location.assign(url);
			}
		}
	};
	xhr.send("csrf_token=" + csrfToken);
}

function fetchUnreadUserNotifications() {
	var splitTitle = document.title.split(') ');
	var originalTitle = (!splitTitle[1]) ? document.title : splitTitle[1];
	var newTitle;
	var newHtml = "";
	var unreadNotifications = document.getElementById("notifications-count").innerHTML;
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "https://test.brickcreate.com/api/user/get-unread-notifications", true);
	xhr.onload = function (e) {
		if (xhr.readyState === 4) {
			if (xhr.status === 200) {
				var json = xhr.responseText;
				if (!JSON.parse(json)) return;
				json = JSON.parse(json);
				if (json.status == "error") return;
				if (json.status == "ok") {
					setTimeout(fetchUnreadUserNotifications, 15000);
					if (json.unreadNotificationsCount == 0 && fetchedNotifications) {
						document.getElementById("notifications-count").style.display = "none";
						document.getElementById("notifications-count").innerHTML = 0;
						document.getElementById("user-notifications-html").innerHTML = `
						<div class="user-notifications-none">
							<i class="material-icons">notifications_none</i>
							<span>You have no unread notifications.</span>
						</div>
						`;
						document.title = originalTitle;
						return;
					}
					if (json.unreadNotificationsCount != 0 && (unreadNotifications != json.unreadNotificationsCount || !fetchedNotifications)) {
						document.getElementById("notifications-count").style.display = "block";
						document.getElementById("notifications-count").innerHTML = json.unreadNotificationsCount;
						newTitle = "(" + json.unreadNotificationsCount + ") " + originalTitle;
						document.title = newTitle;
					}
					for (var i = 0; i < json.content.length; i++) {
						var row = json.content[i];
						if (i > 0) { newHtml += `<div class="user-chat-row-divider"></div>`; }
						newHtml += `
						<div class="notification-row" onclick="openNotification(` + row.notificationId + `, \'` + row.notificationUrl + `\')">
							<div class="grid-x grid-margin-x align-middle">
								<div class="shrink cell">
									<div class="notifications-user-thumbnail-48 relative" style="background-image:url(` + row.senderAvatar + `);background-size:cover;">
										`;
										if (row.senderTimeLastSeen) {
											newHtml += `<div class="notifications-user-activity-status" style="background:#` + row.senderTimeLastSeen + `;" title="` + row.senderUsername + ` is online"></div>`;
										}
										newHtml += `
									</div>
								</div>
								<div class="auto cell">
									<span><a href="https://test.brickcreate.com/users/` + row.senderUsername + `/"><strong>` + row.senderUsername + `</strong></a></span>
									<span>&nbsp;&bullet;&nbsp;</span>
									<span class="chats-row-time">` + row.notificationTime + `</span>
									<div class="chats-row-snippet">
										<strong>` + row.notificationMessage + `</strong>
									</div>
								</div>
							</div>
						</div>
						`;
						if ((i + 1) == json.content.length && document.getElementById("user-notifications-html").innerHTML != newHtml) {
							document.getElementById("user-notifications-html").innerHTML = newHtml;
						}
					}
					fetchedNotifications = 1;
				}
			}
		}
	};
	xhr.send(null);
}