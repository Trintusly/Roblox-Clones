$(function () {

	currentPage = 1;
	globalPerPage = 24;
	$(".search").keypress(function (trigger) {
		if (trigger.which == 13) {
			console.log($(".search").val());
			search($(".search").val(), 1);
		}
	});

	$("#nextPage").click(function () {search(globalQuery, parseInt(currentPage) + 1)});
	$("#previousPage").click(function () {search(globalQuery, parseInt(currentPage) - 1)});


	search("", 1);
});

function pageButtons (currentPage, total, status) {
	if (status == "ok") {
		totalPages = Math.ceil(total/globalPerPage);
		console.log(totalPages);
		console.log(currentPage + "/" + totalPages);
		if (currentPage == 1 && currentPage == totalPages) {
			$("#nextPage").hide();
			$("#previousPage").hide();
		} else if (currentPage == 1) {
			$("#nextPage").show();
			$("#previousPage").hide();
		} else if (currentPage == totalPages) {
			$("#previousPage").show();
			$("#nextPage").hide();
		} else {
			$("#previousPage").show();
			$("#nextPage").show();
		}
		$("#page").html(currentPage);
		$("#totalPages").html(totalPages);
	} else {
		$("#nextPage").hide();
		$("#previousPage").hide();
		$("#page").html("0");
		$("#totalPages").html("0");
	}
	$("#total").html(total);
}

function search (query, page) {
	currentPage = page;
	globalQuery = query;
	response("/api/account/users.php?query=" + query + "&page=" + page).success(function (data) {
		$("#results").html("");
		$.each (data.data, function (index, user) {
			appendUser(user);
		});
		pageButtons(currentPage, data.total, data.status);
	}).fail(function (error) {
		$("#results").html("<div class='centered' style='font-weight:600;color:#888;'>"+error+"</div>");
		pageButtons(currentPage, 0, "error");
	}).get();
}

function appendUser(user) {
	var online;
	console.log(user);
	if(user.currentTime - user.lastseen <= 180)
	{
		online = "<font color='green'>Online</font>";
	} else {
		online = "<font color='red'>Offline</font>";
	}
	$("#results").append('<div class="col-1-4">\
		<div class="card border" style="min-height:82px;">\
			<a href="/profile/'+user.id+'" style="color: #000;">\
			<div class="col-4-12">\
				<img src="https://storage.bopimo.com/heads/'+user.headshot+'.png" style="border-radius:100px;" class="width-100" />\
			</div>\
			<div class="col-8-12">\
				<div style="font-size:1.4rem;" class="cuto">\
					'+user.username+'\
				</div>\
				<div class="cuto">\
					'+user.bio+' \
				</div>\
				<div class="cuto">\
					'+online+' \
				</div>\
			</div>\
			</a>\
		</div>\
	</div>')
}
