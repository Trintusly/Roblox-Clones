// paste_brick(string)
var str,data,i,last_brick;
str = argument0;
last_brick = -1;

ds_list_destroy(brick_selection);
brick_selection = ds_list_create();

for(i=0; i<string_count(eol,str); i+=1) {
    data = string_split(str,eol,i);
    if(string_char_at(data,1) == chr(9)) {
        //it's a brick attribute
        var attribute;
        attribute = string_replace(data,chr(9)+"+","");
        if(brick > 0) {
            switch(string_split(attribute," ",0)+" ") {
                case "NAME ":
                    brick.name = string_replace(attribute,"NAME ","");
                    break;
                case "ROT ":
                    brick.rotation = string_to_real(string_replace(attribute,"ROT ",""));
                    break;
                case "SHAPE ":
                    brick.shape = string_replace(attribute,"SHAPE ","");
                    break;
                case "NSTICKER ":
                    brick.north = string(string_to_real(string_replace(attribute,"NSTICKER ","")));
                    break;
                case "ESTICKER ":
                    brick.east = string(string_to_real(string_replace(attribute,"ESTICKER ","")));
                    break;
                case "SSTICKER ":
                    brick.south = string(string_to_real(string_replace(attribute,"SSTICKER ","")));
                    break;
                case "WSTICKER ":
                    brick.west = string(string_to_real(string_replace(attribute,"WSTICKER ","")));
                    break;
                case "MODEL ":
                    brick.model = string(string_to_real(string_replace(attribute,"MODEL ","")));
                    break;
                case "LIGHT ":
                    var light,r,g,b,range;
                    light = string_replace(attribute,"LIGHT ","");
                    if(string_count(" ",light) == 3) {
                        r = string_to_real(string_split(light," ",0));
                        g = string_to_real(string_split(light," ",1));
                        b = string_to_real(string_split(light," ",2));
                        r = abs(floor(r*255));
                        g = abs(floor(g*255));
                        b = abs(floor(b*255));
                        
                        range = string_to_real(string_split(light," ",3));
                        brick.light_color = make_color_rgb(r,g,b);
                        brick.light_range = range;
                    }
                    break;
                case "SCRIPT ":
                    brick.script += string_replace(attribute,"SCRIPT ","")+chr(10);
                    break;
            }
        }
    } else {
        brick = 0; //precaution
        //it's likely a brick
        if(string_count(" ",data) == 9) {
            //it is a correct brick
            var bx,by,bz,bxs,bys,bzs,br,bg,bb,ba;
            bx = string_split(data," ",0);
            by = string_split(data," ",1);
            bz = string_split(data," ",2);
            bxs = string_split(data," ",3);
            bys = string_split(data," ",4);
            bzs = string_split(data," ",5);
            br = string_split(data," ",6);
            bg = string_split(data," ",7);
            bb = string_split(data," ",8);
            ba = string_split(data," ",9);
            bx = string_to_real(bx);
            by = string_to_real(by);
            bz = string_to_real(bz);
            bxs = string_to_real(bxs);
            bys = string_to_real(bys);
            bzs = string_to_real(bzs);
            br = abs(floor(string_to_real(br)*255));
            bg = abs(floor(string_to_real(bg)*255));
            bb = abs(floor(string_to_real(bb)*255));
            ba = string_to_real(ba);
            brick = new_brick(bx,by,bz,bxs,bys,bzs,make_color_rgb(br,bg,bb),ba);
            ds_list_add(brick_selection,brick);
            last_brick = brick;
        }
    }
}
return last_brick;
