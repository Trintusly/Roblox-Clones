<? include "Header.php"; ?>
<div class="row">
<div class="col-md-8">
<h1>Your Character</h1>
<? echo "<img src='https://www.mine2build.eu/GetCharacter2D?ID=";echo"$myU->ID";echo"'>"; ?>
</div>
<div class="col-md-1">
<h2>Outfits</h2>
<? 
$Outfits = mysql_query("SELECT * FROM Outfits WHERE UserID='$myU->ID' ORDER BY ID");
?>
</div>
</div>
<? include "Footer.php"; ?>