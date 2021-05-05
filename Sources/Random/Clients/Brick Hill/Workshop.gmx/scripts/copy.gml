// copy()
if page == page_world {
    var br,brick,brickTemp;
    brickTemp = "";
    for(br = 0; br < ds_list_size(brick_selection); br += 1) {
        brick = ds_list_find_value(brick_selection,br);
        with brick {
            brickTemp += string(x)+" "+string(y)+" "+string(z)+" ";
            brickTemp += string(xs)+" "+string(ys)+" "+string(zs)+" ";
            brickTemp += string(round(1000*color_get_red(color)/255)/1000)+" ";
            brickTemp += string(round(1000*color_get_green(color)/255)/1000)+" ";
            brickTemp += string(round(1000*color_get_blue(color)/255)/1000)+" ";
            brickTemp += string(alpha);
            brickTemp += eol;
            if(name != "") {
                brickTemp += chr(9)+"+NAME "+string(name)+" - Copy"+eol;
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
    }
    clipboard_set_text(brickTemp);
}
