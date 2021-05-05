// download(url,dest)
var d,url;
d = instance_create(0,0,obj_download);
url = argument0;
d.file = argument1;
d.result = false;

d.httprequest = httprequest_create();
httprequest_connect(d.httprequest, url, false);

return d;
