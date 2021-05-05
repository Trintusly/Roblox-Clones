// draw_bar();
var yy,w,h,str,but;
w=floor(view_wview[view_interface]-properties_w)+1
h=settings_h;
xx = 9-sb_val[scroll_top];
if(scroll_top_size > w) {
    h += 16;
}

draw_set_alpha(1);
draw_set_color(col_main);
draw_rectangle(0,0,w,h-24,0);

{ //first icon pack
    var left_x;
    left_x = xx;
    draw_set_color(button_grey);if draw_button2("new_project","",0,left_x,9,24,24,1) {
        new();
    }
    draw_set_color(button_grey);if draw_button2("open_project","",1,next_x+8,9,24,24,1) {
        open();
    }
    draw_set_color(button_grey);if draw_button2("save_project","",2,next_x+8,9,24,24,1) {
        save();
    }
    draw_set_color(button_grey);if draw_button2("save_as_project","",13,next_x+8,9,24,24,1) {
        save_as();
    }
    var newline,farx;
    farx = next_x;
    newline = next_y+10
    draw_set_color(button_yellow);if draw_button2("load_project","",5,left_x,newline,24,24,1) {
        import();
    }
    draw_set_color(button_blue);if draw_button2("copy_project","",3,next_x+8,newline,24,24,1) {
        copy();
    }
    draw_set_color(button_blue);if draw_button2("paste_project","",4,next_x+8,newline,24,24,1) {
        paste();
    }
    
    draw_set_color(main_outline);
    draw_line(farx+9,0,farx+9,h);
    next_x = farx+20;
}

{
    left_x = next_x;
    draw_set_color(button_pink);if draw_button2("brick_undo","",22,next_x,9,22,22,1) {
        undo();
    }
    draw_set_color(button_pink);if draw_button2("brick_redo","",21,next_x+8,9,22,22,1) {
        redo();
    }
    
    farX = next_x+9;
    nextY = next_y+10;
    draw_set_color(button_grey);if draw_button2("brick_delete","",20,left_x,nextY,22,22,1) {
        delete();
    }
    draw_set_color(button_grey);if draw_button2("brick_cut","",23,next_x+8,nextY,22,22,1) {
        copy();
        delete();
        //do the cut
    }
    
    next_x = farX;
    draw_set_color(main_outline);
    draw_line(next_x,0,next_x,h);
    next_x += 9;
}

{
    draw_set_color(main_outline);
    draw_box(next_x,10,next_x+71,81,0);
    var nextX,brickName,brickXS,brickYS,brickZS,brickSize,brickXP,brickYP,brickZP,brickPos;
    nextX = next_x;
    
    if((instance_exists(brick_select) && brick_select != -1)) {
        var brick;
        if background_exists(bkg_preview) {
            draw_background_ext(bkg_preview,next_x-71,next_y-71,71/background_get_width(bkg_preview),71/background_get_height(bkg_preview),0,c_white,1);
        }
        brick = brick_select;
        brick.color = draw_color_button("paint_temp","",brick.color,next_x-18,next_y-18,22,22,1);
        //if draw_color_button("paint_temp","",brick.color,next_x-18,next_y-18,22,22,1) {//brick.color = get_color(brick.color);
        //}
        
        brickXS = brick.xs;
        brickYS = brick.ys;
        brickZS = brick.zs;
        brickSize = string(brickXS)+", "+string(brickYS)+", "+string(brickZS);
        
        brickXP = brick.x;
        brickYP = brick.y;
        brickZP = brick.z;
        brickPos = "  "+string(brickXP)+"  "+string(brickYP)+"  "+string(brickZP);
        
        brickName = brick.name;
    } else {
        col_paint = draw_color_button("paint_global2","",col_paint,next_x-18,next_y-18,22,22,1);
        //draw_color_button("paint_global2","",col_paint,next_x-18,next_y-18,22,22,1);
        brickName = "New Brick";
        brickSize = "2, 4, 1";
        brickPos = "  0  0  0";
        
        brickXP = 0;
        brickYP = 0;
        brickZP = 0;
    }
    
    draw_set_alpha(1);
    draw_set_color(main_outline);
    draw_box(nextX+17,40,nextX+17+string_width(brickSize)+10,59,0); //nX+65
    var nextY;
    nextY = next_y+5
    farX = max(next_x+9);
    draw_box(nextX+17,nextY,nextX+17+string_width(brickPos)+10,nextY+19,0); //nX+83
    farX = max(farX,next_x+9,nextX+min(string_width(brickName),180));
    
    draw_set_color(c_white);
    draw_text(nextX+14,11,string_limit(brickName,farX-nextX-14));
    
    var strW;
    draw_set_font(fnt_small);
    draw_set_color($93411c);
    draw_text(nextX+22,nextY+2,"X");
    strW = 22+string_width("X");
    draw_set_font(fnt_regular);
    draw_set_color(c_white);
    draw_text(nextX+strW,nextY-3,brickXP);
    strW += string_width(string(brickXP)+" ");
    
    draw_set_font(fnt_small);
    draw_set_color($00b3ee);
    draw_text(nextX+strW,nextY+2,"Y");
    strW += string_width("Y");
    draw_set_font(fnt_regular);
    draw_set_color(c_white);
    draw_text(nextX+strW,nextY-3,brickYP);
    strW += string_width(string(brickYP)+" ");
    
    draw_set_font(fnt_small);
    draw_set_color($0101c1);
    draw_text(nextX+strW,nextY+2,"Z");
    strW += string_width("Z");
    draw_set_font(fnt_regular);
    draw_set_color(c_white);
    draw_text(nextX+strW,nextY-3,brickZP);
    
    draw_set_font(fnt_regular);
    draw_set_color(c_white);
    draw_text(nextX+22,37,brickSize);
    
    draw_set_color(main_outline);
    draw_line(farX,0,farX,h);
    next_x = farX+12;
}

