<?php
$pageName = "Users";
require "../site/header.php";
?>
<style>
.cuto {
	overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
</style>
<div class="page-title">
	User Search
</div>
<div class="shop-search">
	<input class="search not-default width-100" type="text" placeholder="Username" value="">
</div>
<div class="search-results">
	<div class="result">
		<span id="total"></span> Total Results on page <span id="page"></span> of <span id="totalPages"></span>
	</div>
</div>
<div id="results">

</div>
<div class="col-1-1" id="pageButtons">
	<button style="float:left;display:inline;width:auto;display:none;" id="previousPage" class="shop-search-button"><i class="fas fa-chevron-left"></i> Previous Page</button>
	<button style="float:right;display:inline;width:auto;display: none;" id="nextPage" class="shop-search-button">Next Page <i class="fas fa-chevron-right"></i></button>
</div>
<script src="/js/userSearch.js?"></script>
<?php
require "../site/footer.php";
?>
