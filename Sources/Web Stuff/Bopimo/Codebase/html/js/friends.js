$(function () {
	getFriends("pending");
	$("#getPending").click(function () {
		getFriends("pending"); 
	});
	$("#getFriends").click(function () {
		getFriends(false) 
	});
	$("#getSent").click(function () {
		getFriends("sent") 
	});
	$(".tab-container .tab").click(function () {
		loadTab($(this));
	});
	
	$("#friendsHolder").on("click", ".button", function () {
		response("/api/friends/friendRequest.php").success(function (data) {
			$(".tab.current").click();
			$("#response").html("<div class='banner success'>Success</div>");
		}).fail(function (error) {
			$("#response").html("<div class='banner danger'>"+error+"</div>");
		}).post({action: $(this).data("action"),userId: $(this).data("user-id"), token: null});
	});
});

function acceptFriendRequest (userId) {
	
}

function declineFriendRequest (userId) {
	$(".tab.current").click();
}

function getFriends (additional) {
	url = "/api/friends/getFriends.php";
	url += (additional) ? "?"+additional : ""
	response(url).success(function ( data ) {
		$("#friendsHolder").html("");
		$.each (data.data, function (index, request) {
			appendFriendRequest(request, additional);
		})
	}).fail(function (error) {
		$("#friendsHolder").html("<div class='centered' style='color:#888888;font-weight:600;'>"+error+"</div>");
	}).get();
}


function appendFriendRequest (fr, additional) {
	
	buttons = "";
	
	if (additional == "pending") {
		buttons = '<div class="col-1-2">\
			<div class="button success" data-action="accept" data-user-id="'+fr.user.id+'">\
				Accept\
			</div>\
		</div><div class="col-1-2">\
			<div class="button danger" data-action="cancel" data-user-id="'+fr.user.id+'">\
				Decline\
			</div>\
		</div>';
	}
	
	if (additional == "sent") {
		buttons = '<div class="col-1-1 centered">\
			<span class="button warning" data-action="cancel" data-user-id="'+fr.user.id+'">\
				Cancel\
			</span>\
		</div>';
	}
	
	if (!additional) {
		buttons = '<div class="col-1-1 centered">\
			<span class="button danger" data-action="remove" data-user-id="'+fr.user.id+'">\
				Remove\
			</span>\
		</div>';
	}
	
	$("#friendsHolder").append('<div class="col-1-5">\
		<div class="centered">\
			<a style="color:000" href="/profile/'+fr.user.id+'">\
			<img src="https://storage.bopimo.com/avatars/'+fr.user.avatar+'.png" style="width:100%;">\
			<br>\
			'+fr.user.username+'</a>\
		</div>\
		'+buttons+'\
	</div>');
}

function loadTab ( tab ) {
	$(".tab-container .current").removeClass("current");
	$(tab).addClass("current");
}