// undo()
if ds_list_size(history) > 0 {
    u = true;
    
    time = ds_list_find_value(hist_time,ds_list_size(history)-1);
    
    while ds_list_find_value(hist_time,ds_list_size(history)-1) == time && ds_list_size(hist_time) > 0 {
        var key;
        key = ds_list_find_value(history,ds_list_size(history)-1);
        val = ds_list_find_value(hist_val,ds_list_size(history)-1);
        
        switch key {
            case "brick":
                brick = real(val);
                var brickTemp;
                with brick {
                    brickTemp = string(x)+" "+string(y)+" "+string(z)+" ";
                    brickTemp += string(xs)+" "+string(ys)+" "+string(zs)+" ";
                    brickTemp += string(round(1000*color_get_red(color)/255)/1000)+" ";
                    brickTemp += string(round(1000*color_get_green(color)/255)/1000)+" ";
                    brickTemp += string(round(1000*color_get_blue(color)/255)/1000)+" ";
                    brickTemp += string(alpha);
                    brickTemp += eol;
                    if(name != "") {
                        brickTemp += chr(9)+"+NAME "+string(name)+eol;
                    }
                    if(rotation != 0) {
                        brickTemp += chr(9)+"+ROT "+string(rotation)+eol;
                    }
                    if(shape != "") {
                        brickTemp += chr(9)+"+SHAPE "+string(shape)+eol;
                    }
                    
                    if(north != "") {
                        brickTemp += chr(9)+"+NSTICKER "+string(north)+eol;
                    }
                    if(east != "") {
                        brickTemp += chr(9)+"+ESTICKER "+string(east)+eol;
                    }
                    if(south != "") {
                        brickTemp += chr(9)+"+SSTICKER "+string(south)+eol;
                    }
                    if(west != "") {
                        brickTemp += chr(9)+"+WSTICKER "+string(west)+eol;
                    }
                    
                    if(model != "") {
                        brickTemp += chr(9)+"+MODEL "+string(model)+eol;
                    }
                    
                    if(light_range > 0) {
                        var r,g,b;
                        r = string(round(1000*color_get_red(light_color)/255)/1000)+" ";
                        g = string(round(1000*color_get_green(light_color)/255)/1000)+" ";
                        b = string(round(1000*color_get_blue(light_color)/255)/1000)+" ";
                        brickTemp += chr(9)+"+LIGHT "+r+g+b+string(light_range)+eol;
                    }
                    
                    if(string_replace_all(script," ","") != "") {
                        var i;
                        for(i=0;i<=string_count(chr(10),script);i+=1) {
                            brickTemp += chr(9)+"+SCRIPT "+string_split(script,chr(10),i)+eol;
                        }
                    }
                }
                redo_add("brick",string(brick)+" "+brickTemp);
                with brick {
                    brickID = ds_list_find_index(global.brickList,self.id);
                    ds_list_delete(global.brickList,brickID);
                    brickID = ds_list_find_index(obj_control.brick_selection,self.id);
                    ds_list_delete(obj_control.brick_selection,brickID);
                    GmnDestroyBody(global.set,body);
                    instance_destroy();
                }
                break;
            case "team":
                team = real(val);
                if(instance_exists(team)) {
                    redo_add("team",string(team.color)+" "+team.name);
                    ds_list_delete(global.teamList,ds_list_find_index(global.teamList,team));
                    with team {
                        instance_destroy();
                    }
                }
                break;
            case "item":
                item = real(val);
                if(instance_exists(item)) {
                    redo_add("item",item.name+chr(10)+string(item.script));
                    ds_list_delete(global.slotList,ds_list_find_index(global.slotList,item));
                    with item {
                        instance_destroy();
                    }
                }
                break;
            case "brick pos":
                brick = real(string_split(val," ",0));
                if(instance_exists(brick)) {            
                    redo_add("brick pos",string(brick)+" "+string(brick.x)+" "+string(brick.y)+" "+string(brick.z));
                    brickX = real(string_split(val," ",1));
                    brickY = real(string_split(val," ",2));
                    brickZ = real(string_split(val," ",3));
                    brick.x = brickX;
                    brick.y = brickY;
                    brick.z = brickZ;
                }
                break;
            case "brick size":
                brick = real(string_split(val," ",0));
                if(instance_exists(brick)) { 
                    redo_add("brick size",string(brick)+" "+string(brick.xs)+" "+string(brick.ys)+" "+string(brick.zs)+" "+string(brick.x)+" "+string(brick.y)+" "+string(brick.z));
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
                }
                break;
            case "ground_color":
                redo_add("ground col",col_ground);
                col_ground = val;
                break;
            case "size_base":
                redo_add("base size",base_size);
                size_base = val;
                break;
            case "ambient":
                redo_add("ambient",col_ambient);
                col_ambient = val;
                break;
            case "sky_color":
                redo_add("sky col",col_sky);
                col_sky = val;
                break;
            case "sun_intensity":
                redo_add("sun",sun_intensity);
                sun_intensity = val;
                break;
            case "team name":
                team = real(string_split(val," ",0));
                if(instance_exists(team)) {
                    redo_add("team name",string(team)+" "+team.name);
                    team.name = string_replace(val,string(team)+" ","");
                }
                break;
            case "team color":
                team = real(string_split(val," ",0));
                if(instance_exists(team)) {
                    redo_add("team color",string(team)+" "+string(team.color));
                    team.color = real(string_split(val," ",1));
                }
                break;
            case "brick color":
                brick = real(string_split(val," ",0));
                if(instance_exists(brick)) {
                    redo_add("brick color",string(brick)+" "+string(brick.color));
                    brick.color = real(string_split(val," ",1));
                }
                break;
            case "brick light range":
                brick = real(string_split(val," ",0));
                if(instance_exists(brick)) {
                    redo_add("brick light range",string(brick)+" "+string(brick.light_range));
                    brick.light_range = real(string_split(val," ",1));
                }
                break;
            case "brick light":
                brick = real(string_split(val," ",0));
                if(instance_exists(brick)) {
                    redo_add("brick light",string(brick)+" "+string(brick.light_color));
                    brick.light_color = real(string_split(val," ",1));
                }
                break;
            case "brick name":
                brick = real(string_split(val," ",0));
                if(instance_exists(brick)) {
                    redo_add("brick name",string(brick)+" "+brick.name);
                    brick.name = string_replace(val,string(brick)+" ","");
                }
                break;
            case "brick rotation":
                brick = real(string_split(val," ",0));
                if(instance_exists(brick)) {
                    redo_add("brick rotation",string(brick)+" "+string(brick.rotation));
                    brick.rotation = real(string_split(val," ",1));
                }
                break;
        }
        ds_list_delete(hist_val,ds_list_size(history)-1);
        ds_list_delete(hist_time,ds_list_size(history)-1);
        ds_list_delete(history,ds_list_size(history)-1);
    }
}
