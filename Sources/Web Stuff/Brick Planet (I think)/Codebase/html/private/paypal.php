<?php

	function CancelPaypalSubscription($profile_id, $action) {
		$api_request = 'USER=' . urlencode( 'corp_api1.bloxcity.com' )
					.  '&PWD=' . urlencode( '8G557C4FB3KPSUKQ' )
					.  '&SIGNATURE=' . urlencode( 'AFcWxV21C7fd0v3bYYYRCpSSRl31AwLyDg-ePi9vuf3.W8hje2f7JQpq' )
					.  '&VERSION=76.0'
					.  '&METHOD=ManageRecurringPaymentsProfileStatus'
					.  '&PROFILEID=' . urlencode( $profile_id )
					.  '&ACTION=' . urlencode( $action )
					.  '&NOTE=' . urlencode( 'Profile cancelled at store' );
	 
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'https://api-3t.paypal.com/nvp' ); // For live transactions, change to 'https://api-3t.paypal.com/nvp'
		curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
	 
		// Uncomment these to turn off server and peer verification
		// curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		// curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
	 
		// Set the API parameters for this transaction
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_request );
	 
		// Request response from PayPal
		$response = curl_exec( $ch );
	 
		// If no response was received from PayPal there is no point parsing the response
		if( ! $response )
			die( 'Calling PayPal to change_subscription_status failed: ' . curl_error( $ch ) . '(' . curl_errno( $ch ) . ')' );
	 
		curl_close( $ch );
	 
		// An associative array is more usable than a parameter string
		parse_str( $response, $parsed_response );
	 
		return $parsed_response;
	}