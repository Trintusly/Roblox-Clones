// get(url)
var d,url;
d = instance_create(0,0,obj_get);
url = argument0;
d.result = false;

d.httprequest = httprequest_create();
httprequest_connect(d.httprequest, url, false);

return d;
