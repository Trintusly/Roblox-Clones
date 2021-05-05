$(function() {
	
	var globalCategory, globalQuery, globalSort, globalPage;
	globalPerPage = $("#perPage:selected").val();
	
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
	
	$(".item-container").on('mouseover','.bundle-preview img', function () {
		$(this).parent().children('img.active').removeClass('active');
		$(this).addClass('active');
		$(this).parent().parent().children('img').attr('src', $(this).attr('src'));
	});
	
	$(".shop-button[data-category]").click(function (){load($(this).data('category'), $(".shop-search input").val())})
	$(".shop-search-button[data-sort]").click(function() { load($(".shop-button.current").data('category'), $(".shop-search input").val(), $(this).data('sort'))});
	
	$("input.not-default").keypress(function ( trigger ) {
		if (trigger.which == 13) {

			load($(".shop-button.current").data('category'), $(".shop-search input").val())
		}
	})
	$("#perPage").change(function () {
			load($(".shop-button.current").data('category'), $(".shop-search input").val())
	})
	$("#showApproved").change(function () {
			load($(".shop-button.current").data('category'), $(".shop-search input").val())
	})
	
	function load ( category = "all", query, sort = "", page = 1, musket ) {
		urlParams = { category: category, query: query, sort: sort, page: page }
		globalCategory = category;
		globalQuery = query;
		globalSort = sort;
		globalPage = page;
		showApproved = 0;
		perPage = globalPerPage 
		$.each($(".shop-buttons").children(),function(){ $(this).removeClass("current") })
		$(".shop-button[data-category="+category+"]").addClass("current");

		if ($(".shop-search .advanced").css("display") !== "none") {
			console.log("advanced");
			$("#page").val(page); 
			if ($("#page").val().length > 0) {
				page = $("#page").val()
			}
			console.log($("#perPage").val());
			if ($("#perPage").val().length > 0) {
				perPage = $("#perPage").val();
				globalPerPage = perPage
			}
			showApproved = $("#showApproved").val();
			console.log(perPage);
			url = "https://www.bopimo.com/api/shop/items.php?query=" + query + "&category=" + category + "&sort=" + sort + "&creator=" + $("#creator").val() + "&min=" + $("#min").val() + "&max=" + $("#max").val() + "&page=" + page + "&perPage=" + perPage + "&showVerified=" + showApproved
			window.history.pushState(null, null, "/shop/?query=" + query + "&category=" + category + "&sort=" + sort + "&creator=" + $("#creator").val() + "&min=" + $("#min").val() + "&max=" + $("#max").val() + "&page=" + page + "&perPage=" + perPage + "&showVerified=" + showApproved);
		} else {
			globalPerPage = 12
			console.log("normal");
			extra = ""
			if (musket) {
				extra = "threeMusketeers"
			}
			url = "https://www.bopimo.com/api/shop/items.php?query=" + query + "&category=" + category + "&sort=" + sort + "&page=" + page + "&perPage=" + perPage + "&" + extra
			window.history.pushState(null, null, '/shop/?' + $.param(urlParams));
		}
		
		$.get(url, function (data) {
			$(".item-container").html("");
			if (data.status == "ok") {
				count = 1
				$.each(data.result, function () {
					css = ((count != 0 && count % 4 === 0 ) || count == data.total) ? "no-margin" : "";
					appendItem(this, css);
					count++;
				})
			} else {
				$(".item-container").append('<div style="text-align:center;font-size:1rem;color:#000;">No Results</div>');
			}
			searchResults(category, query, sort, data, page);
			pageButtons(data.page, data.total, data.status);
		})
		
	}
	
	$("#nextPage").click(function () {page(parseInt(globalPage) + 1)});
	$("#previousPage").click(function () {page(parseInt(globalPage) - 1)});
	
	function page (page) {
		load(globalCategory,globalQuery,globalSort,page);
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
	
	function searchResults (category, query, sort, data, page) {
		
			queryStatement = (query.length !== 0) ? 'for "'+query+'" ' : "";
			categoryStatement = (category.length !== 0) ? "in the " + $(".shop-button.current").html().toLowerCase() + " category": "";
			sortStatement = (sort.length !== 0) ? "ordered by " + sort : "";
			
			
		if (data.status == "ok") {
			result = (data.total == 1) ? " result " : " total results ";
			$(".search-results .result").text("Showing " + data.result.length + " out of " + data.total + result + queryStatement + categoryStatement + sortStatement + " on page " + data.page + " of " + Math.ceil(data.total/globalPerPage));
		} else {
			$(".search-results .result").text("Showing 0 out of 0 results " + queryStatement + categoryStatement + sortStatement + " on page " + page + " of 1");
		}
	}
	
	function appendItem ( data, className ) {
		thumbnail = (data.verified == 1) ? data.image : (data.verified == 0) ? "awaiting256" : "declined"
		saleClass = (data.tradeable == "1") ? "tradable" : (data.sale_type == "1") ? "offsale" : (data.price == 0) ? "free" : ""
		price = (data.tradeable == "1") ? data.price : (data.sale_type == "1") ? "Offsale" : (data.price == 0) ? "Free" : "B " + data.price
		bundlePreview = "";
		if (data.category == "7" ) {
			bundlePreview = "<div class='bundle-preview'>";
			bpcount = 1;
			$.each(data.items, function (i, item) {
				bundlePreview += "<img class='"+((bpcount == 1) ? "active" : "")+"' src='https://storage.bopimo.com/thumbnails/"+item.item_id+".png' />";
				bpcount++;
			});
			
			bundlePreview += "</div>";
		}
		
		$(".item-container").append('<div class="shop-item-container '+className+'">\
				<div class="shop-item">\
					<div class="preview">\
						<img src="https://storage.bopimo.com/thumbnails/'+thumbnail+'.png" />\
						'+bundlePreview+'\
					</div>\
					<div class="info">\
						<div class="name">'+data.name+'</div>\
						<div class="buy"><div class="price '+saleClass+'">'+price+'</div><a href="/item/'+data.id+'" class="button '+saleClass+'">View</a></div>\
						<a  href="/profile/'+data.creator+'" class="creator">'+data.username+'</a>\
					</div>\
				</div>\
			</div>');
	}
	
	$(".cog-hover").click(function () {
		$(".shop-search .advanced").toggle(function () { $(".shop-search .advanced").css("max-height", "0px");$(".cog-hover").addClass("rotate"); }, function () { $(".shop-search .advanced").css("max-height", "auto");$(".cog-hover").removeClass("rotate"); });
	})
	
	//function load ( category = "all", query, sort = "", page = 1 ) {
	ds = defaultSearch;
	if (ds.category == "all" && ds.query == "" && ds.sort == "") {
		load("all", "", "", "", ds.page);
	} else {
		load(ds.category, ds.query, ds.sort, ds.page);
	}
	
});