{
    left_x = next_x;
    draw_set_color(button_blue);if draw_toggle("brick_resize","",6,next_x,9,22,22,1,(brick_control==brick_resize)) {brick_control = brick_resize;}
    draw_set_color(button_blue);if draw_toggle("brick_transform","",7,next_x+8,9,22,22,1,(brick_control==brick_transform)) {brick_control = brick_transform;}
    draw_set_color(button_blue);if draw_toggle("brick_rotate","",10,next_x+8,9,22,22,1,(brick_control==brick_rotate)) {brick_control = brick_rotate;}
    
    draw_set_alpha(1);
    draw_box(next_x+8,9,next_x+62,41,1);
    next_x -= 62;
    col_paint = draw_color_button("paint_global","",col_paint,next_x+8,9,36,32,1);
    //if draw_color_button("paint_global","",col_paint,next_x+8,9,36,32,1) {
    //col_paint = get_color(col_paint);
    //}
    draw_set_color(button_grey);if draw_toggle("brick_paint","",8,next_x-6,9,22,22,0,(brick_control==brick_paint)) {brick_control = brick_paint;}
    
    draw_set_color(col_paint);
    nextX = next_x+18;
    //if draw_button_spr("paint_stud",spr_studs,0,next_x+6,8,66,34,1) {}
    draw_box(nextX,9,nextX+62,41,1);
    draw_sprite(spr_studs,0,nextX+2,10);
    draw_set_color(button_grey);if draw_toggle("brick_stud2","",11,next_x-32,9,22,22,0,(brick_control==brick_stud)) {brick_control=brick_stud;}
    
    farX = next_x+9;
    nextY = next_y+10;
    //BRICK DECALS
    //draw_set_color(button_yellow);if draw_toggle("brick_decal","",16,left_x,nextY,22,22,1,(brick_control==brick_decal)) {brick_control = brick_decal;}
    //                                                                                      v next_x+8
    draw_set_color(button_yellow);if draw_toggle("brick_visible","",14+(brick_make_visible),left_x,nextY,22,22,1,(brick_control==brick_visible)) {
        if(brick_control == brick_visible) {
            brick_make_visible = !brick_make_visible;
        }
        brick_control = brick_visible;
    }
    
    next_x = farX-44-37;
    draw_set_color(button_blue);if draw_button2("brick_export","",17,next_x,nextY,11,22,1) {
        export();
    }
    draw_set_color(button_yellow);if draw_button2("brick_test","",18,next_x+8,nextY,11,22,1) {
        play();
    }
        
    next_x = farX;
    draw_set_color(main_outline);
    draw_line(next_x,0,next_x,h);
}

