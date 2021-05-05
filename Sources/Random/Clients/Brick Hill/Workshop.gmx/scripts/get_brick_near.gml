// get_brick_near(brick)
var brick,dist,list;
brick = argument0;

dist = ds_map_create();
ds_map_add(dist,power(xfrom-brick.x,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z,2),string(brick.x)+","+string(brick.y)+","+string(brick.z));
ds_map_add(dist,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z,2),string(brick.x+brick.xs)+","+string(brick.y)+","+string(brick.z));
ds_map_add(dist,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z,2),string(brick.x+brick.xs)+","+string(brick.y+brick.ys)+","+string(brick.z));
ds_map_add(dist,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z-brick.zs,2),string(brick.x+brick.xs)+","+string(brick.y+brick.ys)+","+string(brick.z+brick.zs));
ds_map_add(dist,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z-brick.zs,2),string(brick.x+brick.xs)+","+string(brick.y)+","+string(brick.z+brick.zs));
ds_map_add(dist,power(xfrom-brick.x,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z-brick.zs,2),string(brick.x)+","+string(brick.y+brick.ys)+","+string(brick.z+brick.zs));
ds_map_add(dist,power(xfrom-brick.x,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z,2),string(brick.x)+","+string(brick.y+brick.ys)+","+string(brick.z));
ds_map_add(dist,power(xfrom-brick.x,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z-brick.zs,2),string(brick.x)+","+string(brick.y)+","+string(brick.z+brick.zs));

list = ds_list_create();
ds_list_add(list,power(xfrom-brick.x,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z,2));
ds_list_add(list,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z,2));
ds_list_add(list,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z,2));
ds_list_add(list,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z-brick.zs,2));
ds_list_add(list,power(xfrom-brick.x-brick.xs,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z-brick.zs,2));
ds_list_add(list,power(xfrom-brick.x,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z-brick.zs,2));
ds_list_add(list,power(xfrom-brick.x,2)+power(yfrom-brick.y-brick.ys,2)+power(zfrom-brick.z,2));
ds_list_add(list,power(xfrom-brick.x,2)+power(yfrom-brick.y,2)+power(zfrom-brick.z-brick.zs,2));

ds_list_sort(list,true);
var coords;
coords = ds_map_find_value(dist,ds_list_find_value(list,0));
nearX = string_to_real(string_split(coords,",",0));
nearY = string_to_real(string_split(coords,",",1));
nearZ = string_to_real(string_split(coords,",",2));

ds_map_destroy(dist);
ds_list_destroy(list);
