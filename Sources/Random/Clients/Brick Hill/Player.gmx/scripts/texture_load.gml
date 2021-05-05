// texture_load(hash, type)
var st, result, b, hash, type;
hash = argument0;
type = argument1;
rand = string(random(10));

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
    buffer_write_to_file(b, global.APPDATA+"tex"+rand+".png");
    buffer_destroy(b);
}
httprequest_destroy(httprequest);

Texture = background_add(global.APPDATA+"tex"+rand+".png", false, false);

file_delete(global.APPDATA+"tex"+rand+".png");
return Texture;
