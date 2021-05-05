// get_avatar()
var st, result, b;
httprequest = httprequest_create();
httprequest_connect(httprequest, "http://brick-hill.com/API/client/getAvatar?id="+string(user_id), false);
while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}
if st=4 {
    avatar = httprequest_get_message_body(httprequest);
} else {
    avatar = "0,0,0,0,0,0,0,0,0,0,0,0,0";
}
httprequest_destroy(httprequest);

Face = -1;
Shirt = -1;
TShirt = -1;
Pants = -1;
Hat1_Tex = -1;
Hat2_Tex = -1;
Hat3_Tex = -1;
Hat1 = -1;
Hat2 = -1;
Hat3 = -1;
FaceDownload = -1;
TShirtDownload = -1;
ShirtDownload = -1;
PantsDownload = -1;
Hat1TexDownload = -1;
Hat1ModDownload = -1;
Hat2TexDownload = -1;
Hat2ModDownload = -1;
Hat3TexDownload = -1;
Hat3ModDownload = -1;

partColorHead = color_to_3d(hex_to_dec(string_split(avatar,",",0)));
partColorTorso = color_to_3d(hex_to_dec(string_split(avatar,",",1)));
partColorRArm = color_to_3d(hex_to_dec(string_split(avatar,",",2)));
partColorLArm = color_to_3d(hex_to_dec(string_split(avatar,",",3)));
partColorRLeg = color_to_3d(hex_to_dec(string_split(avatar,",",4)));
partColorLLeg = color_to_3d(hex_to_dec(string_split(avatar,",",5)));

partStickerFace = string_split(avatar,",",6);
partStickerTShirt = string_split(avatar,",",7);
partStickerShirt = string_split(avatar,",",8);
partStickerPants = string_split(avatar,",",9);

partModelHat1 = string_split(avatar,",",10);
partModelHat2 = string_split(avatar,",",11);
partModelHat3 = string_split(avatar,",",12);


/*if partStickerFace != "0" {
    FaceDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partStickerFace+"&type=face",global.APPDATA+"face"+string(id)+".png");
}
if partStickerTShirt != "0" {
    TShirtDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partStickerTShirt+"&type=tshirt",global.APPDATA+"tshirt"+string(id)+".png");
}
if partStickerShirt != "0" {
    ShirtDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partStickerShirt+"&type=shirt",global.APPDATA+"shirt"+string(id)+".png");
}
if partStickerPants != "0" {
    PantsDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partStickerPants+"&type=pants",global.APPDATA+"pants"+string(id)+".png");
}
if partModelHat1 != "0" {
    Hat1TexDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partModelHat1+"&type=hat",global.APPDATA+"hat1"+string(id)+".png");
    Hat1ModDownload = download("http://www.brick-hill.com/shop_storage/client/"+partModelHat1+".d3d",global.APPDATA+"hat1"+string(id)+".d3d");
}
if partModelHat2 != "0" {
    Hat2TexDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partModelHat2+"&type=hat",global.APPDATA+"hat2"+string(id)+".png");
    Hat2ModDownload = download("http://www.brick-hill.com/shop_storage/client/"+partModelHat2+".d3d",global.APPDATA+"hat2"+string(id)+".d3d");
}
if partModelHat3 != "0" {
    Hat3TexDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partModelHat3+"&type=hat",global.APPDATA+"hat3"+string(id)+".png");
    Hat3ModDownload = download("http://www.brick-hill.com/shop_storage/client/"+partModelHat3+".d3d",global.APPDATA+"hat3"+string(id)+".d3d");
}
////////////
