// login(username,password)
var httprequest,st,result;

httprequest = httprequest_create();
httprequest_connect(httprequest, "http://www.brick-hill.com/API/client/login?username="+httprequest_urlencode(argument0,true)+"&password="+httprequest_urlencode(argument1,true), false);

while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}

result = httprequest_get_message_body(httprequest);
if string_pos("SUCCESS",result) != 0 {
    return real(string_split(result," ",1));
} else {
    return 0;
}
