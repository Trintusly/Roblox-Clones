// loadBRK(file)
var blocked_funcs,file,l,data,filename,brick,line;

blocked_funcs[0] = "execute_file";
blocked_funcs[1] = "execute_program";
blocked_funcs[2] = "execute_shell";
blocked_funcs[3] = "cd_";
blocked_funcs[4] = "filename_";
blocked_funcs[5] = "file_";
blocked_funcs[6] = "io_";
blocked_funcs[7] = "path_";
blocked_funcs[8] = "ini_";
blocked_funcs[9] = "font_";
blocked_funcs[10] = "registry_";
blocked_funcs[11] = "external_";
blocked_funcs[12] = "window_";

file = argument0;
if file_exists(file) {
    file = file_text_open_read(file);
    
    brick = 0;
    line = 0;
    while !file_text_eof(file) {
        line += 1;
        data = file_text_read_string(file);
        
        switch line {
            case 1:
                // Hard coded support for 0.2.0.0 set files
                if(data != "B R I C K  W O R K S H O P  V0.2.0.0" && data != "B R I C K  W O R K S H O P  V"+version) {
                    messageAll("#");
                    messageAll("ERROR: This set was created using an incompatible#version of Brick Hill.");
                    messageAll("#");
                    return false;
                }
                break;
            case 3:
                environmentSetAmbient(color_to_3d(make_color_rgb(string_to_real(string_split(data," ",0))*255,string_to_real(string_split(data," ",1))*255,string_to_real(string_split(data," ",2))*255)));
                break;
            case 4:
                environmentSetBaseplateColor(color_to_3d(make_color_rgb(string_to_real(string_split(data," ",0))*255,string_to_real(string_split(data," ",1))*255,string_to_real(string_split(data," ",2))*255)));
                BasePlateAlpha = string_to_real(string_split(data," ",3));
                break;
            case 5:
                environmentSetSky(color_to_3d(make_color_rgb(real(string_split(data," ",0))*255,real(string_split(data," ",1))*255,real(string_split(data," ",2))*255)));
                break;
            case 6:
                environmentSetBaseplateSize(string_to_real(data));
                break;
            case 7:
                SunIntensity = string_to_real(data);
                break;
        }
        
        //current version
        if(data != "") {
            
            if(string_char_at(data,1) == chr(9)) {
                //it's an attribute (brick or team)
                var attribute;
                attribute = string_replace(data,chr(9)+"+","");
                if(brick > 0) {
                    var script_final, script_clean;
                    script_final = "";
                    script_clean = true;
                
                    switch(string_split(attribute," ",0)+" ") {
                        case "NAME ":
                            brick.Name = string_replace(attribute,"NAME ","");
                            break;
                        case "ROT ":
                            brick.Rotation = string_to_real(string_replace(attribute,"ROT ",""));
                            break;
                        case "SHAPE ":
                            brick.Shape = string_replace(attribute,"SHAPE ","");
                            break;
                        case "NSTICKER ":
                            brick.NorthSticker = string(string_to_real(string_replace(attribute,"NSTICKER ","")));
                            break;
                        case "ESTICKER ":
                            brick.EastSticker = string(string_to_real(string_replace(attribute,"ESTICKER ","")));
                            break;
                        case "SSTICKER ":
                            brick.SouthSticker = string(string_to_real(string_replace(attribute,"SSTICKER ","")));
                            break;
                        case "WSTICKER ":
                            brick.WestSticker = string(string_to_real(string_replace(attribute,"WSTICKER ","")));
                            break;
                        case "MODEL ":
                            brick.Model = string(string_to_real(string_replace(attribute,"MODEL ","")));
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
                                brick.LightColor = make_color_rgb(r,g,b);
                                brick.LightRange = range;
                            }
                            break;
                        case "COLOR ":
                            var color,r,g,b,col;
                            color = string_replace(attribute,"COLOR ","");
                            if(string_count(" ",color) == 3) {
                                r = string_to_real(string_split(color," ",0));
                                g = string_to_real(string_split(color," ",1));
                                b = string_to_real(string_split(color," ",2));
                                r = floor(r*255);
                                g = floor(g*255);
                                b = floor(b*255);
                                col = make_color_rgb(r,g,b);
                                
                                brick.Color = col;
                            }
                            break;
                        case "NOCOLLISION ":
                            brick.Collision = false;
                            break;
                        case "SCRIPT ":
                            //check blocked keywords
                            var script_line, check_idx;
                            script_line = string_replace(attribute,"SCRIPT ","")+chr(10);
                            check_idx = 0;
                            while (check_idx < 12) {
                                var check_block;
                                check_block = blocked_funcs[check_idx];
                                
                                if string_pos(check_block, script_line) != 0 {
                                    messageAll("#");
                                    messageAll("WARNING: Unsafe logic detected on line " + string(line));
                                    messageAll(script_line);
                                    messageAll("#");
                                    messageAll("ERROR: Set loading has been haulted.");
                                    messageAll("#");
                                    brick.Script = "";
                                    return false;
                                }
                                
                                check_idx += 1;
                            }
                            brick.Script += script_line;
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
                    brick = newBrick(bx,by,bz,bxs,bys,bzs,make_color_rgb(br,bg,bb),ba);
                } else {
                    switch string_split(data," ",0)+" " {
                        case ">TEAM ":
                            brick = newTeam(string_replace(data,">TEAM ",""),c_red);
                            break;
                        case ">SLOT ":
                            brick = new_item(string_replace(data,">SLOT ",""));
                            break;
                    }
                }
            }
        }
        file_text_readln(file);
    }
    file_text_close(file);
    
    return true;
} else {
    return false;
}
