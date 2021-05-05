$(function () {
	uid = $('[data-user-id]').data('user-id');
	currentPage = 1;
	$('.shop-button[data-category]').click(function () {
		currentPage = 1;
		loadInventory(uid, currentPage, "#inventory", "#pages", $(this).data('category'));
	})
	$('#pages').on("click", ".next", function () {
		currentPage += 1;
		loadInventory(uid, currentPage, "#inventory", "#pages", $(".shop-button.current").data('category'));
	})
	$('#pages').on("click", ".back", function () {
		currentPage -= 1;
		loadInventory(uid, currentPage, "#inventory", "#pages", $(".shop-button.current").data('category'));
	})
	loadInventory(uid, 1, "#inventory", "#pages", "all");
});

function loadInventory(uid,page,target,pageTarget,category = "") {
	$.each($(".shop-buttons").children(),function(){ $(this).removeClass("current") })
	$(".shop-button[data-category="+category+"]").addClass("current");
	response("https://www.bopimo.com/api/shop/inventory.php?page="+page+"&category="+category+"&userId=" + uid + "&perPage=18")
	.success(function (data) {
		$(target).html("");
		count = 1;
		$.each(data.data, function (index, item) {
			noMargin = false;
			if (count == data.data.length) {
				console.log(data.data.length);
				noMargin = true;
			}
			declined = (item.verified == "-1") ? true : false;
			console.log(declined)
			addItem(target, item.id, item.name, item.serial, declined)
			count++
		});
		togglePages(pageTarget, page, data.totalPages)
	}).fail (function (error) {
		$(target).html("<div style='color:grey;font-weight:600;text-align:center;color: #808080;'>" + error + "</div>");
		$(pageTarget).html("");
	})
	.get()
}

function addItem(target, id, name, serial, declined = false) {
	$(target).append('<a href="https://www.bopimo.com/item/'+id+'"><div style="'+((noMargin) ? 'padding-right:20px;' : '')+'" class="col-1-6">\
			<div class="shop-item tradeable "  data-id="'+id+'" data-serial="'+serial+'">\
				<div class="preview">\
					<img src="https://storage.bopimo.com/thumbnails/'+((declined) ? "declined" : id)+'.png">\
				</div>\
				<div class="name" style="padding:5px;text-overflow: ellipsis;">'+name+'</div>\
			</div></a>\
		</div>');
}

function togglePages(target, currentPage, totalPages) {
	if (currentPage == 1 && totalPages == 1) {
		$(target).html("");
	} else if (currentPage == totalPages) {
		//show only back button
		$(target).html('<button style="float: left; width: auto;" class="shop-search-button back"><i class="fas fa-chevron-left"></i></button>');
	} else if (currentPage == 1) {
		//show only the forward button
		$(target).html('<button style="float: right; width: auto;" class="shop-search-button next"><i class="fas fa-chevron-right"></i></button>');
	} else {
		//show both buttons
		$(target).html('<button style="float: left; width: auto;" class="shop-search-button back"><i class="fas fa-chevron-left"></i></button><button style="float: right; width: auto;" class="shop-search-button next"><i class="fas fa-chevron-right"></i></button>');
	}
}
