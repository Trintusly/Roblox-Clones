<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->loggedIn())
{
  require("/var/www/html/error/404.php");
  die();
}
$localUser = $bop->local_info();

if($localUser->admin == 0)
{
  require("/var/www/html/error/404.php");
  die();
}

require("/var/www/html/site/header.php");
?>

<div class="content">
  <div class="col-1-1">
      <div class="page-title">Admin Panel</div>
  </div>
  <div class="col-2-12">
    <div class="shop-button current" active="true" req="Home">Home</div>
    <div class="shop-button" req="Pending">Pending</div>
    <div class="shop-button" req="CommunityPending">Community Pending</div>
    <?php
    if($bop->isAllowed($localUser->id, 3)) {
      ?>
      <div class="shop-button" req="Logs">Logs</div>
      <?php
    }
    if($bop->isAllowed($localUser->id, 1)) {
    ?>
      <div class="shop-button" req="Punish">Punish</div>
      <?php
    }
    ?>
  </div>
  <div class="col-10-12">
    <div class="card b create">
      <div class="top"><span id="title">Home</span></div>
    </div>
    <span id="content"></span>
  </div>
</div>

<script>
globalPage = 1;
globalPerPage = 10;


$(document).ready(function(){
	$("#content").on('change', '.logs #type', function () {
		affectedIdName($.trim($("#type option:selected").text()));
	});
	$("#content").on('change', '.logs select', function () {
		thing(1);
	});
	$("#content").on ('keypress', '.logs input', function (trigger) {
		if (trigger.which == 13) {
			thing(1);
		}
	});

	$("#content").on('click', '#giftItem', function () {
		giftItem($('#giftUserId').val(), $('#giftItemId').val())
	})
	
	$("#content").on('click', '#nextPage',function () {page(globalPage + 1)});
	$("#content").on('click', '#previousPage', function () {page(globalPage - 1)});


	$(".shop-button").click(function(){
		if($(this).attr("active") != "true")
		{

			$(".current").removeAttr("active");
			$(".current").removeClass("current");
			$(this).addClass("current");
			$(this).attr("active", "true");
			$("#title").html($(this).attr("req"));

			if ($(this).attr("req") == "Pending") {
				loadAssets();
			} else if ($(this).attr("req") == "Logs") {
				$("#content").load("logs.php");
				thing(1);
			} else {
			var lower = $(this).attr("req").toLowerCase();
			console.log(lower);
			$("#content").load(lower+".php");
			}
		}
	});



	$("#content").on('click', '.button[data-id]', function () {
		action = ($(this).hasClass("success")) ? "approve" : "decline";
		judgeItem($(this).data("id"), action);
	});

	$("#content").load("home.php");

});

function judgeItem (itemId, actionD) {
	console.log(itemId + " " + actionD);
	$.post("/api/admin/pending.php", {item_id: itemId, action: actionD, token: $("meta[name=token]").attr("content")}, function (data) {
		if (data.status == "ok") {
			loadAssets();
		} else {
			$("#content").html("<div class='banner danger centered'>"+data.error+"</div>");
		}
	});
}

function affectedIdName( type ) {
	if (type == "Any") {
		name = "Affected ID";
	} else {
		name = type+" ID";
	}
	$("#affectedId").attr("placeholder", name);
}

function loadAssets() {
	$.get("https://www.bopimo.com/api/shop/items.php?query=&category=all&sort=&creator=&min=&max=&page=1&perPage=12&showVerified=2", function (data) {
		if (data.status == "ok") {
			$("#content").html("");
			$.each(data.result, function (index,item) {
				console.log(item)
				$("#content").append("<div class='col-1-2'><div class='card border'><div class='col-1-1 centered'><div class='col-1-2'><img src='https://storage.bopimo.com/thumbnails/"+item.id+".png' style='width:100%;'/></div><div class='col-1-2'><img src='https://storage.bopimo.com/assets/"+item.categoryName+"/"+item.id+".png' style='width:80%;'/></div</div></div></div><div>"+item.name+"</div><div class='col-1-1'><div class='col-1-2'><div style='display:block;' class='button success centered' data-id='"+item.id+"'>Approve</div></div><div class='col-1-2'><div class='button danger centered' style='display:block;' data-id='"+item.id+"'>Decline</div></div></div></div></div>");
			});
		} else {
			$("#content").html("<div class='banner danger centered'>"+data.error+"</div>");
		}
	});
}

function page (page) {
	globalPage = page;
	thing(page);
}

function giftItem(user_id, item_id) {
	response("/api/admin/gift.php").post({userId: user_id, itemId: item_id, token: null})
}


function pageButtons (currentPage, total, status) {
	if (status == "ok") {
		totalPages = Math.ceil(total/globalPerPage)
		console.log(globalPage + "/" + totalPages);
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
	} else {
		$("#nextPage").hide();
		$("#previousPage").hide();
	}
}

function thing (page) {
	paramObject = { action: $("#action").val(), type: $("#type").val(), affectedId: $("#affectedId").val(), username: $("#username").val(), page: page };
	params = $.param(paramObject);
	$(".log.results").html("");
	$.get("/api/admin/logs.php?" + params , function (data) {
		if (data.status == "ok") {
			$.each(data.result, function ( index, log ) {
				$(".log.results").append("<div class='card border'><a href='/profile/"+log.user+"' style='text-decoration:none;color:#000;'>"+log.username+"</a> "+log.msg+" "+log.type+" " + log.affected + " </div>");
			});
		} else {
			$(".log.results").html("<div class='banner danger centered'>"+data.error+"</div>");
		}
		pageButtons(globalPage, data.total, data.status);
	});
}
</script>
<script src="/admin/js/punish.js?<?=time()?>"></script>
<?php $bop->footer(); ?>
