$(function() {
	loading()
	loadAvatar();
	loadTab($(".tab-container .tab:first-child"));

	$(".tab-container .tab").click(function () {
		loadTab($(this));
	});
	
	$(".tab-container .tab").click(function () {  })

	$("#customColor").change(function () {
		// change colr
	});

	$(".tab[data-category]").click(function () {
		loadInventory($(this).data("category"));

	});

	$('.tooltip').tooltipster({
		theme: "disabled",
		contentCloning: true,
		animationDuration: 0,
		time: 0,
		delay: 0,
		arrow: false,
		trigger: 'click',
		interactive: true,
		side: 'left'
	});
	
	activeLimb = "head";
	
	$("[part]").click(function () {
		activeLimb = $(this).attr("part");
		console.log(activeLimb);
	})
	
	$("body").on("input", "#customColor", function () {
		hex = $(this).val()
		hex = (hex.includes("#")) ? hex.replace("#","") : hex
		isHex = /^[0-9A-F]{6}$/i.test(hex);
		console.log(isHex);
		if (!isHex) {
			$(this).css("border-color", "red")
		} else {
			$(this).css("background-color", "#" + hex)
			$(this).css("border-color", "#" + hex)
			color = tinycolor("#" + hex).isLight() ? "000" : "fff"
			$(this).css("color", color)
		}
	})
	
	$("body").on("keydown", "#customColor", function (e) {
		if (e.which == 13) {
			hex = $(this).val()
			hex = (hex.includes("#")) ? hex.replace("#","") : hex
			isHex = /^[0-9A-F]{6}$/i.test(hex);
			if (isHex) {
				changeColor(activeLimb, hex)
			}
		}
	})
	
	$("body").on("click","[color]", function () {
		console.log($(this).attr("color"));
		changeColor(activeLimb, $(this).attr("color"));
	});
	
	$("#content-3").on('click', '.button[data-action]', function () {
		equip($(this).data("itemid"),$(this).data("action"));
	});

	$("#wearing").on('click', '.item-img[data-action]', function () {
		equip($(this).data("itemid"),$(this).data("action"));
	});

	loadInventory(1);
	currentlyWearing();

	$(".itemTooltip").tooltipster({
		arrow: false,
		side: "right",
		animation: "fade",
		animationDuration: 150,
		delay: 0,
		functionPosition: function (instance, helper, position) {
			position.coord.right += 5;

			return position;
		}
	});
});

function loading() {
	$("#avr").html("<div style='text-align:center;'><img src='https://www.bopimo.com/css/loading.gif' /></div>");
}

function loadAvatar () {
	response("/api/account/avatar.php")
		.success((data) => {
			console.log(data);
			$("#avr").html("<img src='https://storage.bopimo.com/avatars/"+data.avatar+".png' style='width:100%;' />");
			$("#limbs").css('height',$("#avatar-container").css('height'));
		}).get();
}

function equip (itemId,action) {
	loading()
	response("/api/avatar/equip.php")
		.success(() => {
			loadInventory($(".tab.current").data("category"));
			loadAvatar();
			currentlyWearing ();
		})
		.fail (() => {

		}).post({item: itemId, action: action, token: null});
}

function initTooltipster () {
	$(".itemTooltip").tooltipster({
	arrow: false,
		side: "right",
		animation: "fade",
		animationDuration: 150,
		delay: 0,
		functionPosition: function (instance, helper, position) {
			position.coord.right += 5;

			return position;
		}
	});
}

function currentlyWearing () {
	response("/api/avatar/currentlyWearing.php")
		.success((data) => {
			$.each( data.data, function (item, value) {
				if (value.hasOwnProperty("id")) {
					$("#" + value.elm + " .item-img").css('background-image', "url('https://storage.bopimo.com/thumbnails/" + value.id + ".png')");
					$("#" + value.elm + " .item-img").attr("data-itemid", value.id);
					$("#" + value.elm + " .item-img").attr("data-action", "remove");
					$("#" + item + " .item-img img").addClass("x");
				} else {
					if ($("#" + item).length) {
						$("#" + item + " .item-img").css('background-image', "url('https://storage.bopimo.com/thumbnails/1.png')");
						if ($("#" + item + ".item-img img".length)) {
							$("#" + item + " .item-img img").removeClass("x");
						}
					}
				}
			});
			//initTooltipster ();
		}).get();
}

function loadInventory( category ) {
	response("/api/avatar/inventory.php?category=" + category + "&notWearing")
		.success((data) => {
			$("#content-3").html("");
			$.each(data.data, (index, item) => {
				$("#content-3").append('<div class="col-1-6"><div class="shop-item"><a href="/item/'+item.item_id+'"><div class="preview"><img src="https://storage.bopimo.com/thumbnails/'+item.item_id+'.png"></div><div class="name" style="padding:5px;text-overflow: ellipsis;">'+item.name+'</div></a><div style="text-align:center;margin-bottom:10px;"><span class="button success" data-action="equip" data-itemId="'+item.item_id+'">Wear</span></div></div></div>');
			});
			$("#content-3").append('<div class="col-1-6"></div>');
		})
		.fail((error) => {
			$("#content-3").html("<div style='font-weight:600;color:#a7a7a7;text-align:center;'>"+error+"</div>");
		}).get();
}

function changeColor (limb, hex) {
	loading()
	$("[part="+limb+"]").css("background-color", "#" + hex);
	response("/api/avatar/changeColor.php").success(function (data) {
		loadAvatar();
	}).fail (function (error) {
		console.log(error);
	}).post({ limb: activeLimb, hex: hex});
}

function loadTab ( tab ) {
	$(".tab-container .current").removeClass("current");
	$(tab).addClass("current");
}
