<?php

	function sendExecutiveEmail($title, $body) {
		$url = 'https://api.sendgrid.com/';
		$user = 'bloxcity';
		$pass = 'Id4vogj0GTrP8lobnWns';

		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'to'        => 'isaac@bloxcity.com',
			'cc'        => 'bpfeif@bloxcity.com',
			'subject'   => $title,
			'html'      => $body,
			'from'      => 'no_reply@bloxcity.com',
			'fromname'      => 'BLOX City',
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
	
	function sendEmail($Email, $Title, $Body) {
		$url = 'https://api.sendgrid.com/';
		$user = 'bloxcity';
		$pass = 'Id4vogj0GTrP8lobnWns';
		
		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'to'        => $Email,
			'subject'   => $Title,
			'html'      => $Body,
			'from'      => 'no_reply@brickcreate.com',
			'fromname'      => 'Brick Create',
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