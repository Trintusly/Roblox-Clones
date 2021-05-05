// get_selection()
if ds_list_size(brick_selection) > 0 {
    var b,br;
    b = ds_list_find_value(brick_selection,0);
    if instance_exists(b) {
        minX = b.x;
        minY = b.y;
        minZ = b.z;
        maxX = b.x+b.xs;
        maxY = b.y+b.ys;
        maxZ = b.z+b.zs;
        for(br = 1; br < ds_list_size(brick_selection); br += 1) {
            b = ds_list_find_value(brick_selection,br);
            minX = min(minX,b.x);
            minY = min(minY,b.y);
            minZ = min(minZ,b.z);
            maxX = max(maxX,b.x+b.xs);
            maxY = max(maxY,b.y+b.ys);
            maxZ = max(maxZ,b.z+b.zs);
        }
    } else {
        minX = 0;
        minY = 0;
        minZ = 0;
        maxX = 0;
        maxY = 0;
        maxZ = 0;
    }
}
