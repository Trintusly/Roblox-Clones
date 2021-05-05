// fetch_asset(id, assetType, filetype, legacy) - returns false if asset exists, or makes a request for it
// only works with png items

var assetId, assetType, filepath, legacy;

assetId = string(argument0)
assetType = argument1
filetype = argument2
legacy = argument3
 
filepath = global.ASSET_DIR + "asset_" + assetId + "." + filetype

// No idea how this happens, but it do.
if assetId == "0" return -1;

if file_exists(filepath) { // The user already has the item downloaded.
    switch(assetType) {
        case "face":
            Face = background_add(filepath, 1, 0)
            break
        case "hat_tex1":
            Hat1_Tex = background_add(filepath, 0, 0)
            break
        case "hat_mod1":
            Hat1 = scr_load_model_obj(filepath, assetId);
            break
        case "hat_tex2":
            Hat2_Tex = background_add(filepath, 0, 0)
            break
        case "hat_mod2":
            Hat2 = scr_load_model_obj(filepath, assetId);
            break
        case "hat_tex3":
            Hat3_Tex = background_add(filepath, 0, 0)
            break
        case "hat_mod3":
            Hat3 = scr_load_model_obj(filepath, assetId);
            break
        case "brick_tex":
            Tex = background_add(filepath, 0, 0)
            break
        case "brick_mod":
            Model = scr_load_model_obj(filepath, assetId);
            break
        case "item_tex":
            Item_Tex = background_add(filepath, 0, 0)
            break
        case "item_mod":
            Item = scr_load_model_obj(filepath, assetId);
            break
    }
    return -1
} else {
    // The user does not have the item cached, lets grab it
    if (!legacy) {
        return download_asset("http://api.brick-hill.com/v1/games/retrieveAsset?id=" + assetId + "&type=" + filetype, assetId, filepath)
    } else {
        if string_pos(".png", filepath) {
            return download("http://www.brick-hill.com/API/client/asset_texture?id=" + assetId + "&type", filepath)
        } else {
            return download("http://www.brick-hill.com/shop_storage/client/" + assetId + ".d3d", filepath)
        }
    }
}
