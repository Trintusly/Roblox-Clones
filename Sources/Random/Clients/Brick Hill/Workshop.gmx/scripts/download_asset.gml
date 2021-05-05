// download_asset(url, assetId, filepath)
var d, url;

d = instance_create(0, 0, obj_asset_download);
url = argument0
d.assetId = argument1
d.file = argument2
d.httprequest = httprequest_create();
httprequest_connect(d.httprequest, url, false);

return d;
