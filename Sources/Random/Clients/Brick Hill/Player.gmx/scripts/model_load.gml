// model_load(hash,type)
var st, result, b, hash, type, hat;
hash = argument0;
type = argument1;

httprequest = httprequest_create();
httprequest_connect(httprequest, "http://www.brick-hill.com/shop_storage/client/"+hash+".d3d", false);
while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}
if st=5 {
    result = false;
} else {
    result = true;
    b = buffer_create();
    httprequest_get_message_body_buffer(httprequest, b);
    buffer_write_to_file(b, global.APPDATA+hash+".d3d");
    buffer_destroy(b);
}
httprequest_destroy(httprequest);


var st, result, b;
httprequest = httprequest_create();
httprequest_connect(httprequest, "http://www.brick-hill.com/API/client/asset_texture?id="+hash+"&type="+type, false);
while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}
if st=5 {
    result = false;
} else {
    result = true;
    b = buffer_create();
    httprequest_get_message_body_buffer(httprequest, b);
    buffer_write_to_file(b, global.APPDATA+hash+".png");
    buffer_destroy(b);
}
httprequest_destroy(httprequest);

Hat_Texture = background_add(global.APPDATA+hash+".png", false, false);

hat = d3d_model_create();
d3d_model_load(hat, global.APPDATA+hash+".d3d");

file_delete(global.APPDATA+hash+".png");
file_delete(global.APPDATA+hash+".d3d");
return hat;
