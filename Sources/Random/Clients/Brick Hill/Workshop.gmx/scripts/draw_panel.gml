// draw_panel()
var xx,w,h,str;
yy=-sb_val[scroll_right];
xx=floor(view_wview[view_interface]-properties_w)+1;
w=properties_w;
h=view_hview[view_interface];

if(right_panel_size > h) {
    shi = 16;
} else {
    shi = 0;
}

draw_set_alpha(1);
draw_set_color(col_main);
draw_rectangle(xx,0,xx+w,view_hview[view_interface],0);
if mouse_x > xx && mouse_x < xx+w-16-25 && mouse_y > 0 && mouse_y < view_hview[view_interface] {
    window_hover = "";
}

if (brick_select == -1 || !instance_exists(brick_select)) {
    //brick tab
    if draw_button2("tab_bricks","",-1,xx,yy+1,view_wview[view_interface]-xx-shi,34,0) {tab_bricks = !tab_bricks;}
    draw_set_font(fnt_bold);
    //if(tab_bricks) {draw_text(xx+4,yy+4,"-");} else {draw_text(xx+4,yy+4,"+");}
    draw_set_color(c_white);
    draw_text(xx+10,yy+2,"Bricks");
    
    draw_set_color(main_outline);
    draw_set_alpha(1);
    draw_line(xx,yy+34,view_wview[view_interface]-shi,yy+34);
    yy += 34;
    
    if(tab_bricks) {
        draw_set_font(fnt_regular);
        var brick,br,barh,scroll_h;
        nextY = yy+8;
        nextX = xx+11;
        
        barh = 30;//max(24,string_height(" ")+4);
        scroll_h = 360;
        
        draw_box(nextX,nextY,view_wview[view_interface]-10-shi,nextY+scroll_h,0);
        next_y = nextY+6;
        /*next_y = yy;
        barh = max(24,string_height(" ")+4);
        scroll_h = 360;
        draw_set_color(0);
        draw_set_alpha(0.2);
        draw_rectangle(xx+8,next_y,xx+w-8,next_y+scroll_h,0);*/
        for (br=floor(sb_val[scroll_up]/barh);br<ds_list_size(global.brickList);br+=1) {
            if((br-floor(sb_val[scroll_up]/barh)+1)*barh < scroll_h) { //-barh
            //if(next_y < scroll_h) {
                brick = ds_list_find_value(global.brickList,br);
                if(br mod 2 == 0) {
                    draw_set_color(main_faded);
                    draw_box(nextX+6,next_y,nextX+w-42-shi,next_y+24,0);
                    next_y -= 24;
                }
                var click;
                click = draw_tab("tab_brick_"+string(brick.id),brick.name,nextX+6,next_y,w-46-shi,24,10);
                if click {
                    if !keyboard_check(vk_control) {
                        brick_select = brick;
                        ds_list_clear(brick_selection);
                    }
                    if ds_list_find_index(brick_selection,brick) == -1 {
                        ds_list_add(brick_selection,brick);
                    }
                } else if click == -1 {
                    brick_select = brick;
                    ds_list_clear(brick_selection);
                    if ds_list_find_index(brick_selection,brick_select) == -1 {
                        ds_list_add(brick_selection,brick_select);
                    }
                    switch show_menu("Copy|Delete|-|Cancel",2) {
                        case 0:
                            copy();
                            break;
                        case 1:
                            delete();
                            break;
                    }
                }
                
                next_y += 6;
            } else {
                break;
            }
        }
        
        scrollbar_draw(scroll_up,xx+w-25-shi,nextY+2,scroll_h-4,(ds_list_size(global.brickList)+1)*barh);
        yy = nextY+scroll_h+6;
    }
    
    //world tab
    draw_set_color(col_main);
    if draw_button2("tab_world","",-1,xx,yy+1,view_wview[view_interface]-xx-shi,34,0) {tab_world = !tab_world;}
    draw_set_font(fnt_bold);
    //if(tab_bricks) {draw_text(xx+4,yy+4,"-");} else {draw_text(xx+4,yy+4,"+");}
    draw_set_color(c_white);
    draw_text(xx+10,yy+2,"World");
    
    draw_set_color(main_outline);
    draw_set_alpha(1);
    draw_line(xx,yy+34,view_wview[view_interface]-shi,yy+34);
    yy += 34;
    
    
    if(tab_world) {
        draw_set_alpha(1);
        draw_set_color(c_white);
        draw_set_font(fnt_medium);
        draw_text(xx+26,yy+4,"Baseplate:");
        draw_set_font(fnt_regular);
        col_ground = draw_color_button("world_ground","",col_ground,xx+54,yy+40,28,28,1);
        /*if draw_color_button("world_ground","",col_ground,xx+54,yy+40,28,28,1) {
            paint_popup_focus = "world_ground";
            paint_popup_color = col_ground;
            popup = true;
        }
        if paint_popup_focus = "world_ground" {
            col_ground = paint_popup_color;
        }*/
        
        draw_set_color(c_white);
        draw_text(next_x+6,yy+41,"Color");
        var size_old;
        size_old = size_base;
        size_base = string_to_real(draw_input("world_baseplate",size_base,"Baseplate size:",xx+54,next_y+8,84,28,1));
        if(size_old != size_base) {
            //history_add("ground_size",size_old);
        }
        draw_set_color(c_white);
        draw_text(next_x+6,yy+77,"Size");
        
        draw_set_font(fnt_medium);
        draw_text(xx+26,next_y+24,"Background:");
        var nextY;
        nextY = next_y+24;
        draw_set_font(fnt_regular);
        col_ambient = color_to_3d(draw_color_button("world_ambient","",color_to_3d(col_ambient),xx+54,nextY+36,28,28,1));
        //if draw_color_button("world_ambient","",color_to_3d(col_ambient),xx+54,nextY+36,28,28,1) {
            //col_ambient = color_to_3d(get_color(color_to_3d(col_ambient)));
        //}
        draw_set_color(c_white);
        draw_text(next_x+6,nextY+37,"Ambient");
        col_sky = color_to_3d(draw_color_button("world_sky","",color_to_3d(col_sky),xx+54,next_y+8,28,28,1));
        //if draw_color_button("world_sky","",color_to_3d(col_sky),xx+54,next_y+8,28,28,1) {
            //col_sky = color_to_3d(get_color(color_to_3d(col_sky)));
        //}
        draw_set_color(c_white);
        draw_text(next_x+6,nextY+73,"Sky");
        var sun_old;
        sun_old = sun_intensity;
        sun_intensity = string_to_real(draw_input("world_intensity",sun_intensity,"Sun intensity:",xx+54,next_y+8,84,28,1));
        if(sun_old != sun_intensity) {
            //history_add("sun_intensity",sun_old);
        }
        draw_set_color(c_white);
        draw_text(next_x+6,nextY+109,"Sun Intensity");
        
        yy = next_y+34;//nextY+119;
    }
    
    //teams tab
    draw_set_color(col_main);
    if draw_button2("tab_teams","",-1,xx,yy+1,view_wview[view_interface]-xx-shi,34,0) {tab_teams = !tab_teams;}
    draw_set_font(fnt_bold);
    draw_set_color(c_white);
    draw_text(xx+10,yy+2,"Teams");
    
    draw_set_color(main_outline);
    draw_set_alpha(1);
    draw_line(xx,yy+34,view_wview[view_interface]-shi,yy+34);
    yy += 34;
    
    if(tab_teams) {
        draw_set_font(fnt_regular);
        var team,tm,barh,scroll_h;
        nextY = yy+8;
        nextX = xx+11;
        
        barh = 30;
        scroll_h = 360;
        
        if draw_button2("new_team","+",-1,nextX,nextY,32,32,0) {new_team("team"+string(ds_list_size(global.teamList)),col_paint);}
        nextY = next_y+8;
        
        draw_set_color(main_outline);
        draw_set_alpha(1);
        draw_box(nextX,nextY,view_wview[view_interface]-10-shi,nextY+scroll_h,0);
        next_y = nextY+6;
        
        for (tm=floor(sb_val[scroll_teams]/barh);tm<ds_list_size(global.teamList);tm+=1) {
            if((tm-floor(sb_val[scroll_teams]/barh)+1)*barh < scroll_h) {
                team = ds_list_find_value(global.teamList,tm);
                if(tm mod 2 == 0) {
                    draw_set_color(main_faded);
                    draw_box(nextX+6,next_y,nextX+w-42-shi,next_y+24,0);
                    next_y -= 24;
                }
                var team_tab;
                team_tab = draw_tab("tab_team_"+string(team.id),team.name,nextX+6,next_y,w-46-shi,24,10);
                if team_tab {
                    team.name = get_string("Team name:",team.name);
                } else if team_tab == -1 {
                    switch show_menu("Delete|-|Cancel",1) {
                        case 0:
                            with team {instance_destroy();}
                            ds_list_delete(global.teamList,tm);
                            exit;
                            break;
                        case 1:
                            break;
                    }
                }
                team.color = draw_color_button("team_color_"+string(team.id),"",team.color,next_x-22,next_y-22,20,20,1);
                //if draw_color_button("team_color_"+string(team.id),"",team.color,next_x-22,next_y-22,20,20,1) {
                    //team.color = get_color(team.color);
                //}
                next_y += 2;
                next_x += 2;
                
                next_y += 6;
            } else {
                break;
            }
        }
        
        scrollbar_draw(scroll_teams,xx+w-25-shi,nextY+2,scroll_h-4,(ds_list_size(global.teamList)+1)*barh);
        yy = nextY+scroll_h+6;
    }
    
    //slots tab
    draw_set_color(col_main);
    if draw_button2("tab_slots","",-1,xx,yy+1,view_wview[view_interface]-xx-shi,34,0) {tab_slots = !tab_slots;}
    draw_set_font(fnt_bold);
    draw_set_color(c_white);
    draw_text(xx+10,yy+2,"Items");
    
    draw_set_color(main_outline);
    draw_set_alpha(1);
    draw_line(xx,yy+34,view_wview[view_interface]-shi,yy+34);
    yy += 34;
    
    if(tab_slots) {
        draw_set_font(fnt_regular);
        var slot,sl,barh,scroll_h;
        nextY = yy+8;
        nextX = xx+11;
        
        barh = 30;
        scroll_h = 360;
        
        if draw_button2("new_slot","+",-1,nextX,nextY,32,32,0) {
            slot_select = new_item("item"+string(ds_list_size(global.slotList)));
        }
        nextY = next_y+8;
        
        draw_set_color(main_outline);
        draw_set_alpha(1);
        draw_box(nextX,nextY,view_wview[view_interface]-10-shi,nextY+scroll_h,0);
        next_y = nextY+6;
        
        for (sl=floor(sb_val[scroll_slots]/barh);sl<ds_list_size(global.slotList);sl+=1) {
            if((sl-floor(sb_val[scroll_slots]/barh)+1)*barh < scroll_h) {
                slot = ds_list_find_value(global.slotList,sl);
                if(sl mod 2 == 0) {
                    draw_set_color(main_faded);
                    draw_box(nextX+6,next_y,nextX+w-42-shi,next_y+24,0);
                    next_y -= 24;
                }
                //if draw_tab("tab_slot_"+string(slot.id),slot.name,nextX+6,next_y,w-46-shi,24,10) {
                //    slot_select = slot.id;
                //}
                var slot_tab;
                slot_tab = draw_tab("tab_slot_"+string(slot.id),slot.name,nextX+6,next_y,w-46-shi,24,10);
                if slot_tab {
                    slot_select = slot.id;
                } else if slot_tab == -1 {
                    switch show_menu("Delete|-|Cancel",1) {
                        case 0:
                            with slot {instance_destroy();}
                            ds_list_delete(global.slotList,sl);
                            exit;
                            break;
                        case 1:
                            break;
                    }
                }
                next_y += 6;
            } else {
                break;
            }
        }
        
        scrollbar_draw(scroll_slots,xx+w-25-shi,nextY+2,scroll_h-4,(ds_list_size(global.slotList)+1)*barh);
        yy = nextY+scroll_h+6;
        
        if(instance_exists(slot_select) && slot_select != -1) {
            //draw the info
            var slot;
            slot = slot_select;
            draw_set_font(fnt_medium);
            draw_set_color(c_white);
            //slot.name = draw_input("slot_name",slot.name,"Item Name:",nextX+8,yy+10,92,32,0);
            slot.name = draw_input("slot_name",slot.name,"Change item name:",nextX+8,yy+10,84,28,0);
            
            /*draw_set_color(col_main)
            if(page != page_script) {
                if draw_button2("slot_script_edit","Edit script...",-1,nextX+8,next_y+24,120,24,1) {
                    page = page_script;
                    script_textbox.text = slot.script;
                }
            } else {
                if draw_button2("slot_script_save","Save script...",-1,nextX+8,next_y+24,120,24,1) {
                    page = page_world;
                    slot.script = script_textbox.text;
                }
            }*/
            if(page != page_script) {
                draw_set_color(button_blue);
                if draw_button2("slot_script_edit","",19,nextX+8,next_y+24,26,26,1) {
                    page = page_script;
                    script_textbox.text = slot.script;
                }
            } else {
                draw_set_color(button_blue);
                if draw_button2("slot_script_save","",19,nextX+8,next_y+24,26,26,1) {
                    page = page_world;
                    slot.script = script_textbox.text;
                }
            }
            
            yy = next_y+10;
        }
    }
} else {
    var brick,left_x,right_x;
    brick = brick_select;
    draw_set_alpha(1);
    draw_set_color(c_white);
    draw_set_font(fnt_bold);
    draw_text(xx+4,yy+4,"Brick - "+brick.name);
    draw_set_color(main_outline);
    draw_set_alpha(1);
    draw_line(xx,yy+34,view_wview[view_interface]-shi,yy+34);
    
    draw_box(xx+45,yy+44,xx+45+220,yy+44+220,0);
    if background_exists(bkg_preview) {
        draw_background_ext(bkg_preview,xx+45,yy+44,220/background_get_width(bkg_preview),220/background_get_height(bkg_preview),0,c_white,1);
    }
    next_y += 10;
    
    draw_set_color(c_white);
    draw_set_font(fnt_regular);
    draw_text(xx+26,next_y,"General");
    next_y += string_height("General")+16;;
    next_x = xx+26+28;
    
    brick.name = draw_input("brick_name",brick.name,"Change brick name:",xx+26+28,next_y,84,28,0);
    draw_text(next_x+8,next_y-28,"Name");
    
    new_pos = draw_input("brick_position",string(brick.x)+","+string(brick.y)+","+string(brick.z),"Change brick position:",xx+26+28,next_y+10,84,28,0);
    draw_text(next_x+8,next_y-28,"Location");
    
    new_size = draw_input("brick_size",string(brick.xs)+","+string(brick.ys)+","+string(brick.zs),"Change brick size:",xx+26+28,next_y+10,84,28,0);
    draw_text(next_x+8,next_y-28,"Size");
    
    if string_count(",",new_pos) == 2 {
        brick.x = string_to_real(string_split(new_pos,",",0));
        brick.y = string_to_real(string_split(new_pos,",",1));
        brick.z = string_to_real(string_split(new_pos,",",2));
    }
    if string_count(",",new_size) == 2 {
        brick.xs = string_to_real(string_split(new_size,",",0));
        brick.ys = string_to_real(string_split(new_size,",",1));
        brick.zs = string_to_real(string_split(new_size,",",2));
    }
    
    next_y += 24;
    draw_text(xx+26,next_y,"Edit");
    next_y += string_height("Edit")+16;;
    next_x += 28;
    
    brick.color = draw_color_button("brick_color"+string(brick.id),"",brick.color,xx+26+28,next_y,26,26,1);
    draw_set_color(c_white);
    draw_text(next_x+8,next_y-26,"Color");
    
    var lbw;
    lbw = 26+18+string_width(string(brick.light_range));
    draw_set_color(main_boutline);
    draw_box(xx+26+28,next_y+10,xx+26+28+lbw,next_y+10+26,0);
    brick.light_range = real(string_digits(draw_input("brick_light_range",string(brick.light_range),"Change light range",next_x-lbw+26,next_y-26,lbw-26,26,0)));
    brick.light_color = draw_color_button("brick_light_color"+string(brick.id),"",brick.light_color,next_x-lbw,next_y-26,26,26,1);
    draw_set_color(c_white);
    draw_text(xx+26+28+lbw+8,next_y-26,"Light");
    
    lbw = 26+18+string_width(string(255*brick.alpha));
    draw_set_color(main_boutline);
    draw_box(xx+26+28,next_y+10,xx+26+28+lbw,next_y+10+26,0);
    brick.alpha = real(string_digits(draw_input("brick_alpha",string(floor(brick.alpha*255)),"Change transparency",next_x-lbw+26,next_y-26,lbw-26,26,0)))/255;
    brick.alpha = min(1,brick.alpha);
    draw_set_color(c_white);
    draw_set_alpha(brick.alpha);
    draw_box(next_x-lbw,next_y-26,next_x-lbw+26,next_y,0);
    draw_set_alpha(1);
    draw_text(xx+26+28+lbw+8,next_y-26,"Transparency");
    
    /*lbw = 26+12+string_width(brick.alpha);
    draw_box(xx+26+28,next_y+10,xx+26+28+lbw,next_y+10+26,0);
    draw_set_color(c_white);
    draw_set_alpha(brick.alpha);
    draw_box(xx+26+28-lbw,next_y-26,xx+26+28-lbw,next_y,0);
    draw_set_alpha(1);
    brick.alpha = real(string_digits(draw_input("brick_alpha",string(floor(brick.alpha*255)),"Change transparency",xx+26+28-lbw+26+6,next_y-26,lbw-26-6,26,0)))/255;
    brick.alpha = min(1,brick.alpha);
    draw_text(next_x+8,next_y-26,"Transparency");*/
    
    if(page != page_script) {
        draw_set_color(button_blue);
        if draw_button2("brick_script_edit","",19,xx+26+28,next_y+10,26,26,1) {
            page = page_script;
            script_textbox.text = brick.script;
        }
    } else {
        draw_set_color(button_blue);
        if draw_button2("brick_script_save","",19,xx+26+28,next_y+10,26,26,1) {
            page = page_world;
            //brick.script = script_textbox.text;
        }
    }
    
    yy = next_y;
    
    /*brick.color = draw_color_button("brick_color"+string(brick.id),"Color",brick.color,xx+4,28,20,20,1);
    
    draw_set_font(fnt_regular);
    //next_x = xx+4;
    //next_y = 52;
    left_x = xx+4;
    yy = yy+next_y;
    draw_text(left_x,next_y,"Name:");
    draw_text(left_x,next_y+24,"Position:");
    draw_text(left_x,next_y+48,"Size:");
    
    right_x = xx+8+max(string_width("Name:"),string_width("Position:"),string_width("Size:"));
    next_y = yy;
    
    var new_pos,new_size,old_name;
    old_name = brick.name;
    brick.name = draw_input("brick_name",brick.name,"Change brick name:",right_x,next_y,120,24,1);
    if(old_name != brick.name) {
        //history_add("brick name",string(brick)+" "+string(old_name));
    }
    new_pos = draw_input("brick_pos",string(brick.x)+","+string(brick.y)+","+string(brick.z),"Change brick position:",right_x,next_y,120,24,1);
    if string_count(",",new_pos) == 2 {
        brick.x = string_to_real(string_split(new_pos,",",0));
        brick.y = string_to_real(string_split(new_pos,",",1));
        brick.z = string_to_real(string_split(new_pos,",",2));
    }
    new_size = draw_input("brick_size",string(brick.xs)+","+string(brick.ys)+","+string(brick.zs),"Change brick size:",right_x,next_y,120,24,1);
    if string_count(",",new_size) == 2 {
        brick.xs = string_to_real(string_split(new_size,",",0));
        brick.ys = string_to_real(string_split(new_size,",",1));
        brick.zs = string_to_real(string_split(new_size,",",2));
    }
    
    right_x = xx+8+string_width("Range:");
    next_y = next_y+24;
    draw_text(left_x,next_y,"Light:");
    draw_text(left_x,next_y+24,"Range:");
    var temp_range,old_lr;
    old_lr = brick.light_range;
    brick.light_range = string_to_real(draw_input("brick_lightrange",brick.light_range,"Change brick light range:",right_x,next_y+24,120,24,1));
    brick.light_color = draw_color_button("brick_lightcolor","Color",brick.light_color,right_x,next_y,20,20,1);
    //if draw_color_button("brick_lightcolor","Color",brick.light_color,right_x,next_y,20,20,1) {
        //brick.light_color = get_color(brick.light_color);
    //}
    
    if(old_lr != brick.light_range) {
    //    history_add("brick light range",string(brick)+" "+string(old_lr));
    }
    //brick.light_range = 0;
    //brick.light_color = 0;
    
    if(page != page_script) {
        if draw_button2("brick_script_edit","Edit script...",-1,left_x,next_y+24,120,24,1) {
            page = page_script;
            script_textbox.text = brick.script;
        }
    } else {
        if draw_button2("brick_script_save","Save script...",-1,left_x,next_y+24,120,24,1) {
            page = page_world;
            brick.script = script_textbox.text;
        }
    }*/
    
    if keyboard_check_pressed(vk_escape) {
        //brick.script = script_textbox.text;
        brick_select = -1;
        page = page_world;
        window_hover = "";
    }
}

//scrollbar_draw(scroll_right,xx+w-14,0,h,yy+sb_val[scroll_right]+32);
scrollbar_draw(scroll_right,xx+w-14,0,h,yy+sb_val[scroll_right]+30);
right_panel_size = yy+sb_val[scroll_right]+30;

draw_set_color(main_border);
draw_line(floor(view_wview[view_interface]-properties_w)+1,0,floor(view_wview[view_interface]-properties_w)+1,view_hview[view_interface]);
