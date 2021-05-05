// figureSetUser(id, user id)
var user_id;
user_id = string(argument1);

var httprequest, st, avatar;
httprequest = httprequest_create();
httprequest_connect(httprequest, "http://brick-hill.com/API/client/getAvatar?id="+user_id, false);
while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}
if st=5 {
    print("Failed to bind avatar!");
    return false;
} else {
    avatar = httprequest_get_message_body(httprequest);
    var figure;
    figure = argument0;
    
    figure.partColorHead = color_to_3d(hex_to_dec(string_split(avatar,",",0)));
    figure.partColorTorso = color_to_3d(hex_to_dec(string_split(avatar,",",1)));
    figure.partColorRArm = color_to_3d(hex_to_dec(string_split(avatar,",",2)));
    figure.partColorLArm = color_to_3d(hex_to_dec(string_split(avatar,",",3)));
    figure.partColorRLeg = color_to_3d(hex_to_dec(string_split(avatar,",",4)));
    figure.partColorLLeg = color_to_3d(hex_to_dec(string_split(avatar,",",5)));
    
    figure.partStickerFace = string_split(avatar,",",6);
    figure.partStickerTShirt = string_split(avatar,",",7);
    figure.partStickerShirt = string_split(avatar,",",8);
    figure.partStickerPants = string_split(avatar,",",9);
    
    figure.partModelHat1 = string_split(avatar,",",10);
    figure.partModelHat2 = string_split(avatar,",",11);
    figure.partModelHat3 = string_split(avatar,",",12);
    return true;
}
