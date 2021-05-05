<? include "../../header.php"; ?>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<div class="row">
<div class="col s12 m12 l6 center-align">
<div class="bc-content">
<div style="font-size:35px;color:#15BF6B;">15</div>
<div style="color:#999;">cash</div>
</div>
</div>
<div class="col s12 m12 l6 center-align">
<div class="bc-content">
<div style="font-size:35px;color:#F7D358;">100</div>
<div style="color:#999;">coins</div>
</div>
</div>
</div>
<div style="height:25px;"></div>
<center>
<a href="#ConvertCurrencies" class="modal-trigger waves-effect waves-light btn blue">CONVERT CURRENCIES</a>
</center>
<script>
	$(document).ready(function(){
		$(".modal-trigger").leanModal();
		$("select").material_select();
	});
	</script>
<form action="" method="post">
<div id="ConvertCurrencies" class="modal" style="width:500px;">
<div class="modal-content">
<h4>Convert Currencies</h4>
<div class="input-field">
<input type="text" name="CurrencyAmount" id="CurrencyAmount">
<label for="CurrencyAmount">Amount</label>
</div>
<div class="select-wrapper"><span class="caret">▼</span><input type="text" class="select-dropdown" readonly="true" data-activates="select-options-ffc9be8c-9a72-383b-6a88-4306c75a16ff" value="Coins to Cash"><ul id="select-options-ffc9be8c-9a72-383b-6a88-4306c75a16ff" class="dropdown-content select-dropdown "><li class=""><span>Coins to Cash</span></li><li class=""><span>Cash to Coins</span></li></ul><select name="CurrencyType" class="initialized">
<option value="1">Coins to Cash</option>
<option value="2">Cash to Coins</option>
</select></div>
</div>
<div class="modal-footer">
<a href="#!" class="modal-action modal-close waves-effect waves-blue btn-flat">CLOSE</a>
<i class="waves-effect waves-green btn-flat waves-input-wrapper" style=""><input type="submit" name="SubmitCurrency" class="waves-button-input" value="CONVERT"></i>
</div>
</div>
</form>
</div>
</div>
<? include "../../footer.php"; ?>