{
    var far_Y;
    draw_set_color(col_main);
    if draw_button_spr("prev_brick_page",spr_arrow,1,farX+1,0,20,h-24-14*(scroll_top_size > w),0) {
        scroll_newbrick = max(scroll_newbrick-1,0);
    }
    
    for(i=scroll_newbrick;i<scroll_newbrick+4;i+=1) {
        switch i {
            case 0:
                type = "Brick";
                break;
            case 1:
                type = "Slope";
                break;
            case 2:
                type = "Plate";
                break;
            case 3:
                type = "Wedge";
                break;
            case 4:
                type = "Spawn";
                break;
            case 5:
                type = "Arch";
                break;
            case 6:
                type = "Corner";
                break;
            //case 7:
            //    type = "Inverted Corner";
            //    break;
            //case 7:
            //    type = "Dome";
            //    break;
            case 7:
                type = "Bars";
                break;
            case 8:
                type = "Flag";
                break;
            case 9:
                type = "Pole";
                break;
            //case 12:
            //    type = "Round";
            //    break;
            case 10:
                type = "Cylinder";
                break;
            //case 14:
            //    type = "Round Slope";
            //    break;
            case 11:
                type = "Vent";
                break;
            default:
                type = "skip"
                break;
        }
        
        //if draw_button2("new_brick"+string(i),string_limit(type,70-string_width("...")),-1,next_x+10,9,71,71,0) {
        if type != "skip" {
            draw_set_color(col_paint);
            if draw_button_spr2("new_brick"+string(i),spr_brick,i,next_x+10,9,71,71,0) {
                ray_center(20);
                brick_select = new_brick(round(xTo),round(yTo),round(zTo),brick_xsize,brick_ysize,brick_zsize,col_paint,1);
                get_brick_far(brick_select);
                brick_select.x += round(xTo-farX);
                brick_select.y += round(yTo-farY);
                brick_select.z += round(zTo-farZ);
                
                ds_list_destroy(brick_selection);
                brick_selection = ds_list_create();
                ds_list_add(brick_selection,brick_select);
                
                switch i {
                    case 0:
                        brick_select.shape = "";
                        break;
                    case 1:
                        brick_select.shape = "slope";
                        break;
                    case 2:
                        brick_select.shape = "plate";
                        brick_select.zs = 0.3;
                        break;
                    case 3:
                        brick_select.shape = "wedge";
                        break;
                    case 4:
                        brick_select.shape = "spawnpoint";
                        break;
                    case 5:
                        brick_select.shape = "arch";
                        break;
                    //case 6:
                    //    brick_select.shape = "corner";
                    //    break;
                    //case 7:
                    //    brick_select.shape = "corner_inv";
                    //    break;
                    case 6:
                        brick_select.shape = "dome";
                        break;
                    case 7:
                        brick_select.shape = "bars";
                        break;
                    case 8:
                        brick_select.shape = "flag";
                        break;
                    case 9:
                        brick_select.shape = "pole";
                        break;
                    //case 12:
                    //    brick_select.shape = "round";
                    //    break;
                    case 10:
                        brick_select.shape = "cylinder";
                        break;
                    //case 14:
                    //    brick_select.shape = "round_slope";
                    //    break;
                    case 11:
                        brick_select.shape = "vent";
                        break;
                }
            }
        }
    }
    far_Y = next_y;
    
    draw_set_color(col_main);
    if draw_button_spr("next_brick_page",spr_arrow,0,next_x+10,0,20,h-24-14*(scroll_top_size > w),0) {
        scroll_newbrick = min(scroll_newbrick+1,12-4);
    }
    
    next_y = far_Y;
}

/*if draw_button2("new_brick","New Brick",-1,next_x+6,draw_y+6,24,24,1) {

}

if draw_toggle("world_lighting","",9,next_x+12,draw_y+6,24,24,1,lighting) {lighting = !lighting;}*/



settings_h = max(settings_h,next_y+8+24);
xx = next_x;//+9;

draw_set_color(main_border);
draw_line(0,h-24,w,h-24);
scrollbar_draw(scroll_top,0,h-38,w,xx+sb_val[scroll_top]);
scroll_top_size = xx+sb_val[scroll_top];

{
    draw_set_color(main_outline);
    draw_rectangle(0,h-23,w,h,0);
    draw_set_color(main_hover);
    draw_rectangle(-1,h-23,w+1,h,1);
    draw_set_color(c_white);
    draw_set_font(fnt_medium);
    draw_text(26,h-25,string_repeat("*",unsaved)+project_name);
    
    draw_set_color(main_outline);
    if draw_toggle("world_lighting","",-1,w-46,h-22,22,22,0,lighting) {lighting = !lighting}
    draw_sprite(spr_icons,9,w-44,h-20);
    
    draw_set_color(main_outline);
    if page == page_script {
        if draw_toggle("world_close","",-1,next_x+5,h-19,16,16,0,!game) {
            page = page_world;
        }
        draw_sprite(spr_icons,12,next_x-17,h-20);
    } else if page == page_world {
        /*if draw_toggle("world_close","",-1,next_x+5,h-19,16,16,0,!game) {
            ds_list_clear(brick_selection);
            brick_select = -1;
            unsaved = false;
            game = false;
        }
        draw_sprite(spr_icons,12,next_x-17,h-20);
        */
    }
    /*if draw_toggle("world_close","",-1,next_x+5,h-19,16,16,0,!game) {
        if page == page_world {
            ds_list_clear(brick_selection);
            brick_select = -1;
            unsaved = false;
            game = false;
        } else if page == page_script {
            page = page_world;
        }
    }*/
}
