<?php
	/* Session initialization */
	session_id();
	session_start();
	ob_start();

	/* Global Site Variables */
	date_default_timezone_set('America/Chicago');
	header("X-Frame-Options: SAMEORIGIN");
	header("X-XSS-Protection: 1; mode=block");
	header("X-Content-Type-Options: nosniff");
	$serverName = ($_SERVER['HTTP_HOST'] == 'brickcreate.com' || $_SERVER['HTTP_HOST'] == 'www.brickcreate.com' || $_SERVER['HTTP_HOST'] == 'test.brickcreate.com' || $_SERVER['HTTP_HOST'] == 'cdn.brickcreate.com') ? 'https://'.$_SERVER['HTTP_HOST'] : NULL;
	if (!$serverName) { header('Location: https://www.brickcreate.com/'); die; }
	$cdnName = 'https://cdn.brickcreate.com/';
	$adminFolder = 'newadmin';
	$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
	$UserIP = $_SERVER['HTTP_CF_CONNECTING_IP'];
	$CSSFile = ($serverName == 'https://brickcreate.com') ? 'test-style.css' : 'dark-style.css?r=4';
	$JSFile = ($serverName == 'https://brickcreate.com') ? 'main.js' : 'ffc7473dbb6609f5f6251e9a58e7c1af.js?r=3';

	if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http') {
		header("Location: ".$serverName."".$_SERVER['REQUEST_URI']."");
		die;
	}

	if (empty($_SERVER['REMOTE_ADDR']) || empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
		die();
	}

	require_once('db.php');
	require_once('sendemail.php');
	require_once('/var/www/html/storage/uploadAsset.php');
	require_once('memcached.php');
	require_once('paypal.php');

	if (!$cache->get($UserIP.'IPBanned')) {
		$query = $db->prepare("SELECT COUNT(*) FROM UserIPBan WHERE IPAddress = ? AND TimeExpires > ".time()."");
		$query->bindValue(1, $UserIP, PDO::PARAM_STR);
		$query->execute();
		$cache->set($UserIP.'IPBanned', $query->fetchColumn(), 86400);
	}

	if ($cache->get($UserIP.'IPBanned') > 0) {
		die("We're sorry, this IP Address has been banned due to abuse. If you wish to appeal, please contact us at moderation@brickcreate.com.");
	}

	if (!$cache->get('SiteSettings')) {
		$SiteSettings = $db->prepare("SELECT SiteSetting.*, AdminStatistics.* FROM SiteSetting JOIN AdminStatistics ON AdminStatistics.ID = 1 WHERE SiteSetting.ID = 1");
		$SiteSettings->execute();
		$cache->set('SiteSettings', $SiteSettings->fetch(PDO::FETCH_OBJ), 86400);
		$SiteSettings = $cache->get($SiteSettings->fetch(PDO::FETCH_OBJ));
	}

	else {
		$SiteSettings = $cache->get('SiteSettings');
	}

	if ($serverName == 'https://www.brickcreate.com' && $SiteSettings->Maintenance == 1 && !isset($_SESSION['GlobalSecurityToken']) || $serverName == 'https://test.brickcreate.com' && !isset($_SESSION['GlobalSecurityToken'])) {
		if ($_SERVER['SCRIPT_NAME'] != '/we-are-building/index.php') {
			header("Location: ".$serverName."/we-are-building/");
			die;
		}
	}

	if (isset($_SESSION['UserID'])) {
		$AUTH = true;
	}

	else if (!isset($_SESSION['UserID'])) {
		$AUTH = false;
	}

	if (!isset($show_ads)) {
		$show_ads = true;
	}

	if ($AUTH) {

		if (!isset($_SESSION['TimeSessionCreated'])) {
			$_SESSION['TimeSessionCreated'] = time();
		} else if (time() - $_SESSION['TimeSessionCreated'] > 1800) {
			session_regenerate_id(true);
			$_SESSION['TimeSessionCreated'] = time();
		}

		if (isset($_SESSION['Search_RecordNextPage']) && $_SERVER['SCRIPT_NAME'] != '/games/place.php' && $_SERVER['SCRIPT_NAME'] != '/user/profile.php' && $_SERVER['SCRIPT_NAME'] != '/store/item.php' && $_SERVER['SCRIPT_NAME'] != '/groups/view.php') {
			unset($_SESSION['Search_RecordNextPage']);
		}

		if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_renew'] < time()) {
			$code = base64_encode(openssl_random_pseudo_bytes(32));
			$code = str_replace("+", "", $code);
			$_SESSION['csrf_token'] = $code;
			$_SESSION['csrf_renew'] = time() + 259200;
		}

		if ($cache->get($_SESSION['UserID'])) {
			$myU = $cache->get($_SESSION['UserID']);
			$MyUserCacheUpdated = 1;
		}

		else {
			$query = $db->prepare("SELECT User.*, (SELECT UserColor.HexColor FROM UserColor WHERE ID = User.HexHead) AS HexHead, (SELECT UserColor.HexColor FROM UserColor WHERE ID = User.HexLeftArm) AS HexLeftArm, (SELECT UserColor.HexColor FROM UserColor WHERE ID = User.HexTorso) AS HexTorso, (SELECT UserColor.HexColor FROM UserColor WHERE ID = User.HexRightArm) AS HexRightArm, (SELECT UserColor.HexColor FROM UserColor WHERE ID = User.HexLeftLeg) AS HexLeftLeg, (SELECT UserColor.HexColor FROM UserColor WHERE ID = User.HexRightLeg) AS HexRightLeg FROM User WHERE ID = ?");
			$query->bindValue(1, $_SESSION['UserID'], PDO::PARAM_INT);
			$query->execute();
			if ($query->rowCount() > 0) {
				$cache->delete($_SESSION['UserID']);
				$cache->set($_SESSION['UserID'], $query->fetch(PDO::FETCH_OBJ), 15);
				$myU = $cache->get($_SESSION['UserID']);
				$update = $db->prepare("UPDATE User SET TimeLastSeen = ".time()." WHERE ID = ".$myU->ID."");
				$update->execute();
			}

			else {
				$cache->delete($_SESSION['UserID']);
				session_destroy();
				header("Location: ".$serverName."/log-in/");
				die;
			}
		}

		if (!isset($_SESSION['useragent']) || !isset($_SESSION['password'])) {
			$cache->delete($_SESSION['UserID']);
			session_destroy();

			header("Location: ".$serverName."/log-in/");
			die;
		}

		else if ($_SESSION['useragent'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['password'] != $myU->Password) {
			$cache->delete($_SESSION['UserID']);
			session_destroy();

			header("Location: ".$serverName."/log-in/");
			die;
		}

		if ($myU->NextFreeCoinPay < time()) {

			$updateTime = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins + 10, NextFreeCoinPay = ".(time()+86400)." WHERE ID = ".$myU->ID."");
			$updateTime->execute();
			$cache->delete($myU->ID);
		}

		/* Log User IPs*/

		if ($UserIP != $myU->LastIP) {

			$updateIP = $db->prepare("UPDATE User SET LastIP = ? WHERE ID = ".$myU->ID."");
			$updateIP->bindValue(1, $UserIP, PDO::PARAM_STR);
			$updateIP->execute();

			$checkLoggedIP = $db->prepare("SELECT COUNT(*) FROM UserIP WHERE UserID = ".$myU->ID." AND IP = ?");
			$checkLoggedIP->bindValue(1, $UserIP, PDO::PARAM_STR);
			$checkLoggedIP->execute();

			if ($checkLoggedIP->fetchColumn() == 0) {

				$insertLog = $db->prepare("INSERT INTO UserIP (UserID, IP, TimeFirstUse, TimeLastUse) VALUES(".$myU->ID.", ?, UNIX_TIMESTAMP(), UNIX_TIMESTAMP())");
				$insertLog->bindValue(1, $UserIP, PDO::PARAM_STR);
				$insertLog->execute();

				$updateUser = $db->prepare("UPDATE User SET LastIP = ? WHERE ID = ".$myU->ID."");
				$updateUser->bindValue(1, $UserIP, PDO::PARAM_STR);
				$updateUser->execute();

			}

		} else if (isset($MyUserCacheUpdated)) {

			$UpdateUser = $db->prepare("UPDATE UserIP SET TimeLastUse = ".time()." WHERE UserID = ".$myU->ID." AND IP = ?");
			$UpdateUser->bindValue(1, $UserIP, PDO::PARAM_STR);
			$UpdateUser->execute();

		}

		/* End */

		if (is_numeric($myU->Country)) {

			$update = $db->prepare("UPDATE User SET Country = ? WHERE ID = ".$myU->ID."");
			$update->bindValue(1, $_SERVER['HTTP_CF_IPCOUNTRY'], PDO::PARAM_STR);
			$update->execute();

			$_SESSION['NextF5'] = time();

		}

		if ($myU->AccountRestricted > 0 && $_SERVER['SCRIPT_NAME'] != '/user/suspended.php' && $_SERVER['SCRIPT_NAME'] != '/about/terms-of-service/index.php' && $_SERVER['SCRIPT_NAME'] != '/account/logout.php') {
			header("Location: ".$serverName."/user/suspended/");
			die;
		}

		if ($_SERVER['SCRIPT_NAME'] != '/report/index.php' && isset($_SESSION['Report_ReferenceType']) && isset($_SESSION['Report_ReferenceID'])) {
			unset($_SESSION['Report_ReferenceType']);
			unset($_SESSION['Report_ReferenceID']);
		}

	}

	if ($_SERVER['SCRIPT_NAME'] != '/index.php' && !isset($no_header) && !$AUTH && $show_ads == TRUE || $AUTH && $myU->VIP == 0 && $show_ads == TRUE) {
		$DisplayAds = true;
	} else {
		$DisplayAds = false;
	}

	function shortNum($num) {
		if ($num < 999) {
			return $num;
		}
		else if ($num > 999 && $num <= 9999) {
			$new_num = substr($num, 0, 1);
			return $new_num.'K+';
		}
		else if ($num > 9999 && $num <= 99999) {
			$new_num = substr($num, 0, 2);
			return $new_num.'K+';
		}
		else if ($num > 99999 && $num <= 999999) {
			$new_num = substr($num, 0, 3);
			return $new_num.'K+';
		}
		else if ($num > 999999 && $num <= 9999999) {
			$new_num = substr($num, 0, 1);
			return $new_num.'M+';
		}
		else if ($num > 9999999 && $num <= 99999999) {
			$new_num = substr($num, 0, 2);
			return $new_num.'M+';
		}
		else if ($num > 99999999 && $num <= 999999999) {
			$new_num = substr($num, 0, 3);
			return $new_num.'M+';
		}
		else {
			return $num;
		}
	}

	function get_timeago($ptime) {
		$estimate_time = time() - $ptime;

		if($estimate_time < 45) {
			return 'just now';
		}
		$condition = array(
			12 * 30 * 24 * 60 * 60 => 'year',
			30 * 24 * 60 * 60 => 'month',
			24 * 60 * 60 => 'day',
			60 * 60 => 'hour',
			60 => 'min',
			1 => 'sec'
		);
		foreach($condition as $secs => $str) {
				$d = $estimate_time / $secs;
			if($d >= 1) {
				$r = round( $d );
				return '' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
			}
		}
	}

	function get_short_timeago($ptime) {
		$estimate_time = time() - $ptime;

		if($estimate_time < 45) {
			return 'just now';
		}
		$condition = array(
			12 * 30 * 24 * 60 * 60 => 'yr',
			30 * 24 * 60 * 60 => 'month',
			24 * 60 * 60 => 'day',
			60 * 60 => 'hr',
			60 => 'min',
			1 => 'sec'
		);
		foreach($condition as $secs => $str) {
				$d = $estimate_time / $secs;
			if($d >= 1) {
				$r = round( $d );
				return '' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
			}
		}
	}

	function get_timeagoMSG($ptime) {
		$estimate_time = time() - $ptime;

		if($estimate_time < 45) {
			return 'NOW';
		}
		$condition = array(
			12 * 30 * 24 * 60 * 60 => 'YR',
			30 * 24 * 60 * 60 => 'MNTH',
			24 * 60 * 60 => 'D',
			60 * 60 => 'HR',
			60 => 'MIN',
			1 => 'SEC'
		);
		foreach($condition as $secs => $str) {
				$d = $estimate_time / $secs;
			if($d >= 1) {
				$r = round( $d );
				return '' . $r . '' . $str . ( $r > 1 ? '' : '' ) . '';
			}
		}
	}

	function requireLogin() {
		global $AUTH;
		global $serverName;
		if (!$AUTH) {
			$_SESSION['ReturnLocation'] = $_SERVER['REQUEST_URI'];
			header("Location: ".$serverName."/log-in/");
			die;
		}
	}

	function requireVisitor() {
		global $AUTH;
		global $serverName;
		if ($AUTH) {
			header("Location: " . $serverName);
			die;
		}
	}

	function killUserSession() {
		unset($_SESSION['UserID']);
	}

	function updateAvatar($UserID) {

		global $db;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://66.70.181.68:3000/?seriousKey=dAktdYZ2SBABYCmK&userId=' . $UserID);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$callback = curl_exec($ch);
		curl_close($ch);

	}

	function markUpdate($userID) {

		global $db;

		$checkQueue = $db->prepare("SELECT COUNT(*) FROM AvatarUpdateQueue WHERE UserID = ".$userID."");
		$checkQueue->execute();

		if ($checkQueue->fetchColumn() == 0) {

			$insert = $db->prepare("INSERT INTO AvatarUpdateQueue (UserID) VALUES(".$userID.")");
			$insert->execute();

		}

	}

	function markMassUpdate($itemId) {

		global $db;

		$count = $db->prepare("SELECT COUNT(*) FROM UserEquipped JOIN UserInventory ON UserEquipped.InventoryID = UserInventory.ID WHERE UserInventory.ItemID = ".$itemId."");
		$count->execute();

		if ($count->fetchColumn() > 0) {

			$insert = $db->prepare("INSERT INTO AvatarUpdateQueue (UserID) VALUES((SELECT UserEquipped.UserID FROM UserEquipped JOIN UserInventory ON UserEquipped.InventoryID = UserInventory.ID WHERE UserInventory.ItemID = ".$itemId."))");
			$insert->execute();

			$delete = $db->prepare("DELETE FROM UserEquipped JOIN UserInventory ON UserEquipped.InventoryID = UserInventory.ID WHERE UserInventory.ItemID = ".$itemId."");
			$delete->execute();

		}

	}

	function renderPreview($itemid) {
		$saveHash = bin2hex(random_bytes(16));
		$callback = file_get_contents("http://66.70.181.68:3000/?seriousKey=dAktdYZ2SBABYCmK&name=".$saveHash."&itemId=" . $itemid);
		return $saveHash;
	}

	function renderItem($itemId) {
		$callback = file_get_contents("http://66.70.181.68:3000/?seriousKey=dAktdYZ2SBABYCmK&itemId=" . $itemId);
	}

	function renderAsset($itemId, $itemType, $templateLocation, $update) {
		renderItem($itemId);
	}

	function arrayInString( $inArray , $inString ){
	  if( is_array( $inArray ) ){
		foreach( $inArray as $e ){
		  if( strpos( $inString , $e )!==false )
			return true;
		}
		return false;
	  }else{
		return ( strpos( $inString , $inArray )!==false );
	  }
	}

	function sanitizeContent($content) {
		$content = preg_replace('/[^\00-\255]+/u', '', $content);
		$temp_content = str_replace(" ","", $content);
		$temp_content = preg_replace("/[^a-zA-Z]+/", "", $temp_content);

		global $db;

		$whitelist = array('arcanus', 'advertisement', 'basement', 'document', 'skyscraper', 'sexcept', 'endorsement');

		$query = $db->prepare("SELECT GROUP_CONCAT(Word SEPARATOR ';') AS Test FROM ProfanityFilter");
		$query->execute();
		$column = $query->fetchColumn();
		$column = explode(';', $column);

		foreach ($column as $word) {
			$word = rtrim($word, ' ');

			if (strpos(strtolower($temp_content), strtolower($word)) !== FALSE && arrayInString($whitelist, strtolower($temp_content)) == 0) {
				$ast = '';
				for ($i = 0; $i < strlen($word); $i++) {
					$ast = $ast . '*';
				}
				$content = str_ireplace($word, $ast, $content);
			}
		}

		return $content;
	}

	function getAge($then) {
		$then = date('Ymd', strtotime($then));
		$diff = date('Ymd') - $then;
		return substr($diff, 0, -4);
	}

	function safeContent($content) {
		global $db;
		global $myU;
		return sanitizeContent($content);
	}

	function isProfanity($Text) {

	    global $db;
	    global $cache;
	    global $myU;
	    global $UserIP;

	    if (!$cache->get('Site_Filter_BlacklistWords') || !$cache->get('Site_Filter_WhitelistWords')) {

	        $getWords = $db->prepare("SELECT GROUP_CONCAT(Word) FROM ProfanityFilter");
	        $getWords->execute();
	        $Words = $getWords->fetchColumn();
	        $filterArray = explode(',', $Words);
	        $cache->set('Site_Filter_BlacklistWords', $filterArray, 86400);

	        $getWords = $db->prepare("SELECT GROUP_CONCAT(Word) FROM ProfanityWhitelist");
	        $getWords->execute();
	        $Words = $getWords->fetchColumn();
	        $filterArray = explode(',', $Words);
	        $cache->set('Site_Filter_WhitelistWords', $filterArray, 86400);

	    }

	    $BlacklistWords = $cache->get('Site_Filter_BlacklistWords');
	    $WhitelistWords = $cache->get('Site_Filter_WhitelistWords');
	    $WhitelistDomains = array('brickcreate.com', 'youtube.com', 'twitter.com', 't.co', 'google.com', 'discord.gg', 'discordapp.com');

	    $TempContent = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $Text));
	    $TempContent = preg_replace('/\s+/', ' ', $TempContent);
	    $WordsRegex = ('('.implode('|', $BlacklistWords).')');
	    $ViolatingWords = array();
	    $Flag = 0;
	    $DomainOK = 1;

	    foreach ($BlacklistWords as $BlacklistWord) {

	        if ((stripos($TempContent, $BlacklistWord) !== FALSE || stripos($Text, $BlacklistWord) !== FALSE) && (arrayInString($WhitelistWords, $Text) == 0)) {

	            $Flag = 1;
	            array_push($ViolatingWords, $BlacklistWord);

	        }

	    }

	    $DomainContent = $Text;
	    $DomainContent = str_replace(array(' ', '|'), '', $DomainContent);
	    $DomainContent = str_replace(array('dot', '@', '(.)'), '.', $DomainContent);
	    //$DomainContent = preg_replace('/\s+/', ' ', $DomainContent);
	    $DomainsCheck = preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.(aaa|aarp|abarth|abb|abbott|abbvie|abc|able|abogado|abudhabi|ac|academy|accenture|accountant|accountants|aco|active|actor|ad|adac|ads|adult|ae|aeg|aero|aetna|af|afamilycompany|afl|africa|ag|agakhan|agency|ai|aig|aigo|airbus|airforce|airtel|akdn|al|alfaromeo|alibaba|alipay|allfinanz|allstate|ally|alsace|alstom|am|americanexpress|americanfamily|amex|amfam|amica|amsterdam|analytics|android|anquan|anz|ao|aol|apartments|app|apple|aq|aquarelle|ar|arab|aramco|archi|army|arpa|art|arte|as|asda|asia|associates|at|athleta|attorney|au|auction|audi|audible|audio|auspost|author|auto|autos|avianca|aw|aws|ax|axa|az|azure|ba|baby|baidu|banamex|bananarepublic|band|bank|bar|barcelona|barclaycard|barclays|barefoot|bargains|baseball|basketball|bauhaus|bayern|bb|bbc|bbt|bbva|bcg|bcn|bd|be|beats|beauty|beer|bentley|berlin|best|bestbuy|bet|bf|bg|bh|bharti|bi|bible|bid|bike|bing|bingo|bio|biz|bj|black|blackfriday|blanco|blockbuster|blog|bloomberg|blue|bm|bms|bmw|bn|bnl|bnpparibas|bo|boats|boehringer|bofa|bom|bond|boo|book|booking|boots|bosch|bostik|boston|bot|boutique|box|br|bradesco|bridgestone|broadway|broker|brother|brussels|bs|bt|budapest|bugatti|build|builders|business|buy|buzz|bv|bw|by|bz|bzh|ca|cab|cafe|cal|call|calvinklein|cam|camera|camp|cancerresearch|canon|capetown|capital|capitalone|car|caravan|cards|care|career|careers|cars|cartier|casa|case|caseih|cash|casino|cat|catering|catholic|cba|cbn|cbre|cbs|cc|cd|ceb|center|ceo|cern|cf|cfa|cfd|cg|ch|chanel|channel|chase|chat|cheap|chintai|christmas|chrome|chrysler|church|ci|cipriani|circle|cisco|citadel|citi|citic|city|cityeats|ck|cl|claims|cleaning|click|clinic|clinique|clothing|cloud|club|clubmed|cm|cn|co|coach|codes|coffee|college|cologne|com|comcast|commbank|community|company|compare|computer|comsec|condos|construction|consulting|contact|contractors|cooking|cookingchannel|cool|coop|corsica|country|coupon|coupons|courses|cr|credit|creditcard|creditunion|cricket|crown|crs|cruise|cruises|csc|cu|cuisinella|cv|cw|cx|cy|cymru|cyou|cz|dabur|dad|dance|data|date|dating|datsun|day|dclk|dds|de|deal|dealer|deals|degree|delivery|dell|deloitte|delta|democrat|dental|dentist|desi|design|dev|dhl|diamonds|diet|digital|direct|directory|discount|discover|dish|diy|dj|dk|dm|dnp|do|docs|doctor|dodge|dog|doha|domains|dot|download|drive|dtv|dubai|duck|dunlop|duns|dupont|durban|dvag|dvr|dz|earth|eat|ec|eco|edeka|edu|education|ee|eg|email|emerck|energy|engineer|engineering|enterprises|epost|epson|equipment|er|ericsson|erni|es|esq|estate|esurance|et|etisalat|eu|eurovision|eus|events|everbank|exchange|expert|exposed|express|extraspace|fage|fail|fairwinds|faith|family|fan|fans|farm|farmers|fashion|fast|fedex|feedback|ferrari|ferrero|fi|fiat|fidelity|fido|film|final|finance|financial|fire|firestone|firmdale|fish|fishing|fit|fitness|fj|fk|flickr|flights|flir|florist|flowers|fly|fm|fo|foo|food|foodnetwork|football|ford|forex|forsale|forum|foundation|fox|fr|free|fresenius|frl|frogans|frontdoor|frontier|ftr|fujitsu|fujixerox|fun|fund|furniture|futbol|fyi|ga|gal|gallery|gallo|gallup|game|games|gap|garden|gb|gbiz|gd|gdn|ge|gea|gent|genting|george|gf|gg|ggee|gh|gi|gift|gifts|gives|giving|gl|glade|glass|gle|global|globo|gm|gmail|gmbh|gmo|gmx|gn|godaddy|gold|goldpoint|golf|goo|goodhands|goodyear|goog|google|gop|got|gov|gp|gq|gr|grainger|graphics|gratis|green|gripe|grocery|group|gs|gt|gu|guardian|gucci|guge|guide|guitars|guru|gw|gy|hair|hamburg|hangout|haus|hbo|hdfc|hdfcbank|health|healthcare|help|helsinki|here|hermes|hgtv|hiphop|hisamitsu|hitachi|hiv|hk|hkt|hm|hn|hockey|holdings|holiday|homedepot|homegoods|homes|homesense|honda|honeywell|horse|hospital|host|hosting|hot|hoteles|hotels|hotmail|house|how|hr|hsbc|ht|htc|hu|hughes|hyatt|hyundai|ibm|icbc|ice|icu|id|ie|ieee|ifm|ikano|il|im|imamat|imdb|immo|immobilien|in|industries|infiniti|info|ing|ink|institute|insurance|insure|int|intel|international|intuit|investments|io|ipiranga|iq|ir|irish|is|iselect|ismaili|ist|istanbul|itau|itv|iveco|iwc|jaguar|java|jcb|jcp|je|jeep|jetzt|jewelry|jio|jlc|jll|jm|jmp|jnj|jo|jobs|joburg|jot|joy|jp|jpmorgan|jprs|juegos|juniper|kaufen|kddi|ke|kerryhotels|kerrylogistics|kerryproperties|kfh|kg|kh|ki|kia|kim|kinder|kindle|kitchen|kiwi|km|kn|koeln|komatsu|kosher|kp|kpmg|kpn|kr|krd|kred|kuokgroup|kw|ky|kyoto|kz|la|lacaixa|ladbrokes|lamborghini|lamer|lancaster|lancia|lancome|land|landrover|lanxess|lasalle|lat|latino|latrobe|law|lawyer|lb|lc|lds|lease|leclerc|lefrak|legal|lego|lexus|lgbt|li|liaison|lidl|life|lifeinsurance|lifestyle|lighting|like|lilly|limited|limo|lincoln|linde|link|lipsy|live|living|lixil|lk|loan|loans|locker|locus|loft|lol|london|lotte|lotto|love|lpl|lplfinancial|lr|ls|lt|ltd|ltda|lu|lundbeck|lupin|luxe|luxury|lv|ly|ma|macys|madrid|maif|maison|makeup|man|management|mango|map|market|marketing|markets|marriott|marshalls|maserati|mattel|mba|mc|mckinsey|md|me|med|media|meet|melbourne|meme|memorial|men|menu|meo|merckmsd|metlife|mg|mh|miami|microsoft|mil|mini|mint|mit|mitsubishi|mk|ml|mlb|mls|mm|mma|mn|mo|mobi|mobile|mobily|moda|moe|moi|mom|monash|money|monster|mopar|mormon|mortgage|moscow|moto|motorcycles|mov|movie|movistar|mp|mq|mr|ms|msd|mt|mtn|mtr|mu|museum|mutual|mv|mw|mx|my|mz|na|nab|nadex|nagoya|name|nationwide|natura|navy|nba|nc|ne|nec|net|netbank|netflix|network|neustar|new|newholland|news|next|nextdirect|nexus|nf|nfl|ng|ngo|nhk|ni|nico|nike|nikon|ninja|nissan|nissay|nl|no|nokia|northwesternmutual|norton|now|nowruz|nowtv|np|nr|nra|nrw|ntt|nu|nyc|nz|obi|observer|off|office|okinawa|olayan|olayangroup|oldnavy|ollo|om|omega|one|ong|onl|online|onyourside|ooo|open|oracle|orange|org|organic|origins|osaka|otsuka|ott|ovh|pa|page|panasonic|panerai|paris|pars|partners|parts|party|passagens|pay|pccw|pe|pet|pf|pfizer|pg|ph|pharmacy|phd|philips|phone|photo|photography|photos|physio|piaget|pics|pictet|pictures|pid|pin|ping|pink|pioneer|pizza|pk|pl|place|play|playstation|plumbing|plus|pm|pn|pnc|pohl|poker|politie|porn|post|pr|pramerica|praxi|press|prime|pro|prod|productions|prof|progressive|promo|properties|property|protection|pru|prudential|ps|pt|pub|pw|pwc|py|qa|qpon|quebec|quest|qvc|racing|radio|raid|re|read|realestate|realtor|realty|recipes|red|redstone|redumbrella|rehab|reise|reisen|reit|reliance|ren|rent|rentals|repair|report|republican|rest|restaurant|review|reviews|rexroth|rich|richardli|ricoh|rightathome|ril|rio|rip|rmit|ro|rocher|rocks|rodeo|rogers|room|rs|rsvp|ru|rugby|ruhr|run|rw|rwe|ryukyu|sa|saarland|safe|safety|sakura|sale|salon|samsclub|samsung|sandvik|sandvikcoromant|sanofi|sap|sapo|sarl|sas|save|saxo|sb|sbi|sbs|sc|sca|scb|schaeffler|schmidt|scholarships|school|schule|schwarz|science|scjohnson|scor|scot|sd|se|search|seat|secure|security|seek|select|sener|services|ses|seven|sew|sex|sexy|sfr|sg|sh|shangrila|sharp|shaw|shell|shia|shiksha|shoes|shop|shopping|shouji|show|showtime|shriram|si|silk|sina|singles|site|sj|sk|ski|skin|sky|skype|sl|sling|sm|smart|smile|sn|sncf|so|soccer|social|softbank|software|sohu|solar|solutions|song|sony|soy|space|spiegel|spot|spreadbetting|sr|srl|srt|st|stada|staples|star|starhub|statebank|statefarm|statoil|stc|stcgroup|stockholm|storage|store|stream|studio|study|style|su|sucks|supplies|supply|support|surf|surgery|suzuki|sv|swatch|swiftcover|swiss|sx|sy|sydney|symantec|systems|sz|tab|taipei|talk|taobao|target|tatamotors|tatar|tattoo|tax|taxi|tc|tci|td|tdk|team|tech|technology|tel|telecity|telefonica|temasek|tennis|teva|tf|tg|th|thd|theater|theatre|tiaa|tickets|tienda|tiffany|tips|tires|tirol|tj|tjmaxx|tjx|tk|tkmaxx|tl|tm|tmall|tn|to|today|tokyo|tools|top|toray|toshiba|total|tours|town|toyota|toys|tr|trade|trading|training|travel|travelchannel|travelers|travelersinsurance|trust|trv|tt|tube|tui|tunes|tushu|tv|tvs|tw|tz|ua|ubank|ubs|uconnect|ug|uk|unicom|university|uno|uol|ups|us|uy|uz|va|vacations|vana|vanguard|vc|ve|vegas|ventures|verisign|versicherung|vet|vg|vi|viajes|video|vig|viking|villas|vin|vip|virgin|visa|vision|vista|vistaprint|viva|vivo|vlaanderen|vn|vodka|volkswagen|volvo|vote|voting|voto|voyage|vu|vuelos|wales|walmart|walter|wang|wanggou|warman|watch|watches|weather|weatherchannel|webcam|weber|website|wed|wedding|weibo|weir|wf|whoswho|wien|wiki|williamhill|win|windows|wine|winners|wme|wolterskluwer|woodside|work|works|world|wow|ws|wtc|wtf|xbox|xerox|xfinity|xihuan|xin|xperia|xxx|xyz|yachts|yahoo|yamaxun|yandex|ye|yodobashi|yoga|yokohama|youtube|yt|yun|za|zappos|zara|zero|zip|zippo|zm|zone|zuerich|zw)\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $DomainContent, $Match);

	    foreach ($Match[0] as $Domain) {

	        $Domain = str_replace('//', '--', $Domain);
	        if (strpos($Domain, '/') !== false) {
	            $Domain = substr($Domain, 0, strpos($Domain, '/'));
	        }
	        $Domain = str_replace('--', '//', $Domain);

	        foreach ($WhitelistDomains as $WhitelistDomain) {

	            $CheckDomain = substr_compare($Domain, $WhitelistDomain, -strlen($WhitelistDomain)) === 0;

	            if ($CheckDomain == TRUE) {

	                $DomainOK = 1;
	                break;

	            } else {

	                $DomainOK = 0;

	            }

	        }

	        if ($DomainOK == 0) {
	            array_push($ViolatingWords, $Domain);
	        }

	    }

	    if ($DomainOK == 0) {
	        $Flag = 1;
	    }

	    if ($Flag == 1) {

	        $Insert = $db->prepare("INSERT INTO ap.ProfanityFilterLog (UserID, UserIP, TextContent, TimeLog, BadWords) VALUES(".$myU->ID.", '".$UserIP."', ?, ".time().", ?)");
	        $Insert->bindValue(1, $Text, PDO::PARAM_STR);
	        $Insert->bindValue(2, implode('|', $ViolatingWords), PDO::PARAM_STR);
	        $Insert->execute();

	    }

		return $Flag;

	}

	function removeProfanity($content) {

		$temp_content = str_replace(" ","", $content);
		$temp_content = preg_replace("/[^a-zA-Z]+/", "", $temp_content);

		global $db;

		$whitelist = array('arcanus', 'advertisement', 'basement', 'document', 'skyscraper', 'sexcept', 'endorsement');

		$query = $db->prepare("SELECT GROUP_CONCAT(Word SEPARATOR ';') AS Test FROM ProfanityFilter");
		$query->execute();
		$column = $query->fetchColumn();
		$column = explode(';', $column);

		foreach ($column as $word) {
			$word = rtrim($word, ' ');

			if (strpos(strtolower($temp_content), strtolower($word)) !== FALSE && arrayInString($whitelist, strtolower($temp_content)) == 0) {
				$content = preg_replace("/{$word}/i", "", $content);
				$content = preg_replace('/\s+/', ' ', $content);
			}
		}

		return $content;

	}

	function callback($match) {
		$completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";

		return '<a href="' . $completeUrl . '" target="_blank">'
			. $match[2] . $match[3] . $match[4] . '</a>';
	}

	function linkify($string) {

		$rexProtocol = '(https?://)?';
		$rexDomain   = '(www.Brick Create.me|Brick Create.me|jobs.brickcreate.com|helpme.brickcreate.com|www.brickcreate.com|brickcreate.com|blog.brickcreate.com)';
		$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
		$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
		$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';

		return preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&", 'callback', $string);

	}

	function checksumImage($FileName, $NewImageFileName) {
		global $db;

		$MD5 = md5_file($FileName);

		$check = $db->prepare("SELECT FileName, Status FROM AssetChecksum WHERE Hash = '".$MD5."'");
		$check->execute();

		if ($check->rowCount() == 0) {
			$insert = $db->prepare("INSERT INTO AssetChecksum (FileName, Hash, Status, TimeCreated) VALUES(?, ?, 0, ".time().")");
			$insert->bindValue(1, $NewImageFileName, PDO::PARAM_STR);
			$insert->bindValue(2, $MD5, PDO::PARAM_STR);
			$insert->execute();

			return '0';
		}

		else {
			$c = $check->fetch(PDO::FETCH_OBJ);

			return ''.$c->Status.':DIVIDER:'.$c->FileName.'';
		}
	}

	function SendSMSAlert($message) {

		$url = 'https://api.sendgrid.com/';
		$user = 'bloxcity';
		$pass = 'Id4vogj0GTrP8lobnWns';

		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'to'        => '2566043210@txt.att.net',
			'subject'   => 'Alert',
			'text'      => $message,
			'from'      => 'alerts@bloxcity.com',
			'fromname'      => 'BC Alerts',
			 );

			$request =  $url.'api/mail.send.json';

			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($session);
			curl_close($session);

	}

	function ForumBB($text) {
		$find = array(
			'~\[b\](.*?)\[/b\]~s',
			'~\[i\](.*?)\[/i\]~s',
			'~\[u\](.*?)\[/u\]~s'
		);

		$replace = array(
			'<b>$1</b>',
			'<i>$1</i>',
			'<span style="text-decoration:underline;">$1</span>',
			'<pre>$1</'.'pre>',
			'<span style="font-size:$1px;">$2</span>',
			'<span style="color:$1;">$2</span>',
			'<a href="$1">$1</a>',
			'<img src="$1" alt="" />'
		);

		return preg_replace($find,$replace,$text);
	}

	function ResetForumHomeCache() {
		global $db;
		global $cache;

		$getTopics = $db->prepare("SELECT ForumTopic.ID, ForumTopic.Name, ForumTopic.Description, ForumTopic.Posts, ForumTopic.Replies, ForumTopic.LastPostThreadID, ForumTopic.LastPostReplyID, (SELECT GROUP_CONCAT(ForumThread.Title, 'SEX', User.Username, 'SEX', User.Admin, 'SEX', ForumThread.TimeUpdated) FROM ForumThread JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.ID = (CASE WHEN ForumTopic.LastPostReplyID = 1 THEN ForumTopic.LastPostThreadID ELSE (SELECT ThreadID FROM ForumReply WHERE ID = ForumTopic.LastPostReplyID) END)) AS LastPostInfo FROM ForumTopic WHERE ForumTopic.CategoryID = 1 ORDER BY ForumTopic.Sort ASC");
		$getTopics->execute();

		$cache->set('Forum_Topics', $getTopics->fetchAll(PDO::FETCH_OBJ), 120);
	}

	function LimitTextByWords($Text, $Limit) {
		if (str_word_count($Text, 0) > $Limit) {
			$words = str_word_count($Text, 2);
			$pos = array_keys($words);
			$Text = substr($Text, 0, $pos[$Limit]);
			if (substr($Text, -1) == ' ') {
				$Text = substr($Text, 0, -1);
			}
			$Text .= '...';
		}
		return $Text;
	}

	function LimitTextByCharacters($Text, $Limit) {
		if (strlen($Text) > $Limit) {
			$NewText = substr($Text, 0, $Limit);
			if (substr($NewText, -1) == ' ') {
				$NewText = substr($NewText, 0, -1);
			}
			$NewText .= '...';

			return $NewText;
		} else {
			return $Text;
		}
	}

	function generateNewUsername() {
		global $db;

		$Name = substr('Del'.mt_rand(), 0, 15);
		$count = $db->prepare("SELECT COUNT(*) AS CheckOne, (SELECT COUNT(*) FROM UsernameHistory WHERE Username = User.Username) AS CheckTwo FROM User WHERE Username = ?");
		$count->bindValue(1, $Name, PDO::PARAM_STR);
		$count->execute();
		$c = $count->fetch(PDO::FETCH_OBJ);

		if ($c->CheckOne == 0 && $c->CheckTwo == 0) {
			return $Name;
		} else {
			generateNewUsername();
		}
	}

	function generateNewGroupName() {
		global $db;

		$Name = substr('Del'.mt_rand(), 0, 15);
		$count = $db->prepare("SELECT COUNT(*) FROM UserGroup WHERE Name = ?");
		$count->bindValue(1, $Name, PDO::PARAM_STR);
		$count->execute();

		if ($count->fetchColumn() == 0) {
			return $Name;
		} else {
			generateNewGroupName();
		}
	}

	function generateRandomString($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	function redrawUserAvatarByUserInventoryItemId($UserId, $ItemId, $Type = 0) {
		global $db;

		$Query = $db->prepare("INSERT INTO AvatarUpdateQueue (UserId) SELECT UserEquipped.UserID FROM UserEquipped JOIN UserInventory ON UserEquipped.InventoryID = UserInventory.ID JOIN Item ON UserInventory.ItemID = Item.ID WHERE Item.ID = ".$ItemId." AND UserEquipped.UserID = ".$UserId."");
		$Query->execute();

		if ($Type == 0) {
			$Delete = $db->prepare("DELETE UserEquipped FROM UserEquipped JOIN UserInventory ON UserEquipped.InventoryID = UserInventory.ID JOIN Item ON UserInventory.ItemID = Item.ID WHERE Item.ID = ".$ItemId." AND UserEquipped.UserID = ".$UserId."");
			$Delete->execute();
		}
	}

	function redrawUserAvatarByUserInventoryId($InventoryIds, $Type = 0) {
		global $db;

		$Query = $db->prepare("INSERT INTO AvatarUpdateQueue (UserId) SELECT UserEquipped.UserID FROM UserEquipped WHERE UserEquipped.InventoryID IN(".$InventoryIds.")");
		$Query->execute();

		if ($Type == 0) {
			$Delete = $db->prepare("DELETE FROM UserEquipped WHERE UserEquipped.InventoryID IN(".$InventoryIds.")");
			$Delete->execute();
		}
	}

	function generateRandomChatId($UserId) {
		global $db;

		$ChatId = '';
		for($i = 0; $i < 20; $i++) {
			$ChatId .= mt_rand(0, 9);
		}

		$UpdateUser = $db->prepare("UPDATE User SET ChatId = ".$ChatId." WHERE ID = " . $UserId);
		$UpdateUser->execute();
		if ($UpdateUser->rowCount() == 0) {
			generateRandomChatId($UserId);
		} else {
			return true;
		}
	}

	function iso8601($time=false) {
		if ($time === false) $time = time();
		$date = date('Y-m-d\TH:i:sO', $time);
		return (substr($date, 0, strlen($date)-2).':'.substr($date, -2));
	}

	if ($_SERVER['HTTP_HOST'] == 'amazon.brickcreate.com') {
		//echo 'amazon.brickcreate.com';
	}
