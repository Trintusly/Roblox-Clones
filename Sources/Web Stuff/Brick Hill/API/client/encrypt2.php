<?php 
	/* 
	Ludova's URI Break Down
	
	ludova://5-3
	   | 	 | |			
	   |	 | |   
	   |	 |	User ID							
	   |	Place ID					
	   URI						
	
	After Encryption
	ludova://4aNz-AxkzZ
	
	*/
	header("Contact-Type: application/json");
	$string = "4-4";
	$num_array = array (
		1,
		2,
		3,
		4,
		5,
		6,
		7,
		8,
		9,
		0,
		//"-"
	);
	
	
$num0 = array (
	"X4X2U452SAH",
	"D5L4B678XMD",
	"S2B0P873PQU",
	"M9P9L865DUC",
	"Q2F2D115CWU",
	"F9J1R773OEG",
	"E1T9T215KTU",
	"Q0V7D380CCY",
	"N2P2Y981FZG",
	"A9A2C678KIX"
);
$num1 = array (
	"G1A5D161ADJ",
	"R4H6G482SWF",
	"T1I3X272DDJ",
	"F5J3G534XAX",
	"F6D6O434RCP",
	"A5M2H743CRY",
	"N9E0J694ODC",
	"T8R1F183TWW",
	"G1E0P512MRG",
	"S7Q3S099EST"
);
$num2 = array (
	"X8Z0T376FAT",
	"L0J9F649XES",
	"N5K6M382BSC",
	"C7W4N475FDQ",
	"Q1X2Q818NRJ",
	"Z3X3C148FNO",
	"C9B5R688HLZ",
	"F7P0X465VPX",
	"S9D8J809KDX",
	"N7P2N450KTS"
);
$num3 = array (
	"B8P4L230CDD",
	"E8K0X340GDT",
	"W2H3S374AVH",
	"R3T9P806WEM",
	"H2J6R496FUW",
	"O1P8X197KQA",
	"F5R0O397UEZ",
	"F8Q6U386FKT",
	"W3Q9G339LOL",
	"D6@4M827ULO"
);
$num4 = array (
	"L1I7D904RWT",
	"J8D7F928JIK",
	"K7Y2A605ELQ",
	"O2R5G121WOD",
	"X3F8O029LPS",
	"K8T0V322ZVN",
	"Q3V7O961DNN",
	"G3B2O971RDD",
	"M1W7L172RJQ",
	"N1F5T453YTR"
);
$num5 = array (
	"A0F0U479KED",
	"H9P4R910NQE",
	"U1Z1R214YCM",
	"E1H5W200KGA",
	"A7S9V844DFQ",
	"Z4I2N726HKV",
	"P0S8A833VIA",
	"P2W3T340DJL",
	"I6D1X643NDJ",
	"G9K0E795UMV"
);
$num6 = array (
	"S8P0G606BJI",
	"C5G7Y639ZPX",
	"K6C1O690NRY",
	"D7E7U882EZT",
	"M7R1B617PNI",
	"S6Y4R993XBB",
	"D8X9S126WSK",
	"O8N2X284POC",
	"O0V5Y140GOW",
	"E5O2U214SSH"
);
$num7 = array (
	"G9F4V614VQK",
	"Q2I8R302GGV",
	"W5Q1S184LBJ",
	"R5E3R613DVO",
	"J6F7S409IXN",
	"Z0G1X659AFO",
	"G5G8U686EFF",
	"L0Z9A929NGD",
	"U3X4X951MTT",
	"U6N4M167JBS"
);
$num8 = array (
	"J0U3H785TQY",
	"R1W5P004TWD",
	"H2N4X280ZDD",
	"T5I5I920XZB",
	"U5S7Q155DVU",
	"R2S9B792TRT",
	"C1C0L194FSZ",
	"Z5Q0A129YYD",
	"Q8G3U504GEQ",
	"K2B5E579NSK"
);
$num9 = array (
	"E8M2B320OWX",
	"V2R3G164UAS",
	"X5X4H890FCV",
	"S4Y0Q965WMS",
	"O8D7M455EJC",
	"C8K9U419HVI",
	"G9Z2P401EPZ",
	"F3M7V092DDA",
	"P9W0B839CQW",
	"D8M6X685PBV"
);
$numD = array (
	"U1H4A198JBM",
	"V3Q2R524QRA",
	"I0U9X800GVE",
	"P2G7D112QDP",
	"I2G8L641SVC",
	"O7A4W177IHZ",
	"P0C7F442DTL",
	"H5Y9A078FGR",
	"G7O3K277FIU",
	"K1A7O383UBX"
);
	
	/*shuffle ($num1);
	shuffle ($num2);
	shuffle ($num3);
	shuffle ($num4);
	shuffle ($num5);
	shuffle ($num6);
	shuffle ($num7);
	shuffle ($num8);
	shuffle ($num9);
	shuffle ($num0);
	shuffle ($numD);
	
	$num1 = $num1[0];
	$num2 = $num2[0];
	$num3 = $num3[0];
	$num4 = $num4[0];
	$num5 = $num5[0];
	$num6 = $num6[0];
	$num7 = $num7[0];
	$num8 = $num8[0];
	$num9 = $num9[0];
	$num0 = $num0[0];
	$numD = $numD[0];*/
	
	$encryptedArray = array($num1, $num2, $num3, $num4, $num5, $num6, $num7, $num8, $num9, $num0, $numD);
	$encrypted = str_replace($num_array, $encryptedArray, $string)	;
	//$encrypted = strrev($encrypted);
	//echo "brickhill:".$encrypted;
	
	for ($a = 0; $a < 10; $a++)  {
		
		foreach ($num_array as $targetvalue) {
			//echo '.Replace( "'.$okArray[$targetvalue].'", "'.$targetvalue.'" )';
			$okArray = '$num'.$targetvalue;
			foreach ($okArray as $potatoV) {
				echo $potatoV;
			}
		}
	}
?>