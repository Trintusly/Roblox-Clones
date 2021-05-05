<?php 

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

foreach ($replaceArray as $key => $value) {
	echo '.Replace("'.$value.'", "'.$key.'")';
}

?>