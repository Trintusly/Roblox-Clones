<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	$getSold = $db->prepare("SELECT COUNT(*) AS TotalCount FROM Inventory WHERE ItemID = 49765 AND CanTrade = 1");
	$getSold->execute();
	$gS = $getSold->fetch(PDO::FETCH_OBJ);

	$getAverage = $db->prepare("SELECT AVG(Price) AS AveragePrice FROM ItemSalesHistory WHERE ItemID = 49765");
	$getAverage->execute();
	$gA = $getAverage->fetch(PDO::FETCH_OBJ);
	
	$Weight = ((250/($gS->TotalCount)));
	
	$Average = number_format(round(($gA->AveragePrice*$Weight)));
	
	echo $Average;

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");