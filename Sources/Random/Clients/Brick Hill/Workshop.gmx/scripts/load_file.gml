// load_file(file)
var file,l,data,filename,brick,line;
file = argument0;
if file_exists(file) {
    project_name = string_split_last(string_split_last(file,"\",0),".brk",1);
    project_path = file;
    
    file = file_text_open_read(file);
    
    brick = 0;
    line = 0;
    legacy = false;
    save_ = "";
    while !file_text_eof(file) {
        line += 1;
        data = file_text_read_string(file);
        
        if(line == 1) {
            if(data != "B R I C K  W O R K S H O P  V0.2.0.0") {
                legacy = true;
            } else {
                var save_version;
                save_version = string_split(data,"B R I C K  W O R K S H O P  V",1);
                if(string_to_real(string_replace_all(save_version,".","")) > string_to_real(string_replace_all(version,".",""))) {
                    show_message("This file is for a newer version of Workshop!");
                    return false;
                }
                legacy = false;
            }
        }
        
        if(legacy) {
            if data = "[environment]" {
                data = "";
                while string_pos("[",data) != 1 {
                    file_text_readln(file);
                    data = file_text_read_string(file);
                    if string_pos("ambient",data) == 1 {text = string_split(data,"=",1);}
                    if string_pos("baseplate",data) == 1 {text = string_split(data,"=",1);}
                }
            }
            if data = "[bricks]" {
                data = "";
                save_ = "";
                while string_pos("[",data) != 1 {
                    file_text_readln(file);
                    data = file_text_read_string(file);
                    save_ += data+chr(10);
                }
            }
        } else {
            switch line {
                case 3:
                    col_ambient = color_to_3d(make_color_rgb(string_to_real(string_split(data," ",0))*255,string_to_real(string_split(data," ",1))*255,string_to_real(string_split(data," ",2))*255));
                    break;
                case 4:
                    col_ground = color_to_3d(make_color_rgb(string_to_real(string_split(data," ",0))*255,string_to_real(string_split(data," ",1))*255,string_to_real(string_split(data," ",2))*255));
                    alpha_ground = string_to_real(string_split(data," ",3));
                    break;
                case 5:
                    col_sky = color_to_3d(make_color_rgb(real(string_split(data," ",0))*255,real(string_split(data," ",1))*255,real(string_split(data," ",2))*255));
                    break;
                case 6:
                    size_base = string_to_real(data);
                    break;
                case 7:
                    sun_intensity = string_to_real(data);
                    break;
            }
            
            //current version
            if(data != "") {
                if(string_char_at(data,1) == chr(9)) {
                    //it's an attribute (brick or team)
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
                                with brick {
                                    model = string_replace(attribute,"MODEL ","");
                                    TexDownload = fetch_asset(brick.model, "brick_tex", "png", false)
                                    ModDownload = fetch_asset(brick.model, "brick_mod", "obj", false)
                                }
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
                            case "COLOR ":
                                var light,r,g,b,range;
                                light = string_replace(attribute,"COLOR ","");
                                if(string_count(" ",light) == 3) {
                                    r = string_to_real(string_split(light," ",0));
                                    g = string_to_real(string_split(light," ",1));
                                    b = string_to_real(string_split(light," ",2));
                                    r = abs(floor(r*255));
                                    g = abs(floor(g*255));
                                    b = abs(floor(b*255));
                                    
                                    brick.color = make_color_rgb(r,g,b);
                                }
                                break;
                            case "NOCOLLISION":
                                brick.collision = false;
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
                        /*if(bx == string(string_to_real(bx))) {
                            if(by == string(string_to_real(by))) {
                                if(bz == string(string_to_real(bz))) {
                                    if(bxs == string(string_to_real(bxs))) {
                                        if(bys == string(string_to_real(bys))) {
                                            if(bzs == string(string_to_real(bzs))) {
                                                if(br == string(string_to_real(br))) {
                                                    if(bg == string(string_to_real(bg))) {
                                                        if(bb == string(string_to_real(bb))) {
                                                            if(ba == string(string_to_real(ba))) {*/
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
                                                            /*}
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }*/
                    } else {
                        switch string_split(data," ",0) {
                            case ">TEAM":
                                brick = new_team(string_replace(data,">TEAM ",""),c_red);
                                break;
                            case ">SLOT":
                                brick = new_item(string_replace(data,">SLOT ",""));
                                break;
                        }
                    }
                }
            }
        }
        file_text_readln(file);
    }
    file_text_close(file);
    
    if(legacy) {
        show_message("You are importing bricks from an older version.#Please be patient while the bricks load.");
        var bricks,brick_str,data;
        bricks = 0;
        brick_str = "0";
        data = save_;
        while brick_str != "" {
            brick_str = string_split(data,chr(10),bricks);
            bricks += 1;
            if brick_str != "" && string_count(" ",string_split(brick_str,'="',1)) == 9 {
                name = string_split(brick_str,'=" ',0);
                brx = string_to_real(string_split(brick_str,' ',1));
                bry = string_to_real(string_split(brick_str,' ',2));
                brz = string_to_real(string_split(brick_str,' ',3));
                brxs = string_to_real(string_split(brick_str,' ',4));
                brys = string_to_real(string_split(brick_str,' ',5));
                brzs = string_to_real(string_split(brick_str,' ',6));
                brcl = string_to_real(string_split(brick_str,' ',7));
                bral = string_to_real(string_split(brick_str,' ',8));
                brsh = string_to_real(string_split(brick_str,' ',9));
                if (brxs mod 2 != 0) {brx += 0.5;}
                if (brys mod 2 != 0) {bry += 0.5;}
                brick = new_brick(brx-brxs/2,bry-brys/2,brz,brxs,brys,brzs,color_to_3d(brcl),bral);
                if (name != "") brick.name = name;
            }
        }
        
        /*l = instance_create(0,0,obj_loadbrick);
        l.data = save;
        l.bricks = 0;
        l.loaded = false;
        return l;*/
    } else {
        return true;
    }
} else {
    return false;
}
