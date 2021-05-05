// redo()
if ds_list_size(redoList) > 0 {
    r = true;
    
    time = ds_list_find_value(redoTime,ds_list_size(history)-1);
    
    while ds_list_find_value(redoTime,ds_list_size(history)-1) == time && ds_list_size(redoTime) > 0 {
        var key;
        key = ds_list_find_value(redoList,ds_list_size(redoList)-1);
        val = ds_list_find_value(redoValue,ds_list_size(redoList)-1);
        
        switch key {
            case "brick":
                old_id = real(string_split(val," ",0));
                brick_select = paste_brick(string_replace(val,string(old_id)+" ",""));
                for(h = 0; h < ds_list_size(redoValue)-1; h += 1) {
                    ds_list_replace(redoValue,h,string_replace(ds_list_find_value(redoValue,h),string(old_id),string(brick_select)));
                }
                break;
            case "team":
                color = string_split(val," ",0);
                new_team(string_replace(val,color+" ",""),real(color));
                break;
            case "item":
                name = string_split(val,chr(10),0);
                item = new_item(name);
                item.script = string_split(val,chr(10),1);
                break;
            case "brick pos":
                brick = real(string_split(val," ",0));
                brickX = real(string_split(val," ",1));
                brickY = real(string_split(val," ",2));
                brickZ = real(string_split(val," ",3));
                brick.x = brickX;
                brick.y = brickY;
                brick.z = brickZ;
                break;
            case "brick size":
                brick = real(string_split(val," ",0));
                brickXS = real(string_split(val," ",1));
                brickYS = real(string_split(val," ",2));
                brickZS = real(string_split(val," ",3));
                brickX = real(string_split(val," ",4));
                brickY = real(string_split(val," ",5));
                brickZ = real(string_split(val," ",6));
                brick.xs = brickXS;
                brick.ys = brickYS;
                brick.zs = brickZS;
                brick.x = brickX;
                brick.y = brickY;
                brick.z = brickZ;
                break;
            case "ground col":
                col_ground = val;
                break;
            case "base size":
                size_base = val;
                break;
            case "ambient":
                col_ambient = val;
                break;
            case "sky col":
                col_sky = val;
                break;
            case "sun":
                sun_intensity = val;
                break;
            case "team name":
                team = real(string_split(val," ",0));
                team.name = string_split(val," ",1);
                break;
            case "team color":
                team = real(string_split(val," ",0));
                team.color = real(string_split(val," ",1));
                break;
            case "brick color":
                brick = real(string_split(val," ",0));
                brick.color = real(string_split(val," ",1));
                break;
            case "brick light range":
                brick = real(string_split(val," ",0));
                brick.light_range = real(string_split(val," ",1));
                break;
            case "brick light":
                brick = real(string_split(val," ",0));
                brick.light_color = real(string_split(val," ",1));
                break;
            case "brick name":
                brick = real(string_split(val," ",0));
                brick.name = string_replace(val,string(brick)+" ","");;
                break;
            case "brick rotation":
                brick = real(string_split(val," ",0));
                brick.rotation = real(string_split(val," ",1));
                break;
        }
        ds_list_delete(redoValue,ds_list_size(redoList)-1);
        ds_list_delete(redoTime,ds_list_size(redoList)-1);
        ds_list_delete(redoList,ds_list_size(redoList)-1);
    }
}
