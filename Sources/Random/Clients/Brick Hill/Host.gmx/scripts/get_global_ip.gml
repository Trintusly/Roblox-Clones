//Find our IP address
if !global.LAN {
var getIP;
getIP = httprequest_create();
httprequest_connect(getIP, "http://ipv4bot.whatismyipaddress.com/", false);
while httprequest_get_state(getIP) != 4 {
    httprequest_update(getIP);
    if httprequest_get_state(getIP) == 5 {
        console("Error \#3: Cannot find IP");
        show_message("Error \#3:#Cannot find IP");
        game_end();
        exit;
    }
}
global.IP = httprequest_get_message_body(getIP);
httprequest_destroy(getIP);
} else {
    global.IP = "127.0.0.1";
}
