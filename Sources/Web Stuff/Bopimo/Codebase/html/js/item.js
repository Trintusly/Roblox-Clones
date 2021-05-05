$(function() {
	$("buy-cust").click(function(){
		console.log($(this).attr("item-id"));
	})
	itemId = $("#item-info").data('item-id');
	globalItemId = itemId;
	$(".buy-button:not(.disabled)").click (function () {
		$.post("/api/shop/buy.php", {id: itemId, token: $("meta[name=token]").attr("content")}, function (data) {
			responce(data, "You have sucessfully bought this item");
		})
	});
	
	if ($("#sellers").length > 0) {
		loadSales(itemId);
	}
	
	$(".fa-heart:not(.disabled)").click(function () {
		toggleFavorite(itemId);
	});

	$("#postComment").click(function () {
		postComment(itemId, $("#body").val());
	});

	$(".fa-list:not(.disabled)").click(function () {
		toggleWishlist(itemId);
	});
	
	$(".bundle-content").on("mouseover", function () {
		$("#image div img").attr('src', $(this).children("img").first().attr('src'));
	})
	
	$("#body").on("input",function () {
		if ($(this).val().length > 250) {
			$("#commentError").html("Comment must be less than 250 characters (" + $(this).val().length + ")");
			$(this).addClass('invalid');
		} else if ($(this).val().length <= 250) {
			$("#commentError").html("");
			$(this).removeClass('invalid');
		}
		canUpload();
	});

	$(".buy-button.disabled").hover(function () {
	
	});
	
	$("#putOnSale").on('click', function () {
		putOnSale(itemId, $('#serials option:selected').val(),$("#onSalePrice").val());
	})
	
	$("#addSerial").click(function () {
		$(".popup-background").addClass('active');
		$("#putOnSalePopup").addClass('active');
	});
	
	$("#update").click(function () {
		editSale($('#editSerial').data('sale-id'), $("#newOnSalePrice").val());
	});
	
	$("#offsale").click(function () {
		offsaleSale($('#editSerial').data('sale-id'));
	});
	
	$("#sellers").on('click', '[data-edit-serial]', function () {
		$("#editSerial").text('#' + $(this).data('edit-serial'));
		$('#editSerial').attr('data-sale-id', $(this).data('edit-id'));
		console.log($(this).data('edit-id'));
		$("#newOnSalePrice").val($(this).data('edit-price'));
		$(".popup-background").addClass('active');
		$("#editOnSale").addClass('active');
		
	});
	
	$(".popup-background").click(function() {
		$(".popup-background").removeClass('active');
		$(".popup").removeClass('active');
	})
	
	$("#sellers").on('click', 'div[data-buy-sale]', function () {
		buySale($(this).data('buy-sale'));
	});
	
	loadComments (itemId);
});

$(".tooltip").tooltipster({
	arrow: false,
	side: "left",
	animation: "fade",
	animationDuration: 150,
	delay: 0,
	functionPosition: function (instance, helper, position) {
		position.coord.left -= 5;

		return position;
	}
});

$(".tooltipster-right").tooltipster({
	arrow: false,
	side: "right",
	animation: "fade",
	animationDuration: 150,
	delay: 0,
	functionPosition: function (instance, helper, position) {
		position.coord.left += 5;

		return position;
	}
});


function toggleFavorite (itemId) {

	favorite = $(".fa-heart").hasClass("active");
	favorites = parseInt($("#favorites").text());
	favoriteAction = (favorite) ? "remove" : "add";
	$.post("/api/shop/favorite.php", { item_id: itemId, action: favoriteAction, token: $("meta[name=token]").attr("content") }, function ( data ) {
		if (data.status == "ok") {
			text = (favorite) ? "unfavorited" : "favorited";
			newFavorites = (favorite) ? favorites - 1 : favorites + 1;
			console.log(newFavorites);
			$("#responce").html("<div class='banner success'>You "+ text +" this item.</div>");
			$(".fa-heart").toggleClass("active");
			$("#favorites").html(newFavorites);
		} else {
			if (data.hasOwnProperty("error")) {
				$("#responce").html("<div class='banner danger'>"+data.error+"</div>");
			} else {
				$("#responce").html("<div class='banner danger'>There was an error with favoriting the item.</div>");
			}
		}
	});

}

function loadSales(itemId) {
	response("/api/shop/getSellers.php?id=" + itemId).success(function (data) {
		console.log(data);
		$("#sellers").html("");
		
		$.each(data.result, function (i, v) {
			isSeller = (v.current_user == v.seller_id) ? true : false;
			if (isSeller) {
			$("#sellers").append("<div style='display:block;'>\
						<div style='margin-bottom:10px;' class='card'>\
							<a style='float:left;' href='https://www.bopimo.com/profile/"+v.seller_id+"'><img style='margin-right: 5px;border-radius: 10px;' src='https://storage.bopimo.com/avatars/"+v.avatar+".png' width='70'></a>\
							<div style='line-height:70px;float:left;'>"+v.username+"</div>\
							<div style='float:right;'>\
								<div style='color: grey;'>Serial #"+v.serial_id+"</div>\
								<div data-buy-sale='"+v.id+"' class=' buy-button' style='margin-bottom: 0;'>"+v.price+" Bopibits</div>\
							</div><div class='hover-edit' data-edit-price='"+v.price+"' data-edit-id='"+v.id+"' data-edit-serial='"+v.serial_id+"' style='line-height:70px;float:right;padding-right:10px;font-size:1.5rem;'><i style='line-height: 70px;' class='far fa-edit'></i></div>\
						</div>\
					</div>");
			} else {
				$("#sellers").append("<div style='display:block;'>\
						<div style='margin-bottom:10px;' class='card'>\
							<a style='float:left;' href='https://www.bopimo.com/profile/"+v.seller_id+"'><img style='margin-right: 5px;border-radius: 10px;' src='https://storage.bopimo.com/avatars/"+v.avatar+".png' width='70'></a>\
							<div style='line-height:70px;float:left;'>"+v.username+"</div>\
							<div style='float:right;'>\
								<div style='color: grey;'>Serial #"+v.serial_id+"</div>\
								<div data-buy-sale='"+v.id+"' class=' buy-button' style='margin-bottom: 0;'>"+v.price+" Bopibits</div>\
							</div>\
						</div>\
					</div>");
			}
		})
		
	}).get();
}

