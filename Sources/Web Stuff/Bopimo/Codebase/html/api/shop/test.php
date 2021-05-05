<?php 
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
require("shop.php");

var_dump($shopRender->cat2dir(1));

/*

/*
//$ip = json_decode($shop->ipInfo($_SERVER['REMOTE_ADDR']));
$ip = json_decode($shop->ipInfo($_SERVER['REMOTE_ADDR']));
$agent = $_SERVER['HTTP_USER_AGENT'];
$isVpn = ($ip->block == 1) ? 1 : 0;
$insert = $bop->query("INSERT INTO login VALUES (NULL, ? , ?, ?, now(), ?, ?)", [$id, $agent, $ip->ip, $isVpn, $ip->countryCode ]);