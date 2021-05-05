// fetch_asset(id, assetType, filetype, legacy) - returns false if asset exists, or makes a request for it
// only works with png items

var assetId, assetType, filepath, legacy;

assetId = string(argument0)
assetType = argument1
filetype = argument2
legacy = argument3
 
filepath = global.ASSET_DIR + "asset_" + assetId + "." + filetype

if file_exists(filepath) { // The user already has the item downloaded.
    switch(assetType) {
        case "brick_tex":
            Tex = background_add(filepath, 0, 0)
            break
        case "brick_mod":
            Model = scr_load_model_obj(filepath);
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
