// save_file(location);
var path,file;
window_set_cursor(cr_hourglass);
path = argument0;
if directory_exists(filename_dir(path)) {
    unsaved = false;
    if(string_split_last(path,".",0) != "brk") {
        path += ".brk";
    }
    project_name = string_split_last(string_split_last(path,"\",0),".brk",1);
    project_path = path;
    
    file = file_text_open_write(path);
    file_text_write_string(file,"B R I C K  W O R K S H O P  V"+version+eol+eol);
    
    file_text_write_string(file,string(round(1000*color_get_blue(col_ambient)/255)/1000)+" "+string(round(1000*color_get_green(col_ambient)/255)/1000)+" "+string(round(1000*color_get_red(col_ambient)/255)/1000)+eol);
    file_text_write_string(file,string(round(1000*color_get_blue(col_ground)/255)/1000)+" "+string(round(1000*color_get_green(col_ground)/255)/1000)+" "+string(round(1000*color_get_red(col_ground)/255)/1000)+" "+string(alpha_ground)+eol);
    file_text_write_string(file,string(round(1000*color_get_blue(col_sky)/255)/1000)+" "+string(round(1000*color_get_green(col_sky)/255)/1000)+" "+string(round(1000*color_get_red(col_sky)/255)/1000)+eol);
    file_text_write_string(file,string(size_base)+eol);
    file_text_write_string(file,string(sun_intensity)+eol+eol);
    
    with obj_brick {
        var brickTemp;
        brickTemp = string(x)+" "+string(y)+" "+string(z)+" ";
        brickTemp += string(xs)+" "+string(ys)+" "+string(zs)+" ";
        brickTemp += string(round(1000*color_get_red(color)/255)/1000)+" ";
        brickTemp += string(round(1000*color_get_green(color)/255)/1000)+" ";
        brickTemp += string(round(1000*color_get_blue(color)/255)/1000)+" ";
        brickTemp += string(alpha);
        file_text_write_string(file,brickTemp+eol);
        if(name != "") {
            file_text_write_string(file,chr(9)+"+NAME "+string(name)+eol);
        }
        if(rotation != 0) {
            file_text_write_string(file,chr(9)+"+ROT "+string(rotation)+eol);
        }
        if(shape != "") {
            file_text_write_string(file,chr(9)+"+SHAPE "+string(shape)+eol);
        }
        
        if(north != "") {
            file_text_write_string(file,chr(9)+"+NSTICKER "+string(north)+eol);
        }
        if(east != "") {
            file_text_write_string(file,chr(9)+"+ESTICKER "+string(east)+eol);
        }
        if(south != "") {
            file_text_write_string(file,chr(9)+"+SSTICKER "+string(south)+eol);
        }
        if(west != "") {
            file_text_write_string(file,chr(9)+"+WSTICKER "+string(west)+eol);
        }
        
        if(model != "") {
            file_text_write_string(file,chr(9)+"+MODEL "+string(model)+eol);
        }
        
        if(light_range > 0) {
            var r,g,b;
            r = string(round(1000*color_get_red(light_color)/255)/1000)+" ";
            g = string(round(1000*color_get_green(light_color)/255)/1000)+" ";
            b = string(round(1000*color_get_blue(light_color)/255)/1000)+" ";
            file_text_write_string(file,chr(9)+"+LIGHT "+r+g+b+string(light_range)+eol);
        }
        
        if(collision == false) {
            file_text_write_string(file,chr(9)+"+NOCOLLISION"+eol);
        }
        
        if(string_replace_all(script," ","") != "") {
            var i;
            for(i=0;i<=string_count(chr(10),script);i+=1) {
                file_text_write_string(file,chr(9)+"+SCRIPT "+string_split(script,chr(10),i)+eol);
            }
        }
    }
    file_text_write_string(file,eol);
    with obj_team {
        file_text_write_string(file,">TEAM "+name+eol);
        
        var r,g,b;
        r = string(round(1000*color_get_red(color)/255)/1000)+" ";
        g = string(round(1000*color_get_green(color)/255)/1000)+" ";
        b = string(round(1000*color_get_blue(color)/255)/1000)+" ";
        file_text_write_string(file,chr(9)+"+COLOR "+r+g+b+eol);
    }
    
    with obj_slot {
        file_text_write_string(file,">SLOT "+name+eol);
        
        if(string_replace_all(script," ","") != "") {
            var i;
            for(i=0;i<=string_count(chr(10),script);i+=1) {
                file_text_write_string(file,chr(9)+"+SCRIPT "+string_split(script,chr(10),i)+eol);
            }
        }
    }
    
    file_text_close(file);
} else {
    return false;
}
