<?php
require("/var/www/html/site/bopimo.php");
$headers .= "Organization: Bopimo\r\n";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers .= "From: <help@bopimo.com>" . "\r\n" .
"Reply-To: <help@bopimo.com>" . "\r\n" .
"X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "X-MSMail-Priority: High";
$to = "dukeisagamer@gmail.com";
$subject = "Verify your Bopimo! account.";
$message = '<head><link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"><link rel="stylesheet" type="text/css" href="/css/main.css?c=1535223873"></head>';
$message = "<center>";
$message .= "<img src='https://www.bopimo.com/images/logo.png'><br>";
$message .= "<h1>Verify your Bopimo! account.</h1><br>";
$message .= "<a class='button success' href='https://www.bopimo.com/verify/{$bop->uuid()}'>Click here to verify</a>";
$message .= "</center>";
mail($to, $subject, $message, $headers);
