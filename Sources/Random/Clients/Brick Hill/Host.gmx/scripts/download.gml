// download(url, destination)
// downloads a file and saves it at the destination
// returns whether successful
var st, result, b;
httprequest = httprequest_create();
httprequest_connect(httprequest, argument0, false);
while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
    sleep(10);
}
if st=5 {
    result = false;
} else {
    result = true;
    b = buffer_create();
    httprequest_get_message_body_buffer(httprequest, b);
    buffer_write_to_file(b, argument1);
    buffer_destroy(b);
}
httprequest_destroy(httprequest);
return result;
