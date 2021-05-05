<?php

/*
require 'site/bopimo.php';
require 'gamer.php';

$operatingSystems = [];

$string = "Mozilla/5.0 (iPod touch; CPU iPhone OS 12_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.1.1 Mobile/15E148 Safari/604.1";
$logins = $bop->query("SELECT user_agent FROM login ORDER BY id ASC ", [], TRUE);

foreach ($logins as $userAgent) {
	$userAgent = $userAgent["user_agent"];
	$parser = new parseUserAgentStringClass();
	$parser->parseUserAgentString($userAgent);
	
	if (strpos($parser->osname, 'iOS') !== FALSE) {
		$parser->osname = "iOS";
	}
	if (strpos($parser->osname, 'Android') !== FALSE) {
		$parser->osname = "Android";
	}
	if (strpos($parser->osname, 'Mac OSX') !== FALSE) {
		$parser->osname = "Mac";
	}
	
	if(!key_exists($parser->type, $operatingSystems)) {
		$operatingSystems[$parser->type] = "0";
	}
	
	$operatingSystems[$parser->type] += 1;
	echo $parser->osname . "<br>";
}
asort($operatingSystems);
var_dump($operatingSystems);
