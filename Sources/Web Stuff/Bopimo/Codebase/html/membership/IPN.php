<?php namespace Listener;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('/var/www/html/site/bopimo.php');
require('/var/www/html/api/rest.php');
require('paypal.php');
use PaypalIPN;
// Use the sandbox endpoint during testing.
try {
	$ipn = new PaypalIPN();
	$ipn->useSandbox();
	$verified = $ipn->verifyIPN();
	if ($verified) {
		header("HTTP/1.1 200 OK");
		/*
		 * Process IPN
		 * A list of variables is available here:
		 * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
		 */
	}
} catch (\Exception $e) {
	header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error", true, 500);
	$rest->error($e->getMessage());
}
