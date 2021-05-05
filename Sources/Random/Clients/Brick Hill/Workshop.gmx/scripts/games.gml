// games(user)
var httprequest,st,result;

httprequest = httprequest_create();
httprequest_connect(httprequest, "http://brick-hill.com/API/client/games?id="+string(argument0), false);

while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}

result = httprequest_get_message_body(httprequest);
return result;
