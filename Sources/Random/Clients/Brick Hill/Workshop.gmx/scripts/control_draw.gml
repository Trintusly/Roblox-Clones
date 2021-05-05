// control_draw()
GmnUpdate(global.set,1/max(1,fps));

if current_time-backup >= 120000 {
    var proj,path,pre_saved;
    proj = project_name;
    path = project_path;
    pre_saved = unsaved;
    backup = current_time;
    save_file(global.APPDATA+"\backup.brk");
    project_name = proj;
    project_path = path;
    unsaved = pre_saved;
}

past_history();

if window_hover == "" {window_set_cursor(cr_default);}

room_caption = project_name+" - Brick Hill Workshop | FPS: "+string(max(1,fps));
mousex = window_mouse_get_x();
mousey = window_mouse_get_y();

if ds_list_size(brick_selection) > 0 {
    get_selection();
}

if(view_current == view_preview) {
    if ds_list_size(brick_selection) > 0 {
        var b,bl;
        texture_set_interpolation(true);
        d3d_set_hidden(true);
        d3d_set_lighting(lighting);
        d3d_light_enable(camera_light,lighting);
        
        if(lighting) {
            d3d_light_define_point(camera_light,maxX+(maxX-minX)*1.2,maxY+(maxY-minY)*1.2,maxZ+(maxZ-minZ)*1.2,256,c_white);
            d3d_light_define_ambient(col_ambient);
            d3d_set_shading(true);
        } else {
            d3d_set_shading(false);
        }
        d3d_set_culling(true); //MAKE ME TRUE!!
        
        draw_set_color(c_white);
        draw_set_alpha(1);
        background_color = main_outline//color_to_3d(b.color);
        //d3d_set_projection_ext(b.x+b.xs*2,b.y+b.ys*2,b.z+b.zs*2,b.x,b.y,b.z,0,0,1,60,view_wview[view_preview]/view_hview[view_preview],0.1,1024);
        d3d_set_projection_ext(maxX+(maxX-minX)*1.4,maxY+(maxY-minY)*1.4,maxZ+(maxZ-minZ)*1.4,minX,minY,minZ,0,0,1,60,view_wview[view_preview]/view_hview[view_preview],0.1,1024);
        for(bl = 0; bl < ds_list_size(brick_selection); bl += 1) {
            b = ds_list_find_value(brick_selection,bl);
            draw_brick(b);
        }
        
        if background_exists(bkg_preview) {background_delete(bkg_preview);}
        bkg_preview = background_create_from_screen(view_xport[view_preview],view_yport[view_preview],view_wport[view_preview],view_hport[view_preview],1,1);
    }
    
    /*var b;
    b = brick_select;
    if ds_list_find_index(global.brickList,b) != -1 {
        texture_set_interpolation(true);
        d3d_set_hidden(true);
        d3d_set_lighting(lighting);
        d3d_light_enable(camera_light,lighting);
        
        if(lighting) {
            d3d_light_define_point(camera_light,b.x+b.xs*2,b.y+b.ys*2,b.z+b.zs*2,256,c_white);
            d3d_light_define_ambient(col_ambient);
            d3d_set_shading(true);
        } else {
            d3d_set_shading(false);
        }
        d3d_set_culling(true); //MAKE ME TRUE!!
        
        draw_set_color(c_white);
        draw_set_alpha(1);
        background_color = main_outline//color_to_3d(b.color);
        d3d_set_projection_ext(b.x+b.xs*2,b.y+b.ys*2,b.z+b.zs*2,b.x,b.y,b.z,0,0,1,60,view_wview[view_preview]/view_hview[view_preview],0.1,1024);
        draw_brick(b);
        
        if background_exists(bkg_preview) {background_delete(bkg_preview);}
        bkg_preview = background_create_from_screen(view_xport[view_preview],view_yport[view_preview],view_wport[view_preview],view_hport[view_preview],1,1);
    }*/
    return 0;
}
if view_current == view_interface {
    shortcuts();
    d3d_set_projection_ortho(0,0,view_wview[view_interface],view_hview[view_interface],0);
    if(page == page_script) {
        draw_set_color(script_background);
        draw_rectangle(view_xport[view_3d],view_yport[view_3d],view_xport[view_3d]+view_wport[view_3d],view_yport[view_3d]+view_hport[view_3d],0);
        draw_set_color(0);
        draw_set_font(fnt_code);
        brick_select.script = textbox_draw(script_textbox,view_xport[view_3d],view_yport[view_3d]+24,view_xport[view_3d]+view_wport[view_3d],view_yport[view_3d]+view_hport[view_3d]);
    }
    if !window_dragging {
        window_drag = "";
    }
    if mouse_check_button_pressed(mb_left) {
        window_drag_x = mousex;
        window_drag_y = mousey;
        window_drag = window_hover;
    }
    if mouse_check_button(mb_left) {
        window_dragging = true;
    } else {
        window_dragging = false;
    }
} else if(view_current == view_3d) {
    if(page = page_world && game) {
        camera_control();
        texture_set_interpolation(true);
        d3d_set_hidden(true);
        d3d_set_lighting(lighting);
        d3d_light_enable(camera_light,lighting);
        if(lighting) {
            d3d_light_define_point(camera_light,xfrom,yfrom,zfrom,256,c_white);
            d3d_light_define_ambient(col_ambient);
            d3d_set_shading(true);
        } else {
            d3d_set_shading(false);
        }
        d3d_set_culling(true); //MAKE ME TRUE!!
        
        draw_set_color(c_white);
        draw_set_alpha(1);
        background_color = color_to_3d(col_sky);
        d3d_set_projection_ext(xfrom,yfrom,zfrom,xto,yto,zto,0,0,1,camfov,view_wview[view_3d]/view_hview[view_3d],0.1,1024);
        frustum_culling_init(xfrom,yfrom,zfrom,xto,yto,zto,0,0,1,camfov*1.5,view_wview[view_3d]/view_hview[view_3d],0.1,1024);
        
        ConvertPrepare(xfrom,yfrom,zfrom,xto,yto,zto,view_3d);
        Convert_2d_z(mousex,mousey,zfrom-1);
        MxRay1 = x_3d;
        MyRay1 = y_3d;
        MzRay1 = zfrom-1;
        Convert_2d_z(mousex,mousey,zfrom+1);
        MxRay2 = x_3d;
        MyRay2 = y_3d;
        MzRay2 = zfrom+1;
        if !ray_find(MxRay1,MyRay1,MzRay1,MxRay2,MyRay2,MzRay2) {MxRay = 0; MyRay = 0; MzRay = 0;}
        ray_cast();
        MxRay = ray_x;
        MyRay = ray_y;
        MzRay = ray_z;
        
        
        draw_ground();
        
        var brick,br;
        brick_hover = -1;
        for (br=0;br<ds_list_size(global.brickList);br+=1) {
            brick = ds_list_find_value(global.brickList,br);
            
            //move it here
            
            if window_hover == "brick_"+string(brick.id) && mouse_check_button_released(mb_left) {
                if(brick_control == brick_delete) {
                    brick_select = -1;
                    brick_hover = -1;
                    ds_list_delete(global.brickList,br);
                    GmnDestroyBody(brick.body);
                    with brick {
                        instance_destroy();
                    }
                    continue;
                } else if(brick_control == brick_transform || brick_control == brick_resize) {
                    brick_select = brick.id;
                } else if(brick_control == brick_paint) {
                    brick.color = col_paint;
                } else if(brick_control == brick_rotate) {
                    brick_select = brick.id;
                    if(ds_list_find_index(brick_selection,brick.id) != -1) {
                        rotate();
                    } else {
                        brick.rotation += 90;
                        if(brick.rotation > 360) {
                            brick.rotation -= 360;
                        }
                    }
                } else if(brick_control == brick_stud) {
                    brick.stud = 0;
                } else if(brick_control == brick_decal) {
                    brick_select = brick.id;
                } else if(brick_control == brick_visible) {
                    brick.isVisible = brick_make_visible;
                }
                
                if brick_select == brick.id {
                    if ds_list_find_index(brick_selection,brick_select) == -1 {
                        if keyboard_check(vk_control) {
                            ds_list_add(brick_selection,brick_select);
                            if(keyboard_check(vk_shift)) {
                                get_selection();
                                for(b = 0; b < ds_list_size(global.brickList); b += 1) {
                                    bront = ds_list_find_value(global.brickList,b);
                                    if ds_list_find_index(brick_selection,bront.id) == -1 {
                                        if(bront.x >= minX && bront.x+bront.xs <= maxX) {
                                            if(bront.y >= minY && bront.y+bront.ys <= maxY) {
                                                if(bront.z >= minZ && bront.z+bront.zs <= maxZ) {
                                                    ds_list_add(brick_selection,bront.id);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            ds_list_destroy(brick_selection);
                            brick_selection = ds_list_create();
                            ds_list_add(brick_selection,brick_select);
                        }
                    }
                }
            }
            
            if window_hover == "brick_"+string(brick.id) && mouse_check_button_released(mb_right) {
                if(brick_control == brick_rotate) {
                    brick_select = brick.id;
                    counter_rotate();
                }
            }
            
            //move it back to where it says "move it here"
            if in_world() && !popup {
                if in_cuboid(brick.x,brick.y,brick.z,brick.x+brick.xs,brick.y+brick.ys,brick.z+brick.zs,MxRay,MyRay,MzRay) {
                    if brick_hover == -1 {
                        window_hover = "brick_"+string(brick.id);
                        brick_hover = brick.id;
                    }
                } else {
                    if window_hover == "brick_"+string(brick.id) {
                        window_hover = "";
                        brick_hover = -1;
                    }
                }
            } else {
                if window_hover == "brick_"+string(brick.id) {
                    window_hover = "";
                }
            }
            
            if(brick.isVisible && frustum_culling(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2,max(brick.xs/2,brick.ys/2,brick.zs/2))) {
                if ds_list_find_index(brick_selection,brick.id) == -1 {
                    draw_set_color(brick.color);
                } else {
                    draw_set_color(merge_color(brick.color, c_white, (sin(image_index/5)+1)/8));
                }
                //var r,g,b;
                //r = (color_get_red(col_ambient)/255)*color_get_red(brick.color);
                //g = (color_get_green(col_ambient)/255)*color_get_green(brick.color);
                //b = (color_get_blue(col_ambient)/255)*color_get_blue(brick.color);
                //d3d_light_define_ambient(make_color_rgb(r,g,b));
                //draw_set_color(make_color_rgb(r,g,b));
                
                brickRotX = brick.xs;
                brickRotY = brick.ys;
                brickPosX = brick.x;
                brickPosY = brick.y;
                if brick.rotation mod 180 != 0 {
                    brick.xs = brickRotY;
                    brick.ys = brickRotX;
                    brick.x = brickPosX-(brick.xs/2-brick.ys/2);
                    brick.y = brickPosY-(brick.ys/2-brick.xs/2);
                }
                
                draw_set_alpha(brick.alpha);
                d3d_transform_set_identity();
                d3d_transform_add_translation(-brick.xs/2,-brick.ys/2,0);
                d3d_transform_add_rotation_z(brick.rotation);
                d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z);
                switch brick.shape {
                    case "":
                        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),brick.xs,brick.ys);
                        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
                        d3d_draw_wall(0,0,0,brick.xs,0,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(0,brick.ys,0,0,0,brick.zs,-1,1,1);
                        break;
                    case "slope":
                        d3d_draw_floor(brick.xs-1,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),1,brick.ys);
                        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
                        d3d_draw_floor(brick.xs-1,0,brick.zs,0,brick.ys,0.3,background_get_texture(bkg_slope),brick.xs-1,brick.ys); //slope
                        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1); //back
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,0.3,-1,1,1); //left base
                        d3d_draw_wall(brick.xs,brick.ys,0,brick.xs-1,brick.ys,brick.zs,-1,1,1); //left
                        d3d_draw_wall(0,brick.ys,0,0,0,0.3,-1,1,1); //font
                        d3d_draw_wall(0,0,0,brick.xs,0,0.3,-1,1,1); //right base
                        d3d_draw_wall(brick.xs-1,0,0,brick.xs,0,brick.zs,-1,1,1); //right
                        d3d_primitive_begin(pr_trianglelist);
                        d3d_vertex_texture_color(brick.xs-1, 0, brick.zs,0,0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(0, 0, 0.3, 0, 0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(brick.xs-1, 0, 0.3, 0, 0,brick.color,brick.alpha);
                        d3d_primitive_end();
                        d3d_primitive_begin(pr_trianglelist);
                        d3d_vertex_texture_color(brick.xs-1, brick.ys, 0.3,0,0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(0, brick.ys, 0.3, 0, 0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(brick.xs-1, brick.ys, brick.zs, 0, 0,brick.color,brick.alpha);
                        d3d_primitive_end();
                        break;
                    case "plate":
                        brick.zs = 0.3
                        d3d_draw_floor(0,brick.ys,0.3,brick.xs,0,0.3,background_get_texture(bkg_stud),brick.xs,brick.ys);
                        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
                        d3d_draw_wall(0,0,0,brick.xs,0,0.3,-1,1,1);
                        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,0.3,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,0.3,-1,1,1);
                        d3d_draw_wall(0,brick.ys,0,0,0,0.3,-1,1,1);
                        break;
                    case "wedge":
                        if brick.rotation mod 180 == 0 {
                            brick.xs = max(brick.xs,2);
                        } else {
                            brick.ys = max(brick.ys,2);
                        }
                        d3d_draw_floor(0,brick.ys,brick.zs,1,0,brick.zs,background_get_texture(bkg_stud),1,brick.ys);
                        d3d_draw_floor(0,0,0,1,brick.ys,0,background_get_texture(bkg_understud),1,brick.ys);
                        d3d_draw_wall(0,0,0,1,0,brick.zs,-1,1,1);
                        d3d_draw_wall(1,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(0,brick.ys,0,0,0,brick.zs,-1,1,1);
                        
                        d3d_primitive_end();
                        d3d_primitive_begin(pr_trianglelist);
                        d3d_vertex_texture_color(1,0,0,0,0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(1,brick.ys,0,0,0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(brick.xs,brick.ys,0,0,0,brick.color,brick.alpha);
                        d3d_primitive_end();
                        
                        d3d_primitive_end();
                        d3d_primitive_begin(pr_trianglelist);
                        d3d_vertex_texture_color(brick.xs,brick.ys,brick.zs,0,0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(1,brick.ys,brick.zs,0,0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(1,0,brick.zs,0,0,brick.color,brick.alpha);
                        d3d_primitive_end();
                        
                        var brickBy,brickY,brickX,i,iCount;
                        brickBy = hcf(brick.xs,brick.ys);
                        brickY = brick.ys/brickBy;
                        brickX = brick.xs/brickBy;
                        iCount = min(brick.xs/brickX,brick.ys/brickY)-1;
                        for(i=0;i<=iCount;i+=1) {
                            d3d_draw_floor(brick.xs-(i+1)*brickX,(iCount-i)*brickY,brick.zs,0,(iCount-i+1)*brickY,brick.zs,background_get_texture(bkg_stud),brick.xs-(i+1)*brickX,brickY);
                        }
                        break;
                    case "spawnpoint":
                        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_spawnpoint),1,1);
                        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
                        d3d_draw_wall(0,0,0,brick.xs,0,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(0,brick.ys,0,0,0,brick.zs,-1,1,1);
                        break;
                    case "arch":
                        brick.ys = max(brick.ys,3);
                        /*if brick.rotation mod 180 == 0 {
                            draw_set_color(c_green);
                            brick.ys = max(brick.ys,3);
                        } else {
                            draw_set_color(c_blue);
                            brick.xs = max(brick.xs,3);
                        }*/
                        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),brick.xs,brick.ys);
                        d3d_draw_floor(0,0,0,brick.xs,1,0,background_get_texture(bkg_understud),brick.xs,1);
                        d3d_draw_floor(0,brick.ys-1,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,1);
                        
                        d3d_draw_wall(0,0,0,brick.xs,0,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
                        
                        d3d_draw_wall(brick.xs,1,0,0,1,0.3,-1,1,1);
                        d3d_draw_wall(0,brick.ys-1,0,brick.xs,brick.ys-1,0.3,-1,1,1);
                        
                        d3d_draw_wall(0,1,0,0,0,brick.zs,-1,1,1);
                        d3d_draw_wall(0,brick.ys,0,0,brick.ys-1,brick.zs,-1,1,1);
                        
                        d3d_draw_wall(brick.xs,0,0,brick.xs,1,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys-1,0,brick.xs,brick.ys,brick.zs,-1,1,1);
                        
                        d3d_draw_wall(0,brick.ys,brick.zs-0.3,0,0,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,0,brick.zs-0.3,brick.xs,brick.ys,brick.zs,-1,1,1);
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling(brick.xs/2,(brick.ys-2)/2,(brick.zs-0.6)/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+0.3);
                        d3d_model_draw(Arch,0,1,0,-1);
                        break;
                    case "corner": //WIP
                        brick.xs = max(brick.xs,2);
                        brick.ys = max(brick.ys,2);
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling((brick.xs-1)/2,(brick.ys-1)/2,brick.zs/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+(brick.xs+1)/2,brick.y+(brick.ys+1)/2,brick.z+brick.zs/2);
                        d3d_model_draw(Corner,0,0,0,-1);
                        break;
                    case "corner_inv":
                        brick.xs = max(brick.xs,2);
                        brick.ys = max(brick.ys,2);
                        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),brick.xs,brick.ys);
                        d3d_draw_floor(0,0,0,1,1,0,background_get_texture(bkg_understud),1,1);
                        
                        d3d_draw_wall(brick.xs,0,brick.zs-0.3,brick.xs,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,brick.zs-0.3,0,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(1,0,brick.zs-0.3,brick.xs,0,brick.zs,-1,1,1);
                        d3d_draw_wall(0,brick.ys,brick.zs-0.3,0,1,brick.zs,-1,1,1);
                        d3d_draw_wall(0,0,0,1,0,brick.zs,-1,1,1);
                        d3d_draw_wall(0,1,0,0,0,brick.zs,-1,1,1);
                        
                        d3d_primitive_begin(pr_trianglelist);
                        d3d_vertex_texture_color(1, 0, brick.zs-0.3, 0, 0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(1, 0, 0, 0, 0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(brick.xs, 0, brick.zs-0.3,0,0,brick.color,brick.alpha);
                        d3d_primitive_end();
                        
                        d3d_primitive_begin(pr_trianglelist);
                        d3d_vertex_texture_color(0, brick.ys, brick.zs-0.3,0,0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(0, 1, 0, 0, 0,brick.color,brick.alpha);
                        d3d_vertex_texture_color(0, 1, brick.zs-0.3, 0, 0,brick.color,brick.alpha);
                        d3d_primitive_end();
                        
                        d3d_draw_floor(1,0,0,brick.xs,1,brick.zs-0.3,-1,1,1);
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_z(brick.rotation+90);
                        d3d_transform_add_translation(brick.x,brick.y+brick.ys,brick.z);
                        d3d_draw_floor(0,0,brick.zs-0.3,brick.ys-1,1,0,-1,1,1);
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling((brick.xs-1)/2,(brick.ys-1)/2,(brick.zs-0.3)/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+(brick.xs+1)/2,brick.y+(brick.ys+1)/2,brick.z+(brick.zs-0.3)/2);
                        d3d_model_draw(Corner_Inverted,0,0,0,-1);
                        break;
                    case "dome":
                        brick.xs = 2;
                        brick.ys = 2;
                        brick.zs = 1;
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling(1/2,1/2,1/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
                        d3d_model_draw(Dome,0,0,0,-1);
                        break;
                    case "bars":
                        brick.xs = 1;
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling(1/2,1/2,1/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z);
                        var yrepeat;
                        for(yrepeat=-brick.ys/2;yrepeat<brick.ys/2;yrepeat+=1) {
                            d3d_model_draw(Fence_Bottom,0,0.3,-1-yrepeat*2,-1);
                            d3d_model_draw(Fence_Top,0,0.3+(brick.zs-0.3)*2,-1-yrepeat*2,-1);
                        }
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling(1/2,1/2,brick.zs/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
                        var yrepeat;
                        for(yrepeat=-brick.ys/2;yrepeat<brick.ys/2;yrepeat+=1) {
                            d3d_model_draw(Fence_Middle,0,0,-1-yrepeat*2,-1);
                        }
                        break;
                    case "flag":
                        brick.xs = 1;
                        brick.ys = 1;
                        brick.zs = 1;
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_scaling(1/2,1/2,1/2);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
                        d3d_model_draw(Flag,0,0,0,-1);
                        break;
                    case "pole":
                        brick.xs = 1;
                        brick.ys = 1;
                        d3d_transform_add_translation(1/2,1/2,0);
                        d3d_draw_cylinder(-0.5,-0.5,0,0.5,0.5,0.3,-1,1,1,1,12);
                        d3d_draw_cylinder(-0.3,-0.3,0.3,0.3,0.3,brick.zs-0.3,-1,1,1,1,12);
                        d3d_draw_ellipsoid(-0.3,-0.3,brick.zs-0.6,0.3,0.3,brick.zs,-1,1,1,12);
                        break;
                    case "round":
                        brick.xs = max(brick.xs,2);
                        brick.ys = max(brick.ys,2);
                        d3d_draw_floor(brick.xs-1,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),1,brick.ys);
                        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs-1,brick.ys-1,brick.zs,background_get_texture(bkg_stud),brick.xs-1,1);
                        
                        d3d_draw_floor(brick.xs-1,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),1,brick.ys);
                        d3d_draw_floor(0,brick.ys-1,0,brick.xs-1,brick.ys,0,background_get_texture(bkg_understud),brick.xs-1,1);
                        
                        d3d_draw_wall(brick.xs-1,0,0,brick.xs,0,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
                        d3d_draw_wall(0,brick.ys,0,0,brick.ys-1,brick.zs,-1,1,1);
                        d3d_transform_set_identity();
                        
                        /*d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling(brick.xs/2,brick.ys/2,brick.zs/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
                        d3d_model_draw(Round_Brick,-2/brick.xs,-2/brick.ys,0,-1);*/
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_scaling((brick.xs-1)/2,(brick.ys-1)/2,brick.zs/2);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z);
                        d3d_model_draw(Round_Brick,1-brick.xs/2,1-brick.ys/2,-1,-1);
                        break;
                    case "cylinder":
                        d3d_draw_cylinder(0,0,0.3,brick.xs,brick.ys,brick.zs,-1,1,1,1,12);
                        d3d_draw_cylinder(0.1,0.1,0,brick.xs-0.1,brick.ys-0.1,0.3,-1,1,1,1,12);
                        /*d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_scaling(brick.xs/2,brick.ys/2,brick.zs/2);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
                        d3d_model_draw(Round_Large1x1,0,0,0,-1);*/
                        break;
                    case "round_slope":
                        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
                        d3d_draw_wall(0,0,0,brick.xs,0,0.3,-1,1,1);
                        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,0.3,-1,1,1);
                        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,0.3,-1,1,1);
                        d3d_draw_wall(0,brick.ys,0,0,0,0.3,-1,1,1);
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_scaling(brick.xs/2,brick.ys/2,brick.zs/2-0.3);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
                        d3d_model_draw(Slope,0,0,0,-1);
                        break;
                    case "vent":
                        brick.zs = 0.3;
                        d3d_transform_set_identity();
                        
                        d3d_transform_set_identity();
                        d3d_transform_add_rotation_x(-90);
                        d3d_transform_add_scaling(1/2,brick.ys/2,1/2);
                        d3d_transform_add_rotation_z(brick.rotation);
                        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+0.15);
                        var xrepeat;
                        for(xrepeat=-brick.xs/2;xrepeat<brick.xs/2;xrepeat+=1) {
                            d3d_model_draw(Vent,xrepeat*2+1,0,0,-1);
                        }
                        break;
                }
                
                if brick.Model != -1 {
                    d3d_transform_set_identity();
                    
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_rotation_z(brick.rotation);
                    d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2-5);
                    
                    if background_exists(brick.Tex) {
                        d3d_model_draw(brick.Model,0,0,0, background_get_texture(brick.Tex));
                    } else {
                        d3d_model_draw(brick.Model,0,0,0, -1)
                    }
                }
                
                d3d_transform_set_identity();
                draw_set_alpha(1);
                
                if brick.rotation mod 180 != 0 {
                    brickRotX = brick.ys
                    brickRotY = brick.xs;
                } else {
                    brickRotX = brick.xs
                    brickRotY = brick.ys;
                }
                brick.xs = brickRotX;
                brick.ys = brickRotY;
                brick.x = brickPosX;
                brick.y = brickPosY;
            }
            //GmnBodySetRotation(brick.body,0,0,brick.rotation);
            GmnBodySetPosition(brick.body,brick.x,brick.y,brick.z);
            
            
            if(brick.light_range > 0 && brick.isVisible) {
                d3d_light_enable(brick.id,true);
                d3d_light_define_point(brick.id,brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2,brick.light_range,brick.light_color);
            } else {
                d3d_light_enable(brick.id,false);
            }
        }
        if mouse_check_button_pressed(mb_left) {
            if brick_hover == -1 && window_hover == "" {
                if in_world() {
                    ds_list_destroy(brick_selection);
                    brick_selection = ds_list_create();
                    brick_select = -1;
                }
            }
        }
        
        if background_exists(bkg_world) {background_delete(bkg_world);}
        bkg_world = background_create_from_screen(view_xport[view_3d],view_yport[view_3d],view_wport[view_3d],view_hport[view_3d],0,1);
        
        return 0;
    }
}

texture_set_interpolation(true);
d3d_set_lighting(false);
d3d_set_culling(false);
d3d_set_hidden(false);
d3d_set_projection_ortho(0,0,view_wview[view_interface],view_hview[view_interface],0);
var w,h;
w=view_wview[view_interface];
h=view_hview[view_interface];

if(page == page_world) {
    if background_exists(bkg_world) {
        draw_background(bkg_world,view_xport[view_3d],view_yport[view_3d]);
        //draw_background_ext(bkg_world,view_xport[view_3d],view_yport[view_3d],view_wport[view_3d]/background_get_width(bkg_world),view_hport[view_3d]/background_get_height(bkg_world),0,c_white,1);
    }
    
    var sl,slot,numSlots;
    numSlots = 0;
    for(sl=0;sl<ds_list_size(global.slotList);sl+=1) {
        slot = ds_list_find_value(global.slotList,sl);
        if instance_exists(slot) {
            if slot.onSpawn {
                //draw it
                draw_set_color(0);
                draw_set_alpha(0.6);
                draw_rectangle(numSlots*100,h-100,(numSlots+1)*100,h,0);
                
                if(slot.sticker > 0) {
                    //
                } else {
                    draw_set_color(c_white);
                    draw_set_alpha(1);
                    draw_set_halign(fa_center);
                    draw_set_valign(fa_middle);
                    draw_text(numSlots*100+50,h-50,string_limit(slot.name,100));
                    
                    draw_set_halign(fa_left);
                    draw_set_valign(fa_top);
                }
                numSlots += 1;
            }
        }
    }
}

if !game {
    draw_set_alpha(1);
    draw_set_color(script_background);
    draw_rectangle(0,0,room_width,room_height,0);
    //draw_set_color($e3e3e3);
    //draw_set_font(fnt_header);
    //var bench;
    //bench = "Click to create/open a project.";
    //draw_text((view_wview[view_3d]-string_width(bench))/2,settings_h+(view_hview[view_3d]-string_height(bench))/2,bench);
    
    if in_world() {
        if !popup {
            window_hover = "global_new";
            window_set_cursor(cr_handpoint);
            if mouse_check_button_pressed(mb_left) {
                window_set_cursor(cr_default);
                popup = true;
                popup_frame = "splash";
            }
        }
    } else if window_hover == "global_new" {
        window_hover = "";
        window_set_cursor(cr_default);
    }
}

draw_brick_select();
draw_brick_controls();
draw_bar();
draw_panel();
draw_popup();
draw_tip();

history_check();

view_yport[view_3d]=settings_h+1;
view_wview[view_3d]=w-properties_w+1;
view_wport[view_3d]=w-properties_w+1;
view_hview[view_3d]=h-settings_h+1;
view_hport[view_3d]=h-settings_h+1;

prevy = mouse_y;
prevx = mouse_x;
