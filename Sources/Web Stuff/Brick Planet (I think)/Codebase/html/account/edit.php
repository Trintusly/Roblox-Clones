<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	$countries = array
	(
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
	
	echo '<script src="/API/settings/js/twoStep.js?i='.time().'"></script>';
	
	if (isset($_POST['save_new_username']) && !empty($_POST['new_username']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
		
		if ($myU->CurrencyCoins < 2500) {
			
			$errorMessage = 'You need at least 2,500 Bits to change your username.';
			
		} else if ($myU->Username == $_POST['new_username']) {
				
			$errorMessage = 'Your new username must be different than your old username.';
			
		} else if (strlen($_POST['new_username']) < 3 || strlen($_POST['new_username']) > 20 || !preg_match('/^[A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $_POST['new_username'])) {
			
			$errorMessage = 'Invalid username. A username can only have 3-20 alphanumeric characters.';
			
		} else if (isProfanity($_POST['new_username']) == 1) {
			
			$errorMessage = 'This username has triggered our profanity filter. Please correct and try again.';
		
		} else {
		
			// TODO: Consolidate queries into a (stored procedure/mega query)
		
			$CountUsernameHistory = $db->prepare("SELECT COUNT(*) FROM UsernameHistory WHERE UserID != ".$myU->ID." AND Username = ?");
			$CountUsernameHistory->bindValue(1, $_POST['new_username'], PDO::PARAM_STR);
			$CountUsernameHistory->execute();
			$CountUsernameHistory = $CountUsernameHistory->fetchColumn();
			
			$CountUsernameBlocked = $db->prepare("SELECT COUNT(*) FROM BlockedUsername WHERE Username = ?");
			$CountUsernameBlocked->bindValue(1, $_POST['new_username'], PDO::PARAM_STR);
			$CountUsernameBlocked->execute();
			$CountUsernameBlocked = $CountUsernameBlocked->fetchColumn();
			
			$CountUsername = $db->prepare("SELECT COUNT(*) FROM User WHERE Username = ?");
			$CountUsername->bindValue(1, $_POST['new_username'], PDO::PARAM_STR);
			$CountUsername->execute();
			$CountUsername = $CountUsername->fetchColumn();
			
			/*
			Old DB
			*/
			
			$CountOldUsername = $db->prepare("SELECT COUNT(*) FROM bloxcity.Users WHERE Username = ?");
			$CountOldUsername->bindValue(1, $_POST['new_username'], PDO::PARAM_STR);
			$CountOldUsername->execute();
			$CountOldUsername = $CountOldUsername->fetchColumn();
			
			if ($CountUsernameHistory > 0 || $CountUsernameBlocked > 0 || $CountUsername > 0) {
				
				$errorMessage = 'This username is not available.';
				
			} else {
				
				$Update = $db->prepare("UPDATE User SET Username = ?, CurrencyCoins = CurrencyCoins - 2500 WHERE ID = ".$myU->ID."");
				$Update->bindValue(1, $_POST['new_username'], PDO::PARAM_STR);
				$Update->execute();
				
				if ($Update->rowCount() > 0) {
					
					$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
					$InsertUserActionLog->bindValue(1, 'Changed their account username from \''.$myU->Username.'\' to \''.$_POST['new_username'].'\'', PDO::PARAM_STR);
					$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
					$InsertUserActionLog->execute();
				
					if ($myU->DiscordId > 0) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, 'http://discordapi.brickcreate.com/modify-user-vip?userId='.$myU->DiscordId.'&action=change-nickname&newNickname=' . $_POST['new_username']);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$result = curl_exec($ch);
						curl_close($ch);
					}
					
					$cache->delete($myU->ID);
					$cache->delete($myU->Username.'_Profile');
				
				}
				
				header("Location: ".$serverName."/account/settings/");
				die;
				
			}
		
		}
		
	}
	
	if (isset($_POST['save_new_email']) && !empty($_POST['new_email']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
		
		$domain_name = substr(strrchr($_POST['new_email'], "@"), 1);
		
		$checkEmail = $db->prepare("SELECT COUNT(*) FROM EmailBlacklist WHERE Email = ?");
		$checkEmail->bindValue(1, $domain_name, PDO::PARAM_STR);
		$checkEmail->execute();
		
		$checkEmailBlocked = $db->prepare("SELECT COUNT(*) FROM BlockedEmail WHERE Email = ?");
		$checkEmailBlocked->bindValue(1, $_POST['new_email'], PDO::PARAM_STR);
		$checkEmailBlocked->execute();
		
		if ($checkEmail->fetchColumn() > 0 || $checkEmailBlocked->fetchColumn() > 0) {
			
			$errorMessage = 'Sorry, the new email you have chosen cannot be used. Please try another.';
			
		} else {
		
			if ($_POST['new_email'] == $myU->Email) {
				
				$errorMessage = 'Your new email address must be different than your old email address.';
				
			} if ($_POST['current_email'] != $myU->Email) {
				
				$errorMessage = 'Your current email does not match the one associated with your account. Please try again.';
				
			} else if (!filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL)) {
				
				$errorMessage = 'Invalid email format, please try again.';
				
			} else if ($myU->NextEmailChange > time()) {
				
				$errorMessage = 'Please wait before changing your email address again.';
				
			} else {
				
				$Count = $db->prepare("SELECT COUNT(*) FROM User WHERE Email = ? AND AccountVerified = 1");
				$Count->bindValue(1, $_POST['new_email'], PDO::PARAM_STR);
				$Count->execute();
				$CountUser = $Count->fetchColumn();
				
				$Count = $db->prepare("SELECT COUNT(*) FROM UserEmailChange WHERE OldEmail = ? AND OldWasVerified = 1 AND Changed = 1");
				$Count->bindValue(1, $_POST['new_email'], PDO::PARAM_STR);
				$Count->execute();
				$CountChange = $Count->fetchColumn();
				
				if ($CountUser > 1 || $CountChange > 3) {
					
					$errorMessage = 'This email is already associated with another user account and cannot be used.';
					
				} else {
					
					$key = generateRandomString(20);
					
					$Delete = $db->prepare("DELETE FROM UserEmailChange WHERE UserID = ".$myU->ID." AND Changed = 0");
					$Delete->execute();
					
					$Insert = $db->prepare("INSERT INTO UserEmailChange (UserID, OldEmail, NewEmail, OldWasVerified, ChangeKey, TimeChange) VALUES(".$myU->ID.", '".$myU->Email."', ?, ".$myU->AccountVerified.", '".$key."', ".time().")");
					$Insert->bindValue(1, $_POST['new_email'], PDO::PARAM_STR);
					$Insert->execute();
					
					$Update = $db->prepare("UPDATE User SET NextEmailChange = ".(time()+3600)." WHERE ID = ".$myU->ID."");
					$Update->execute();
					
					$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
					$InsertUserActionLog->bindValue(1, 'Requested to change their account email from \''.$myU->Email.'\' to \''.$_POST['new_email'].'\'', PDO::PARAM_STR);
					$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
					$InsertUserActionLog->execute();
					
					$message = '
					<html>
						<head>
							<style>
								@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600,700");
								.email-body {
									width: 575px;
									height: 100%;
									background: #F1F1F1;
									margin: 0 auto;
									font-family: "Open Sans", sans-serif;
								}
								.bp-email-header {
									width: 100%;
									padding: 15px 0;
								}
								
								.bp-email-image {
									background:url(https://cdn.bp.com/web/01_logo_site_main.png) no-repeat;
									background-size: 154px 20px;
									width: 154px;
									height: 20px;
									margin: 0 auto;
									margin-top: 15px;
									margin-bottom: 15px;
								}
								
								.bp-container {
									width: 525px;
									padding: 25px;
									background: #FFFFFF;
									border: 1px solid #CCCCCC;
									border-radius: 2px;
								}
								
								.bp-header {
									font-size: 24px;
									padding-bottom:5px;
								}
								
								.bp-text, .bp-table td {
									font-size: 14px;
									color: #444;
								}
								
								.bp-text b {
									font-size: 18px;
								}
								
								.bp-text a {
									color: #039be5;
									text-decoration: none;
								}
								
								.bp-text a:hover {
									text-decoration: underline;
								}
								
								.bp-footer {
									font-size: 12px;
									color: #999;
									padding-top: 5px;
									text-align: center;
								}
								
								b, strong {
									font-weight: 500 !important;
								}
								
								.reset-button {
									color: white;
									font-size: 16px;
									background: #2196F3;
									border-radius: 3px;
									padding: 5px 50px;
									text-decoration: none;
									text-align: center;
									display:inline-block;
								}
								
								.reset-button a {
									color: white;
									text-decoration: none;
								}
							</style>
						</head>
						<body class="email-body">
							<div class="bp-email-header">
								<div class="bp-email-image"></div>
							</div>
							<div class="bp-container">
								<div class="bp-header">Verify Email Request</div>
								<div class="bp-text">'.$myU->Username.', we have received a request to change your email address. Please proceed by following the instructions below.</div>
								<div style="height:10px;"></div>
								<div class="bp-text">Please click the button below to proceed with changing your email. The link will expire in 6 hours.</div>
								<div style="height:15px;"></div>
								<center><div class="reset-button"><a href="'.$serverName.'/account/verify?action=change_email&code='.$key.'">Verify Email</a></div></center>
								<div style="height:15px;"></div>
								<div class="bp-text">If you did not initiate this email change request, simply disregard this email. Alternatively, if you believe someone may be trying to gain unauthorized access to your account, please contact us at <a href="mailto:hello@brickcreate.com">hello@brickcreate.com</a>.</div>
								<div style="height:10px;"></div>
								<div class="bp-text">We send you email notifications regarding account actions for your security. If you would like to stop receiving these email notifications, you may toggle them in your <a href="'.$serverName.'/account/settings/" target="_blank">account settings</a>.</div>
								<div style="height:10px;"></div>
								<div class="bp-text" style="color:#999;">	&ndash; Your friends at Brick Create</div>
							</div>
							<div class="bp-footer">
								&copy; Brick Create. &bullet; Made with love in Huntsville, Alabama
							</div>
						</body>
					</html>
					';
					
					$url = 'https://api.sendgrid.com/';
					$user = 'bloxcity';
					$pass = 'Id4vogj0GTrP8lobnWns';
					
					$params = array(
						'api_user'  => $user,
						'api_key'   => $pass,
						'to'        => $_POST['new_email'],
						'subject'   => 'Change your email at Brick Create',
						'html'      => $message,
						'from'      => 'noreply@brickcreate.com',
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
					
					$successMessage = 'An email has been successfully dispatched to your inbox. Please follow the instructions to complete the process.';
					
				}
				
			}
			
		}
		
	}
	
	if (isset($_POST['settings_save'])) {
		
		$successArray = array();
		$BirthdateChanged = 0;
		$Gender = ($_POST['gender'] != 0 && $_POST['gender'] != 1 && $_POST['gender'] != 2) ? $myU->Gender : $_POST['gender'];
		$Avatar = ($_POST['avatar'] != 0 && $_POST['avatar'] != 1) ? $myU->Avatar : $_POST['avatar'];
		$BirthdateMonth = (!is_numeric($_POST['birthdate_month']) || ($_POST['birthdate_month'] < 1 || $_POST['birthdate_month'] > 12)) ? $myU->BirthdateMonth : $_POST['birthdate_month'];
		$BirthdateDay = (!is_numeric($_POST['birthdate_day']) || ($_POST['birthdate_day'] < 1 || $_POST['birthdate_day'] > 31)) ? $myU->BirthdateDay : $_POST['birthdate_day'];
		$BirthdateYear = (!is_numeric($_POST['birthdate_year']) || ($_POST['birthdate_year'] > date('Y') || $_POST['birthdate_year'] < (date('Y')-100))) ? $myU->BirthdateYear : $_POST['birthdate_year'];
		$Country = (!array_key_exists($_POST['country'], $countries)) ? $myU->Country : $_POST['country'];
		$Blurb = htmlentities(strip_tags($_POST['blurb']));
		
		if ($Gender != $myU->Gender) {
			
			$Update = $db->prepare("UPDATE User SET Gender = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $Gender, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Changed their account gender', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->Gender = $Gender;
			array_push($successArray, 'You have successfully changed your account gender choice.');
			
		}
		
		if ($Avatar != $myU->Avatar) {
			
			$Update = $db->prepare("UPDATE User SET Avatar = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $Avatar, PDO::PARAM_INT);
			$Update->execute();
			
			$Update = $db->prepare("INSERT INTO AvatarUpdateQueue (UserID) VALUES(".$myU->ID.")");
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Changed their account avatar gender choice', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->Avatar = $Avatar;
			array_push($successArray, 'You have successfully changed your account avatar choice, your avatar will be refreshed within the next minute.');
			
		}
		
		if ($BirthdateMonth != $myU->BirthdateMonth) {
			
			$Update = $db->prepare("UPDATE User SET BirthdateMonth = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $BirthdateMonth, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Changed their account birthdate month', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->BirthdateMonth = $BirthdateMonth;
			$BirthdateChanged = 1;
			
		}
		
		if ($BirthdateDay != $myU->BirthdateDay) {
			
			$Update = $db->prepare("UPDATE User SET BirthdateDay = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $BirthdateDay, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Changed their account birthdate day', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->BirthdateDay = $BirthdateDay;
			$BirthdateChanged = 1;
			
		}
		
		if ($BirthdateYear != $myU->BirthdateYear) {
			
			$Update = $db->prepare("UPDATE User SET BirthdateYear = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $BirthdateYear, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Changed their account birthdate year', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->BirthdateYear = $BirthdateYear;
			$BirthdateChanged = 1;
			
		}
		
		if ($BirthdateChanged == 1) {
			
			array_push($successArray, 'You have successfully changed your account birthdate.');
			
		}
		
		if ($Country != $myU->Country) {
			
			$Update = $db->prepare("UPDATE User SET Country = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $Country, PDO::PARAM_STR);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Changed their account country', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->Country = $Country;
			array_push($successArray, 'You have successfully changed your account country.');
			
		}
		
		if ($Blurb != $myU->About) {
			
			if (isProfanity($Blurb) == 1) {
				
				$errorMessage = 'One or more words in your blurb has triggered our profanity filter. Please correct and try again.';
				
			} else {
			
				$Update = $db->prepare("UPDATE User SET About = ? WHERE ID = ".$myU->ID."");
				$Update->bindValue(1, $Blurb, PDO::PARAM_STR);
				$Update->execute();
				
				$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
				$InsertUserActionLog->bindValue(1, 'Changed their account about section/blurb', PDO::PARAM_STR);
				$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
				$InsertUserActionLog->execute();
				
				$cache->delete($myU->ID);
				$cache->delete($myU->Username.'_Profile');
				$myU->About = $Blurb;
				array_push($successArray, 'You have successfully changed your account blurb.');
			
			}
			
		}
		
	}
	
	if (isset($_POST['privacy_save'])) {
		
		$successArray = array();
		$CountryRestrict = (!isset($_POST['country_restrict'])) ? 0 : 1;
		$EmailNotifications = (!isset($_POST['email_notifications'])) ? 0 : 1;
		
		$MessagesPrivacy = ($_POST['messages_privacy'] != 0 && $_POST['messages_privacy'] != 1 && $_POST['messages_privacy'] != 2) ? $myU->PrivateMessageSettings : $_POST['messages_privacy'];
		$FriendsPrivacy = ($_POST['friends_privacy'] != 0 && $_POST['friends_privacy'] != 1) ? $myU->FriendRequestSettings : $_POST['friends_privacy'];
		$TradePrivacy = ($_POST['trade_privacy'] != 0 && $_POST['trade_privacy'] != 1 && $_POST['trade_privacy'] != 2) ? $myU->TradeSettings : $_POST['trade_privacy'];
		$PostWallPrivacy = ($_POST['postwall_privacy'] != 0 && $_POST['postwall_privacy'] != 1 && $_POST['postwall_privacy'] != 2) ? $myU->PostWallSettings : $_POST['postwall_privacy'];
		$ViewWallPrivacy = ($_POST['viewwall_privacy'] != 0 && $_POST['viewwall_privacy'] != 1 && $_POST['viewwall_privacy'] != 2) ? $myU->ViewWallSettings : $_POST['viewwall_privacy'];
		
		$NotificationSettingsChats = (!isset($_POST['notification_settings_chats'])) ? 0 : 1;
		$NotificationSettingsIncomingTrades = (!isset($_POST['notification_settings_incoming_trades'])) ? 0 : 1;
		$NotificationSettingsSellItem = (!isset($_POST['notification_settings_sell_item'])) ? 0 : 1;
		$NotificationSettingsBlog = (!isset($_POST['notification_settings_blog'])) ? 0 : 1;
		$NotificationSettingsFriendRequests = (!isset($_POST['notification_settings_friend_requests'])) ? 0 : 1;
		$NotificationSettingsGroups = (!isset($_POST['notification_settings_groups'])) ? 0 : 1;
		$NotificationSettingsWall = (!isset($_POST['notification_settings_wall'])) ? 0 : 1;
		
		if ($CountryRestrict != $myU->CountryRestrict) {
			
			$Update = $db->prepare("UPDATE User SET CountryRestrict = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $CountryRestrict, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account privacy settings - country restriction', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->CountryRestrict = $CountryRestrict;
			array_push($successArray, 'You have successfully updated your country restriction settings.');
			
		}
		
		if ($EmailNotifications != $myU->EmailNotifications) {
			
			$Update = $db->prepare("UPDATE User SET EmailNotifications = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $EmailNotifications, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account privacy settings - email notifications', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$myU->EmailNotifications = $EmailNotifications;
			array_push($successArray, 'You have successfully updated your email notifications settings.');
			
		}
		
		if ($MessagesPrivacy != $myU->PrivateMessageSettings) {
			
			$Update = $db->prepare("UPDATE User SET PrivateMessageSettings = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $MessagesPrivacy, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account privacy settings - messages privacy', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->PrivateMessageSettings = $MessagesPrivacy;
			array_push($successArray, 'You have successfully updated your private message privacy settings.');
			
		}
		
		if ($FriendsPrivacy != $myU->FriendRequestSettings) {
			
			$Update = $db->prepare("UPDATE User SET FriendRequestSettings = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $FriendsPrivacy, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account privacy settings - friends privacy', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->FriendRequestSettings = $FriendsPrivacy;
			array_push($successArray, 'You have successfully updated your friend request privacy settings.');
			
		}
		
		if ($TradePrivacy != $myU->TradeSettings) {
			
			$Update = $db->prepare("UPDATE User SET TradeSettings = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $TradePrivacy, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account privacy settings - trade settings', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->TradeSettings = $TradePrivacy;
			array_push($successArray, 'You have successfully updated your trade privacy settings.');
			
		}
		
		if ($PostWallPrivacy != $myU->PostWallSettings) {
			
			$Update = $db->prepare("UPDATE User SET PostWallSettings = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $PostWallPrivacy, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account privacy settings - post wall settings', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->PostWallSettings = $PostWallPrivacy;
			array_push($successArray, 'You have successfully updated your wall privacy settings.');
			
		}
		
		if ($ViewWallPrivacy != $myU->ViewWallSettings) {
			
			$Update = $db->prepare("UPDATE User SET ViewWallSettings = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $ViewWallPrivacy, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account privacy settings - user profile wall settings', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->ViewWallSettings = $ViewWallPrivacy;
			array_push($successArray, 'You have successfully updated your wall privacy settings.');
			
		}
		
		if ($NotificationSettingsChats != $myU->NotificationSettingsChats) {
			
			$Update = $db->prepare("UPDATE User SET NotificationSettingsChats = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $NotificationSettingsChats, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account notification settings - chats', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->NotificationSettingsChats = $NotificationSettingsChats;
			array_push($successArray, 'You have successfully updated your notification settings.');
			
		}
		
		if ($NotificationSettingsIncomingTrades != $myU->NotificationSettingsIncomingTrades) {
			
			$Update = $db->prepare("UPDATE User SET NotificationSettingsIncomingTrades = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $NotificationSettingsIncomingTrades, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account notification settings - incoming trades', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->NotificationSettingsIncomingTrades = $NotificationSettingsIncomingTrades;
			array_push($successArray, 'You have successfully updated your notification settings.');
			
		}
		
		if ($NotificationSettingsSellItem != $myU->NotificationSettingsSellItem) {
			
			$Update = $db->prepare("UPDATE User SET NotificationSettingsSellItem = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $NotificationSettingsSellItem, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account notification settings - sell item', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->NotificationSettingsSellItem = $NotificationSettingsSellItem;
			array_push($successArray, 'You have successfully updated your notification settings.');
			
		}
		
		if ($NotificationSettingsBlog != $myU->NotificationSettingsBlog) {
			
			$Update = $db->prepare("UPDATE User SET NotificationSettingsBlog = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $NotificationSettingsBlog, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account notification settings - blog', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->NotificationSettingsBlog = $NotificationSettingsBlog;
			array_push($successArray, 'You have successfully updated your notification settings.');
			
		}
		
		if ($NotificationSettingsFriendRequests != $myU->NotificationSettingsFriendRequests) {
			
			$Update = $db->prepare("UPDATE User SET NotificationSettingsFriendRequests = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $NotificationSettingsFriendRequests, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account notification settings - friend requests', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->NotificationSettingsFriendRequests = $NotificationSettingsFriendRequests;
			array_push($successArray, 'You have successfully updated your notification settings.');
			
		}
		
		if ($NotificationSettingsGroups != $myU->NotificationSettingsGroups) {
			
			$Update = $db->prepare("UPDATE User SET NotificationSettingsGroups = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $NotificationSettingsGroups, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account notification settings - groups', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->NotificationSettingsGroups = $NotificationSettingsGroups;
			array_push($successArray, 'You have successfully updated your notification settings.');
			
		}
		
		if ($NotificationSettingsWall != $myU->NotificationSettingsWall) {
			
			$Update = $db->prepare("UPDATE User SET NotificationSettingsWall = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $NotificationSettingsWall, PDO::PARAM_INT);
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Modified their account notification settings - profile wall', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$myU->NotificationSettingsWall = $NotificationSettingsWall;
			array_push($successArray, 'You have successfully updated your notification settings.');
			
		}
		
		$_SESSION['JumpToTab'] = 'privacy';
		
	}
	
	if (!empty($_POST['unblock_blocked_id']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
		
		$GetBlockedUser = $db->prepare("SELECT BlockedUser.BlockedID, User.Username FROM BlockedUser JOIN User ON BlockedUser.BlockedID = User.ID WHERE BlockedUser.ID = ? AND BlockedUser.RequesterID = ".$myU->ID);
		$GetBlockedUser->bindValue(1, $_POST['unblock_blocked_id'], PDO::PARAM_INT);
		$GetBlockedUser->execute();
		
		if ($GetBlockedUser->rowCount() == 0) {
			
			$errorMessage = 'An unexpected error has occurred, please try again.';
			$_SESSION['JumpToTab'] = 'privacy';
			
		} else {
			
			$bU = $GetBlockedUser->fetch(PDO::FETCH_OBJ);
			
			$Delete = $db->prepare("DELETE FROM BlockedUser WHERE ID = ? AND RequesterID = ".$myU->ID." AND BlockedID = ?");
			$Delete->bindValue(1, $_POST['unblock_blocked_id'], PDO::PARAM_INT);
			$Delete->bindValue(2, $bU->BlockedID, PDO::PARAM_INT);
			$Delete->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Unblocked \''.$bU->Username.'\'', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$successMessage = 'You have successfully unblocked this user.';
			$_SESSION['JumpToTab'] = 'privacy';
			
		}
		
	}
	
	if (!empty($_POST['block_user_username']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
		
		$GetUser = $db->prepare("SELECT User.ID, User.Username FROM User WHERE User.Username = ?");
		$GetUser->bindValue(1, $_POST['block_user_username'], PDO::PARAM_STR);
		$GetUser->execute();
		$gU = $GetUser->fetch(PDO::FETCH_OBJ);
		
		if ($GetUser->rowCount() == 0) {
			
			$errorMessage = 'This username could not be found, please try again.';
			$_SESSION['JumpToTab'] = 'privacy';
			
		} else if ($gU->ID == $myU->ID) {
			
			$errorMessage = 'You can not block yourself, please try again.';
			$_SESSION['JumpToTab'] = 'privacy';
			
		} else {
			
			$Insert = $db->prepare("INSERT INTO BlockedUser (RequesterID, BlockedID, Time) VALUES(".$myU->ID.", ".$gU->ID.", ".time().")");
			$Insert->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Blocked \''.$bU->Username.'\'', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$successMessage = 'You have successfully blocked this user.';
			$_SESSION['JumpToTab'] = 'privacy';
			
		}
		
	}
	
	if (isset($_POST['password_save']) && !empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
		
		if (!password_verify($_POST['current_password'], $myU->Password)) {
			
			$errorMessage = 'The current password you entered is invalid, please try again.';
			$_SESSION['JumpToTab'] = 'password';
			
		} else if ($_POST['confirm_new_password'] != $_POST['new_password']) {
			
			$errorMessage = 'Your confirm new password does not match your new password, please try again.';
			$_SESSION['JumpToTab'] = 'password';
			
		} else if (strlen($_POST['new_password']) < 8 || !preg_match('~[0-9]~', $_POST['new_password'])) {
			
			$errorMessage = 'Invalid password. A password should have at least 8 characters with a number.';
			$_SESSION['JumpToTab'] = 'password';
			
		} else {
			
			$CurrentEncrypted = $myU->Password;
			$NewEncrypted = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
			$OneDay = time() + 86400;
			$key = md5(microtime() + $myU->ID);
			
			$log = $db->prepare("INSERT INTO UserPasswordChange (UserID, PreviousPassword, NewPassword, RevertCode, Expire, IP) VALUES(?, ?, ?, ?, ?, ?)");
			$log->bindValue(1, $myU->ID, PDO::PARAM_INT);
			$log->bindValue(2, $CurrentEncrypted, PDO::PARAM_STR);
			$log->bindValue(3, $NewEncrypted, PDO::PARAM_STR);
			$log->bindValue(4, $key, PDO::PARAM_STR);
			$log->bindValue(5, $OneDay, PDO::PARAM_INT);
			$log->bindValue(6, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$log->execute();
			
			$change = $db->prepare("UPDATE User SET Password = ? WHERE ID = ".$myU->ID."");
			$change->bindValue(1, $NewEncrypted, PDO::PARAM_STR);
			$change->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Changed their account password', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$successMessage = 'You have successfully changed your password. For security reasons, you have been signed out.';
			$_SESSION['JumpToTab'] = 'password';
			
			session_destroy();
			
		}
		
	}
	
	if (!empty($_POST['cancel_recurring']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $myU->VIP_Recurring == 1) {
		
		$query = $db->prepare("SELECT PaymentType, SubscriptionID FROM UserPaymentHistory WHERE UserID = ".$myU->ID." AND PlanID IN(1, 2, 3) ORDER BY TimePayment DESC LIMIT 1");
		$query->execute();
		
		if ($query->rowCount() > 0) {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			
			if ($q->PaymentType == 0) {
				
				require_once('/var/www/html/upgrade/vendor/autoload.php');
				
				\Stripe\Stripe::setApiKey('sk_live_fYu99GFyStXZ8vgBpIL5gbOj');
				
				$customer = \Stripe\Customer::retrieve($myU->StripeKey);
				
				if ($customer->subscriptions->total_count > 0) {
					
					$customer->cancelSubscription();
					
				}
				
			} else if ($q->PaymentType == 1) {
				
				CancelPaypalSubscription($q->SubscriptionID, 'Cancel');
				
			}
			
			$Update = $db->prepare("UPDATE User SET VIP_Recurring = 0 WHERE ID = ".$myU->ID."");
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Canceled account membership renewal', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$successMessage = 'You have successfully canceled your membership from recurring (renewing) any further. Thank you for your business!';
			$myU->VIP_Recurring = 0;
		
		}
		
		$_SESSION['JumpToTab'] = 'billing';
		
	}
	
	echo '
	<script>
		document.title = "Settings - Brick Create";
		
		function blockedUsers(search, page = 1) {
			var xmlHttp = new XMLHttpRequest();
			xmlHttp.open( "GET", "'.$serverName.'/account/settings/blocked/?q=" + search + "&page=" + page, true);
			xmlHttp.send(null);
			xmlHttp.onload = function(e) {
				if (xmlHttp.readyState == 4) {
					document.getElementById("blocked-users").innerHTML = xmlHttp.responseText;
				}
			}
		}
		
		window.onload = function() {
			blockedUsers();
			';
			
			if (isset($_SESSION['JumpToTab'])) {
				echo '
				$("#tabs").foundation("selectTab", "'.$_SESSION['JumpToTab'].'");
				';
				$jumped = 1;
				unset($_SESSION['JumpToTab']);
			}
			
			echo '
		}
	</script>
	<div class="grid-x grid-margin-x">
		<div class="auto cell">
			<ul class="tabs grid-x grid-margin-x settings-tabs" data-tabs id="tabs">
				<li class="no-margin tabs-title cell'; if (!isset($jumped)) { echo ' is-active'; } echo '" aria-selected="true"><a href="#account">Account</a></li>
				<li class="no-margin tabs-title cell"><a href="#privacy">Privacy & Security</a></li>
				<li class="no-margin tabs-title cell"><a href="#password">Password</a></li>
				<li class="no-margin tabs-title cell"><a href="#billing" class="no-right-border">Billing</a></li>
			</ul>
			';
			
			if (isset($errorMessage)) {

				echo '<div class="error-message">'.$errorMessage.'</div>';
				
			} else if (isset($successMessage)) {
				
				echo '<div class="success-message">'.$successMessage.'</div>';
				
			} else if (!empty($successArray)) {
				
				$successArray = array_unique($successArray);
				
				echo '
				<div class="success-message">
				';
				
				foreach ($successArray as $Message) {
					echo '<div style="padding:3px 0;">'.$Message.'</div>';
				}
				
				echo '
				</div>
				';
				
			}
			
			echo '
			<div class="tabs-content" data-tabs-content="tabs">
				<div id="account" class="tabs-panel'; if (!isset($jumped)) { echo ' is-active'; } echo '">
					<h5>Account</h5>
					<div class="container border-r lg-padding">
						<div class="grid-x grid-margin-x align-middle">
							<div class="large-2 large-offset-1 cell text-right">
								<strong>Username</strong>
							</div>
							<div class="large-7 cell">
								<div class="grid-x grid-margin-x align-middle">
									<div class="shrink cell no-margin">
										<div class="settings-content">'.$myU->Username.'</div>
									</div>
									';
									
									if ($myU->CurrencyCoins >= 2500) {
										
									echo '
									<div class="shrink cell no-margin">
										<button type="button" class="button button-blue settings-button-cu" data-open="ChangeUsername">Change</button>
										<div class="reveal item-modal" id="ChangeUsername" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
											<form action="" method="POST">
												<div class="grid-x grid-margin-x align-middle">
													<div class="auto cell no-margin">
														<div class="modal-title">Change Username</div>
													</div>
													<div class="shrink cell no-margin">
														<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
													</div>
												</div>
												<div class="push-15"></div>
												<input type="text" class="normal-input" name="new_username" placeholder="New Username">
												<div class="push-15"></div>
												<div>Changing your username will cost <font class="coins-text">2,500 Bits</font></div>
												<div class="push-25"></div>
												<div align="center">
													<input type="submit" class="button button-green store-button inline-block" name="save_new_username" value="Change">
													<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
													<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
												</div>
											</form>
										</div>
									</div>
									';
										
									} else {
										
									echo '
									<span class="settings-content-info has-tip right" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="You need at least 2,500 Bits to change your username."><i class="material-icons">info_outline</i></span>
									';
										
									}
									
									echo '
								</div>
							</div>
						</div>
						<div class="push-25"></div>
						<div class="grid-x grid-margin-x align-middle">
							<div class="large-2 large-offset-1 cell text-right">
								<strong>Email</strong>
							</div>
							<div class="large-7 cell">
								<div class="grid-x grid-margin-x align-middle">
									<div class="shrink cell no-margin">
										<div class="settings-content">'.preg_replace('/[^@]+@([^\s]+)/', ''.substr($myU->Email, 0, 3).'********@$1', $myU->Email).'</div>
									</div>
									';
									
									if ($myU->NextEmailChange < time()) {
									
									echo '
									<div class="shrink cell no-margin">
										<button type="button" class="button button-blue settings-button-cu" data-open="ChangeEmail">Change</button>
										<div class="reveal item-modal" id="ChangeEmail" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
											<form action="" method="POST">
												<div class="grid-x grid-margin-x align-middle">
													<div class="auto cell no-margin">
														<div class="modal-title">Change Email Address</div>
													</div>
													<div class="shrink cell no-margin">
														<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
													</div>
												</div>
												<div class="push-15"></div>
												<input type="email" class="normal-input" name="current_email" placeholder="Current Email">
												<div style="height:15px;"></div>
												<input type="email" class="normal-input" name="new_email" placeholder="New Email">
												<div class="push-25"></div>
												<div align="center">
													<input type="submit" class="button button-green store-button inline-block" name="save_new_email" value="Change">
													<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
													<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
												</div>
											</form>
										</div>
									</div>
									';
									
									} else {
										
									echo '
									<span class="settings-content-info has-tip right" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="You can change your email again at '.date('m/d/Y g:iA', $myU->NextEmailChange).' CST"><i class="material-icons">info_outline</i></span>
									';
										
									}
									
									echo '
								</div>
							</div>
						</div>
						<div class="push-25"></div>
						<form action="" method="POST">
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>Gender</strong>
								</div>
								<div class="large-7 cell">
									<select class="normal-input" name="gender" style="width:200px;">
										<option value="0"'; if ($myU->Gender == 0) { echo ' selected'; } echo '>Male</option>
										<option value="1"'; if ($myU->Gender == 1) { echo ' selected'; } echo '>Female</option>
										<option value="2"'; if ($myU->Gender == 2) { echo ' selected'; } echo '>Other</option>
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>Avatar</strong>
								</div>
								<div class="large-7 cell">
									<select class="normal-input" name="avatar" style="width:200px;">
										<option value="0"'; if ($myU->Avatar == 0) { echo ' selected'; } echo '>Male</option>
										<option value="1"'; if ($myU->Avatar == 1) { echo ' selected'; } echo '>Female</option>
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>Birth Date</strong>
								</div>
								<div class="large-7 cell">
									<select name="birthdate_month" id="birthdate_month" class="normal-input" style="display:inline-block;width:48%;">
										';
										
										if ($myU->BirthdateMonth == 0) {
											
											echo '<option value="0" selected>Select...</option>';
											
										}
										
										echo '
										<option value="1"'; if ($myU->BirthdateMonth == 1) { echo ' selected'; } echo '>January</option>
										<option value="2"'; if ($myU->BirthdateMonth == 2) { echo ' selected'; } echo '>February</option>
										<option value="3"'; if ($myU->BirthdateMonth == 3) { echo ' selected'; } echo '>March</option>
										<option value="4"'; if ($myU->BirthdateMonth == 4) { echo ' selected'; } echo '>April</option>
										<option value="5"'; if ($myU->BirthdateMonth == 5) { echo ' selected'; } echo '>May</option>
										<option value="6"'; if ($myU->BirthdateMonth == 6) { echo ' selected'; } echo '>June</option>
										<option value="7"'; if ($myU->BirthdateMonth == 7) { echo ' selected'; } echo '>July</option>
										<option value="8"'; if ($myU->BirthdateMonth == 8) { echo ' selected'; } echo '>August</option>
										<option value="9"'; if ($myU->BirthdateMonth == 9) { echo ' selected'; } echo '>September</option>
										<option value="10"'; if ($myU->BirthdateMonth == 10) { echo ' selected'; } echo '>October</option>
										<option value="11"'; if ($myU->BirthdateMonth == 11) { echo ' selected'; } echo '>November</option>
										<option value="12"'; if ($myU->BirthdateMonth == 12) { echo ' selected'; } echo '>December</option>
									</select>
									<select name="birthdate_day" id="birthdate_day" class="normal-input" style="display:inline-block;width:25%;">
										';
										
										for ($i = 1; $i < 32; $i++) {
											
											if ($i < 10) { $i = 0 . $i; }
											
											echo '<option value="'.$i.'"'; if ($myU->BirthdateDay == $i) { echo ' selected'; } echo '>'.$i.'</option>';
											
										}
										
										echo '
									</select>
									<select name="birthdate_year" id="birthdate_year" class="normal-input" style="display:inline-block;width:25%;">
										';
										
										if ($myU->BirthdateYear == 0) {
											
											echo '<option value="0" selected>Select...</option>';
											
										}
										
										$date_year = date('Y');
										$hundred_years = date('Y') - 100;
										
										for ($i = $date_year; $i >= $hundred_years; $i--) {
											
											echo '<option value="'.$i.'"'; if ($myU->BirthdateYear == $i) { echo ' selected'; } echo '>'.$i.'</option>';
											
										}
										
										echo '
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>Country</strong>
								</div>
								<div class="large-7 cell">
									<select name="country" id="country" class="normal-input">
										';
										
										if (is_numeric($myU->Country)) {
										
											echo '
											<option value="0">Select...</option>
											';
										
										}
										
										foreach ($countries as $key => $value) {
											
											echo '
											<option value="'.$key.'"'; if (!is_numeric($myU->Country) && $myU->Country == $key) { echo ' selected'; } echo '>'.$value.'</option>
											';
											
										}
										
										echo '
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>Profile Blurb</strong>
								</div>
								<div class="large-7 cell">
									<textarea name="blurb" id="blurb" class="normal-input settings-blurb" length="1000">'.$myU->About.'</textarea>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-7 large-offset-3 cell">
									<input type="submit" name="settings_save" class="button button-green" value="Save" style="margin:0 auto;">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div id="privacy" class="tabs-panel">
					<h5>Security Features</h5>
					<form action="" method="POST">
						<div class="container lg-padding border-r">
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Choose whether or not you want to disable other countries accessing your account, and allow only your country to access your account. Enabled by default.">Restrict access from other countries?</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="country_restrict" id="country_restrict" value="1"'; if ($myU->CountryRestrict == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="country_restrict"></label>
									</div>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Send an email when major actions happen (large purchase, sign-in, password change, etc). Enabled by default.">Allow email notifications?</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="email_notifications" id="email_notifications" value="1"'; if ($myU->EmailNotifications == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="email_notifications"></label>
									</div>
								</div>
							</div>
						</div>
						<div class="push-25"></div>
					</form>
						
					<h5>Two Step Verification</h5>
					<div class="container lg-padding border-r">
							<p>Two Step Verification adds an extra layer of security to your account by requiring an unique code once you sign in.<br>
							<b>Note</b>: You will require a mobile app named Google Authenticator or Authy</p><div id="twoStepContainer">
							<div id="disabled2fa" style="display:none">
								<button id="etfaBtn" class="button button-green" onclick="enableTwoStep();">Enable</button>
							</div>
							
							<div id="init2fa" style="display:none">
								<p>Two Step Verification has been enabled, however we need to verify you can sign in afterwards.<br>
								<b id="codeContainer"></b><br>
								<div id="qrContainer"></div>
								Now, we have to get the code. To do this, open either Google Authenticator or Authy and:<br>
								1. Scan the given QR code <b>OR</b><br>
								2. Use the given key<br><br>
								Once you do that, you should get a 6 digit code that will re-generate every 30 seconds.
								Please enter your two step verification code in the box below:</p>
								<input type="number" id="2faInitCode" maxlength="6" class="forum-input" placeholder="Two Step Verification Code here">
								<div class="push-5"></div>
								<div id="2faErrorContainer"></div>
								<button id="itfabtn" class="button button-green" onclick="finishStepSetup();">Finish Setup</button>
							</div>
							
							<div id="enabled2fa" style="display:none">
								<p>Two Step Verification has been enabled. You will be asked for a code the next time you sign in.<br>
								<b id="fcodeContainer"></b><br>
								<div id="fqrContainer"></div>
								If you wish to disable this security feature, click the button below:<br>
								<button id="etfabtn" class="button button-green" onclick="disableTwoStep();">Disable Two Step Verification</button>
							</div>';
							if ($myU->TwoStepEnabled == 0 && $myU->TwoStepInit == 0)
								echo '<script>$("#disabled2fa").show();</script>';
							elseif ($myU->TwoStepInit == 1)
								echo '<script>createInitView("'.$myU->TwoStepPrivateKey.'", "'.$gAuth->getURL($myU->Username, 'brickcreate.com', $myU->TwoStepPrivateKey).'");</script>';
							elseif ($myU->TwoStepEnabled == 1)
								echo '<script>createEnabledView("'.$myU->TwoStepPrivateKey.'", "'.$gAuth->getURL($myU->Username, 'brickcreate.com', $myU->TwoStepPrivateKey).'");</script>';
					echo '</div></div>
					
					<div class="push-25"></div>
					<form action="" method="POST">
						<h5>Privacy</h5>
						<div class="container lg-padding border-r">
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-4 large-offset-1 cell text-right">
									<strong>Who can send me chats?</strong>
								</div>
								<div class="large-3 cell">
									<select name="messages_privacy" id="messages_privacy" class="normal-input">
										<option value="0"'; if ($myU->PrivateMessageSettings == 0) { echo ' selected'; } echo '>Everyone</option>
										<option value="1"'; if ($myU->PrivateMessageSettings == 1) { echo ' selected'; } echo '>Friends Only</option>
										<option value="2"'; if ($myU->PrivateMessageSettings == 2) { echo ' selected'; } echo '>No One</option>
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-4 large-offset-1 cell text-right">
									<strong>Who can add me as a friend?</strong>
								</div>
								<div class="large-3 cell">
									<select name="friends_privacy" id="friends_privacy" class="normal-input">
										<option value="0"'; if ($myU->FriendRequestSettings == 0) { echo ' selected'; } echo '>Everyone</option>
										<option value="1"'; if ($myU->FriendRequestSettings == 1) { echo ' selected'; } echo '>No One</option>
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-4 large-offset-1 cell text-right">
									<strong>Who can send me trades?</strong>
								</div>
								<div class="large-3 cell">
									<select name="trade_privacy" id="trade_privacy" class="normal-input">
										<option value="0"'; if ($myU->TradeSettings == 0) { echo ' selected'; } echo '>Everyone</option>
										<option value="1"'; if ($myU->TradeSettings == 1) { echo ' selected'; } echo '>Friends Only</option>
										<option value="2"'; if ($myU->TradeSettings == 2) { echo ' selected'; } echo '>No One</option>
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-4 large-offset-1 cell text-right">
									<strong>Who can post on my wall?</strong>
								</div>
								<div class="large-3 cell">
									<select name="postwall_privacy" id="postwall_privacy" class="normal-input">
										<option value="0"'; if ($myU->PostWallSettings == 0) { echo ' selected'; } echo '>Everyone</option>
										<option value="1"'; if ($myU->PostWallSettings == 1) { echo ' selected'; } echo '>Friends Only</option>
										<option value="2"'; if ($myU->PostWallSettings == 2) { echo ' selected'; } echo '>No One</option>
									</select>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-4 large-offset-1 cell text-right">
									<strong>Who can view my wall?</strong>
								</div>
								<div class="large-3 cell">
									<select name="viewwall_privacy" id="viewwall_privacy" class="normal-input">
										<option value="0"'; if ($myU->ViewWallSettings == 0) { echo ' selected'; } echo '>Everyone</option>
										<option value="1"'; if ($myU->ViewWallSettings == 1) { echo ' selected'; } echo '>Friends Only</option>
										<option value="2"'; if ($myU->ViewWallSettings == 2) { echo ' selected'; } echo '>No One</option>
									</select>
								</div>
							</div>
						</div>
						<div class="push-25"></div>
						<h5>Notifications</h5>
						<div class="container lg-padding border-r">
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Receive notifications about chats">Receive notifications about chats</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="notification_settings_chats" id="notification_settings_chats" value="1"'; if ($myU->NotificationSettingsChats == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="notification_settings_chats"></label>
									</div>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Receive notifications about incoming trades">Receive notifications about incoming trades</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="notification_settings_incoming_trades" id="notification_settings_incoming_trades" value="1"'; if ($myU->NotificationSettingsIncomingTrades == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="notification_settings_incoming_trades"></label>
									</div>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Receive notifications when you sell an item">Receive notifications when you sell an item</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="notification_settings_sell_item" id="notification_settings_sell_item" value="1"'; if ($myU->NotificationSettingsSellItem == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="notification_settings_sell_item"></label>
									</div>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Receive notifications about new blog posts">Receive notifications about new blog posts</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="notification_settings_blog" id="notification_settings_blog" value="1"'; if ($myU->NotificationSettingsBlog == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="notification_settings_blog"></label>
									</div>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Receive notifications for friend requests">Receive notifications for friend requests</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="notification_settings_friend_requests" id="notification_settings_friend_requests" value="1"'; if ($myU->NotificationSettingsFriendRequests == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="notification_settings_friend_requests"></label>
									</div>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Receive notifications from groups">Receive notifications from groups</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="notification_settings_groups" id="notification_settings_groups" value="1"'; if ($myU->NotificationSettingsGroups == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="notification_settings_groups"></label>
									</div>
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x">
								<div class="large-4 large-offset-1 cell text-right">
									<strong data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="Receive notifications for your profile wall">Receive notifications for your profile wall</strong>
								</div>
								<div class="large-5 cell">
									<div class="switch tiny">
										<input class="switch-input" type="checkbox" name="notification_settings_wall" id="notification_settings_wall" value="1"'; if ($myU->NotificationSettingsWall == 1) { echo ' checked'; } echo '>
										<label class="switch-paddle" for="notification_settings_wall"></label>
									</div>
								</div>
							</div>
						</div>
						<div class="push-25"></div>
						<div class="grid-x grid-margin-x align-middle">
							<div class="large-3 large-offset-5 cell">
								<input type="submit" name="privacy_save" class="button button-green" value="Save" style="margin:0 auto;">
							</div>
						</div>
					</form>
					<div class="push-25"></div>
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<h5>Blocked Users</h5>
						</div>
						<div class="shrink cell right no-margin">
							<input type="button" class="button button-blue" value="Add User" style="padding: 6px 15px;font-size:14px;line-height:1.25;" data-open="BlockUserAdd">
							<div class="reveal item-modal" id="BlockUserAdd" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
								<form action="" method="POST">
									<div class="grid-x grid-margin-x align-middle">
										<div class="auto cell no-margin">
											<div class="modal-title">Block User</div>
										</div>
										<div class="shrink cell no-margin">
											<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
										</div>
									</div>
									<div class="push-15"></div>
									<div>Please enter the username of the user you wish to block.</div>
									<div class="push-15"></div>
									<input type="text" name="block_user_username" class="normal-input">
									<div class="push-25"></div>
									<div align="center">
										<input type="submit" class="button button-blue store-button inline-block" value="Block User">
										<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
										<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="push-10"></div>
					<div class="container lg-padding border-r">
						<div id="blocked-users"></div>
					</div>
				</div>
				<div id="password" class="tabs-panel">
					<h5>Change Password</h5>
					<form action="" method="POST">
						<div class="container border-r lg-padding">
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>Current Password</strong>
								</div>
								<div class="large-7 cell">
									<input type="password" name="current_password" class="normal-input">
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>New Password</strong>
								</div>
								<div class="large-7 cell">
									<input type="password" name="new_password" class="normal-input">
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-2 large-offset-1 cell text-right">
									<strong>New Password (again)</strong>
								</div>
								<div class="large-7 cell">
									<input type="password" name="confirm_new_password" class="normal-input">
								</div>
							</div>
							<div class="push-25"></div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-7 large-offset-3 cell">
									<input type="submit" name="password_save" class="button button-green" value="Save" style="margin:0 auto;">
									<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div id="billing" class="tabs-panel">
				<h5>Billing</h5>
				<div class="container border-r lg-padding">
					<form action="" method="POST">
						';
						
						if ($myU->VIP == 0) {
							
							echo '
							<div class="text-center">You have no active VIP subscriptions. <a href="'.$serverName.'/upgrade/" target="_blank">Click here</a> to upgrade!</div>
							';
							
						} else {
							
							switch ($myU->VIP) {
								case 1:
									$TypeName = 'Brick Builder';
									break;
								case 2:
									$TypeName = 'Planet Constructor';
									break;
								case 3:
									$TypeName = 'Master Architect';
									break;
								case 5:
									$TypeName = 'Diamond Membership';
									break;	
								case 6:
									$TypeName = 'Diamond Membership +';
									break;	
							}
							
							echo '
							<div class="grid-x grid-margin-x align-middle settings-billing">
								<div class="large-6 cell text-center">
									<div class="content-title">CURRENT SUBSCRIPTION</div>
									<div class="content-text">'.$TypeName.'</div>
								</div>
								<div class="large-6 cell text-center">
									<div class="content-title">'; if ($myU->VIP_Recurring == 0) { echo 'EXPIRES'; } else { echo 'RENEWS'; } echo ' AT</div>
									<div class="content-text-small">'; if ($myU->VIP_Expires == -1) { echo 'Never - Lifetime'; } else { echo ''.date('m/d/Y g:iA', $myU->VIP_Expires).' CST'; } echo '</div>
									';
									
									if ($myU->VIP_Recurring == 1) {
									
										echo '
										<div style="height:5px;"></div>
										<input type="submit" value="Cancel" class="settings-button-blue" name="cancel_recurring">
										<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
										';
									
									}
									
									echo '
								</div>
							</div>
							';
							
						}
						
						echo '
					</form>
				</div>
			</div>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");