function offsaleSale (saleId) {
	response("/api/shop/editSale.php").success(function (data) {
		location.reload();
	}).fail(function (error) {
		console.log("OFFSALE SALE ERROR: "+ error);
	}).post({id: saleId, price: "100000", offsale: true, token: null});
}

function editSale (saleId, newPrice) {
	response("/api/shop/editSale.php").success(function (data) {
		location.reload();
	}).fail(function (error) {
		console.log("EDIT SALE ERROR: "+ error);
	}).post({id: saleId, price: newPrice, token: null})
}

function putOnSale (itemId, itemSerial, newPrice) {
	response("/api/shop/putOnSale.php").success(function (data) {
		location.reload();
		$(".popup-background").removeClass('active');
		$(".popup").removeClass('active');
	}).fail(function (error) {
		$("#sellers").html("ERROR: " + error);
	}).post({ id: itemId, price: newPrice, serial: itemSerial, token: null });
}

function buySale (itemId) {
	response("/api/shop/buySale.php").success(function (data) {
		location.reload();
	}).fail(function (error) {
		console.log("ERROR: " + error);
	}).post({id: itemId, token: null});
}

function toggleWishlist (itemId) {

	wishlist = $(".fa-list").hasClass("active");
	wishlists = parseInt($("#wishlists").text());
	wishlistAction = (wishlist) ? "remove" : "add";
	$.post("/api/shop/wishlist.php", { item_id: itemId, action: wishlistAction, token: $("meta[name=token]").attr("content") }, function ( data ) {
		if (data.status == "ok") {
			text = (wishlists) ? "removed this item from your wishlist" : "added this item to your wishlist" ;
			newWishlists = (wishlists) ? wishlists - 1 : wishlists + 1;
			$("#responce").html("<div class='banner success'>You "+ text +"</div>");
			$(".fa-list").toggleClass("active");
			$("#wishlists").html(newWishlists);
		} else {
			if (data.hasOwnProperty("error")) {
				$("#responce").html("<div class='banner danger'>"+data.error+"</div>");
			} else {
				$("#responce").html("<div class='banner danger'>There was an error with favoriting the item</div>");
			}
		}
	});

}

function postComment ( itemId, body ) {
	response("/api/shop/postComment.php").success(function ( data ) {
		$("#commentError").html("");
		if ($("#body").hasClass("invalid")) {
			$("#body").removeClass("invalid");
		}
		loadComments(itemId);
	}).fail(function (error) {
		$("#body").addClass("invalid");
		$("#commentError").text(error);
	}).post({itemId: itemId, body: body, token: null});
}

function loadComments (itemId) {
	if (itemId == null) {
		itemId = globalItemId;
	}
	$("#comments").html("");
	response("/api/shop/getComments.php?itemId=" + itemId).success(function ( data ) {
		isAdmin = (data.admin !== null) ? data.admin : false;
		
		$.each(data.data, function ( index, comment ) {
			action = (isAdmin) ? '<span style="color:#8e8e8e;font-size:0.9rem;font-weight:600;" data-delete-comment="'+comment.id+'"><i class="fas fa-trash delete"></i></span>' : "";
			$("#comments").append('<div class="card border">\
			<div class="content">\
				<div class="col-2-12 centered">\
					<a href="/profile/'+comment.user_id+'" style="color:#000;"><img src="https://storage.bopimo.com/avatars/'+comment.avatar+'.png" class="width-100" /><br>'+comment.username+'</a>\
				</div>\
				<div class="col-10-12">\
					<span style="color:#8e8e8e;font-size:0.9rem;font-weight:600;" title="'+comment.posted+' (EST)">'+comment.postedAgo+'</span> '+action+'<br>\
					'+comment.body+'\
				</div>\
			</div>\
		</div>');
		});
	}).fail(function (error) {
			error = (error == "No Results") ? "No Comments" : error;
			$("#comments").html('<div style="color:#8e8e8e;text-align:center;font-weight:600;" >'+error+'</div>');
	}).get();
}

function responce (data, successMessage = "Success!") {
	if (data.status == "ok") {
		$("#responce").html("<div class='banner success'>"+successMessage+"</div>");
	} else {
		if (data.hasOwnProperty("error")) {
			$("#responce").html("<div class='banner danger'>"+data.error+"</div>");
		} else {
			$("#responce").html("<div class='banner danger'>There was an error with buying the item.</div>");
		}
	}
}
