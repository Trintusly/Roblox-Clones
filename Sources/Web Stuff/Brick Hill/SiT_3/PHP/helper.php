<?php 

	include("../config.php");

	/* Some Check Functions */
	
	function isCurrentUser ($userID) {
		if ($userID == $_SESSION['id']) {
			return true;
		} elseif ($userID !== $_SESSION['id']) {
			return false;
		} else {
			return false;
		}
	}
	

	function loggedIn () {
		if ($_SESSION['id'] > 0) {
			return true;
		} elseif ($_SESSION['id'] == 0) {
			return false;
		}
		
	}
	
	function forceRedir($loc) {
		echo '<script> window.location = "' . $loc . '" </script>';
		header("Location: $loc");
		die();
	}
	
	function lgn() {
		if (loggedIn() == false) {
			forceRedir("/login/");
		}
	}

	function aLvl($userID2, $conn) {
		$userID2 = mysqli_real_escape_string($conn, $userID2); // Juse incase ;)
		$edgyQL = "SELECT * FROM `beta_users` WHERE `id` = '" . $_SESSION['id'] . "' ";
		$gitGudLvl = $conn->query($edgyQL); 
		if($gitGudLvl->num_rows == 0) { return false; } // Function returns false If it can't find user.
		$gitGudSkrub = mysqli_fetch_assoc($gitGudLvl);
		$power = $gitGudSkrub['power'];
		return $power;
	}
	
	function pageAccess($accessLvl, $con) { 
		$cAdminLevel = aLvl($_SESSION['id'], $con);// Current Admin Level
		if ($cAdminLevel == false) { lgn(); }
		switch($acessLvl) { 
			case 0: // Does nothing, It's pointless really.
			break;
			case 1: // Logged In (Anyone if logged in)
				lgn();
			break;
			case 2: // Admin Level of 1 or greator (accessible to any admin)
				lgn();
				if ($cAdminLevel >! 0) {
					forceRedir("/");
				}
			break;
			case 3: // Admin Level > 1 (accessible by all admins except level 1)
				lgn();
				if ($cAdminLevel >! 1) {
					forceRedir("/");
				}
			break;
			case 4: // Admin Level > 2 (only acessible by level 3, 4 , or 5 admins)
				lgn();
				if ($cAdminLevel >! 2) {
					forceRedir("/");
				}
			break;
			case 5: // Admin Level > 3 (only accessible by level 4 || 5 admins)
				lgn();
				if ($cAdminLevel >! 3) {
					forceRedir("/");
				}
			break;
			case 6: // Admin Level > 4 (Only accessible by level 5 admins)
				lgn();
				if ($cAdminLevel >! 4) {
					forceRedir("/");
				}
			break;
		}
		
	}
	
	/* Game Helpers */

		// Outputs game launch string to make games more secure
	
	function gameLaunch ($launchString) {
		
		$replaceArray = array(
		// Numbers
		0 => "SDOCPAP34394L", // 0
		1 => "CNSA43278PDI4", // 1
		2 => "FHB43REW4AS6N", // 2
		3 => "ASD7VFGMHJDFG", // 3
		4 => "NCIRF42423VU4", // 4
		5 => "D940BXXAOER45", // 5
		6 => "52V852J8KV38Y", // 6
		7 => "ASD97DSF523VX", // 7
		8 => "XSDAPFOR94NA3", // 8
		9 => "STYU6GHJ4GDUU7", // 9
		// Symbols
		"-" => "ASDU4G234L3VHJ", // -
		// Letters (lowercase)
		
		"a" => "XA6W77ZKX4DX",
		"b" => "85JM67LHQK65",
		"c" => "Z5RU8XZS34M4",
		"d" => "S8KZEE7M6CZV",
		"e" => "YUHJ266VW7YK",
		"f" => "AJCDY8887SER",
		"g" => "UG9U2KCA762A",
		"h" => "FW6W64QWHYDN",
		"i" => "BW2GHBM5TRMB",
		"j" => "9ATDW583DNKH",
		"k" => "SE8YS2Q92WX8",
		"l" => "P6JVFRC3R2PU",
		"m" => "FH7R6P3NBD6S",
		"n" => "7MBNZB5S9Z3E",
		"o" => "ZJQ8N22TCU6W",
		"p" => "DADG4K98N7VA",
		"q" => "PV2P3FNZFRA2",
		"r" => "ZADKTJGV69UE",
		"s" => "XHEAG2KDBMZE",
		"t" => "NDGMDV6F5DSV",
		"u" => "3YZ5CNDYFXRJ",
		"v" => "G4G5C5WF3ETU",
		"w" => "4NQ74VWZAFK7",
		"x" => "JLGRJ9T5SGUV",
		"y" => "LESGS87NF685",
		"z" => "4DPSNWDQ4XMQ",
		
		// Letters (Uppercase)
		
		"A" => "GK5MHDHSZ7C7",
		"B" => "RRV2E48JDBYB",
		"C" => "TPPT6L8RVT29",
		"D" => "B77RBGLKUJ93",
		"E" => "FSB7LP6956CL",
		"F" => "87H9TE7MFC2R",
		"G" => "FAJV5F8UA7ND",
		"H" => "99Y9BL6R3AQD",
		"I" => "TNGL8HGAXAWQ",
		"J" => "H7SL7CL98D3H",
		"K" => "NM6H6CP3WTU5",
		"L" => "5T2XL5GPT9B4",
		"M" => "RBW6MHQBRP6L",
		"N" => "R3N9TCNVEQ6Q",
		"O" => "5GAQK8GS7WZP",
		"P" => "V6R89BMBHMG4",
		"Q" => "DQ5WHTQ52NKH",
		"R" => "6Y4KLGMG9PEC",
		"S" => "DKUC4Q8GHVKQ",
		"T" => "X464XS96JPRU",
		"U" => "JWQXHK2UF35M",
		"V" => "BFTHE2A6BSPQ",
		"W" => "YWD3AWTAYHVM",
		"X" => "4ASA5KRER9VJ",
		"Y" => "F5LCBCQL3Z85",
		"Z" => "MTZA99FRDE8T"
	);

		
		$result = strtr ($launchString, $replaceArray);
		//return $launchString . " is " . $result;
		return $result;
		
	}
	
	/* Catalog Helpers */
	
		// For hashing item's IDs. Has to be an intiger.
	function shopItemHash ($itemID) {
		
		
		
		$outputID = hash('sha256', $itemID);
		$outputID = substr($outputID, 4, 10);
		$outputID = hash('crc32', $itemID);
		
		if($itemID == 0) {
			$outputID = 0;
		}
		
		return $outputID;
		
	}
	
		// For hashing item's thumbnail. Has to be an intiger.
	function shopItemThumbnailHash ($itemID) {

		$outputID = hash('adler32', $itemID);
		return $outputID;
		
	}

?>