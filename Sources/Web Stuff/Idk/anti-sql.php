<?php  
$ip = $_SERVER['REMOTE_ADDR'];  
$time = date("l dS of F Y h:i:s A");  
$script = $_SERVER[PATH_TRANSLATED];  
$fp = fopen ("[WEB]SQL_Injection.txt", "a+");  
$sql_inject_1 = array(";","'","%",'"'); #Whoth need replace  
$sql_inject_2 = array("", "'","","&quot;"); #To wont replace  
$GET_KEY = array_keys($_GET); #array keys from $_GET  
$POST_KEY = array_keys($_POST); #array keys from $_POST  
$COOKIE_KEY = array_keys($_COOKIE); #array keys from $_COOKIE  
/*begin clear $_GET */  
for($i=0;$i<count($GET_KEY);$i++)  
{  
$real_get[$i] = $_GET[$GET_KEY[$i]];  
$_GET[$GET_KEY[$i]] = str_replace($sql_inject_1, $sql_inject_2, HtmlSpecialChars($_GET[$GET_KEY[$i]]));  
if($real_get[$i] != $_GET[$GET_KEY[$i]])  
{  
fwrite ($fp, "IP: $ip\r\n");  
fwrite ($fp, "Method: GET\r\n");  
fwrite ($fp, "Value: $real_get[$i]\r\n"); 
fwrite ($fp, "Script: $script\r\n");  
fwrite ($fp, "Time: $time\r\n");  
fwrite ($fp, "==================================\r\n");  
}  
}  
/*end clear $_GET */  
/*begin clear $_POST */  
for($i=0;$i<count($POST_KEY);$i++)  
{  
$real_post[$i] = $_POST[$POST_KEY[$i]];  
$_POST[$POST_KEY[$i]] = str_replace($sql_inject_1, $sql_inject_2, HtmlSpecialChars($_POST[$POST_KEY[$i]]));  
if($real_post[$i] != $_POST[$POST_KEY[$i]])  
{  
fwrite ($fp, "IP: $ip\r\n");  
fwrite ($fp, "Method: POST\r\n");  
fwrite ($fp, "Value: $real_post[$i]\r\n");  
fwrite ($fp, "Script: $script\r\n");  
fwrite ($fp, "Time: $time\r\n");  
fwrite ($fp, "==================================\r\n");  
}  
}  
/*end clear $_POST */  
/*begin clear $_COOKIE */  
for($i=0;$i<count($COOKIE_KEY);$i++)  
{  
$real_cookie[$i] = $_COOKIE[$COOKIE_KEY[$i]];  
$_COOKIE[$COOKIE_KEY[$i]] = str_replace($sql_inject_1, $sql_inject_2, HtmlSpecialChars($_COOKIE[$COOKIE_KEY[$i]]));  
if($real_cookie[$i] != $_COOKIE[$COOKIE_KEY[$i]])  
{  
fwrite ($fp, "IP: $ip\r\n");  
fwrite ($fp, "Method: COOKIE\r\n");  
fwrite ($fp, "Value: $real_cookie[$i]\r\n");  
fwrite ($fp, "Script: $script\r\n");  
fwrite ($fp, "Time: $time\r\n");  
fwrite ($fp, "==================================\r\n");  
}  
}  

/*end clear $_COOKIE */  
fclose ($fp);  
?>