// draw_brick_controls()
if(ds_list_size(brick_selection) <= 1) {
    if(instance_exists(brick_select) && brick_select != -1) {
        if page = page_world {
            var brick;
            brick = brick_select;
            
            if brick_control = brick_transform {
                var MxFrom,MyFrom,MxTo,MyTo,newBrickX,newBrickY,newBrickZ2,MyDiffX1,MyDiffY1,MyDiffX2,MyDiffY2,zAxis;
                if mouse_check_button_pressed(mb_left) {
                    brickO_x = brick.x;
                    brickO_y = brick.y;
                    brickO_z = brick.z;
                    
                    Convert_2d_z(mousex,mousey,brick.z);
                    MyDiffX1 = x_3d;
                    MyDiffY1 = y_3d;
                    Convert_2d_z(mousex,mousey,brick.z+1);
                    MyDiffX2 = x_3d;
                    MyDiffY2 = y_3d;
                    BzRatio = abs(MyDiffY2-MyDiffY1);
                } else if !mouse_check_button(mb_left) {
                    brickO_x = 0;
                    brickO_y = 0;
                    brickO_z = 0;
                    
                    BzRatio = 0;
                }
                
                newBrickX = brick.x;
                newBrickY = brick.y;
                newBrickZ = brick.z;
                
                Convert_2d_z(window_drag_x,window_drag_y,brick.z);
                MxFrom = x_3d;
                MyFrom = y_3d;
                get_z_at_Y(window_drag_x,window_drag_y,brick.y);
                MzFrom = z_3d;
                
                if draw_vector_drag(brick,0) {
                    Convert_2d_z(mouse_x,mouse_y,brick.z);
                    MxTo = x_3d;
                    newBrickX = brickO_x+floor(MxTo-MxFrom);
                }
                if draw_vector_drag(brick,1) {
                    Convert_2d_z(mouse_x,mouse_y,brick.z);
                    MyTo = y_3d;
                    newBrickY = brickO_y+floor(MyTo-MyFrom);
                }
                if draw_vector_drag(brick,2) {
                    get_z_at_Y(mouse_x,mouse_y,brick.y);
                    MzTo = z_3d;
                    
                    newBrickZ = brickO_z+floor(MzTo-MzFrom);
                }
                
                brick.x = newBrickX;
                brick.y = newBrickY;
                brick.z = newBrickZ;
            } else if brick_control = brick_resize {
                if mouse_check_button_pressed(mb_left) {
                    brickOx = brick.x;
                    brickOy = brick.y;
                    brickOz = brick.z;
                    brickOxs = brick.xs;
                    brickOys = brick.ys;
                    brickOzs = brick.zs;
                } else if !mouse_check_button(mb_left) {
                    brickOx = 0;
                    brickOy = 0;
                    brickOz = 0;
                    brickOxs = 0;
                    brickOys = 0;
                    brickOzs = 0;
                }
                
                zAxis = (abs(xfrom-brickOx) < abs(yfrom-brickOy));
                
                newBrickX = brick.x;
                newBrickY = brick.y;
                newBrickZ = brick.z;
                newBrickXs = brick.xs;
                newBrickYs = brick.ys;
                newBrickZs = brick.zs;
                
                Convert_2d_z(window_drag_x,window_drag_y,brickOz);
                MxFrom = x_3d;
                MyFrom = y_3d;
                get_z_at_Y(window_drag_x,window_drag_y,brickOy);
                MzFrom = z_3d;
                
                
                var vec_x,vec_y,vec_z;
                
                if(brick.shape != "pole" && brick.shape != "flag" && brick.shape != "dome") && ((brick.shape == "bars" && brick.rotation mod 180 != 0) || (brick.shape != "bars")) {
                    vec_x = draw_vector_size(brick,0);
                    if vec_x {
                        Convert_2d_z(mousex,mousey,brickOz);
                        MxTo = x_3d;
                        
                        if vec_x == 1 {
                            newBrickXs = max(1,floor(brickOxs+MxFrom-MxTo));
                            newBrickX = brickOx-(newBrickXs-brickOxs);
                        } else if vec_x == 2 {
                            newBrickXs = max(1,floor(brickOxs+MxTo-MxFrom));
                        }
                    }
                } else {
                    newBrickXs = brick.xs;
                    newBrickX = brick.x;
                }
                
                if(brick.shape != "pole" && brick.shape != "flag" && brick.shape != "dome") && ((brick.shape == "bars" && brick.rotation mod 180 == 0) || (brick.shape != "bars")) {
                    vec_y = draw_vector_size(brick,1);
                    if vec_y {
                        Convert_2d_z(mousex,mousey,brickOz);
                        MyTo = y_3d;
                        
                        if vec_y == 1 {
                            newBrickYs = max(1,floor(brickOys+MyFrom-MyTo));
                            newBrickY = brickOy-(newBrickYs-brickOys);
                        } else if vec_y == 2 {
                            newBrickYs = max(1,floor(brickOys+MyTo-MyFrom));
                        }
                    }
                } else {
                    newBrickYs = brick.ys;
                    newBrickY = brick.y;
                }
                
                if(brick.shape != "plate" && brick.shape != "vent" && brick.shape != "dome" && brick.shape != "flag") {
                    vec_z = draw_vector_size(brick,2);
                    if vec_z {
                        get_z_at_Y(mousex,mousey,brickOy);
                        MzTo = z_3d;
                        
                        if vec_z == 1 {
                            newBrickZs = max(1,floor(brickOzs+MzFrom-MzTo));
                            newBrickZ = brickOz-(newBrickZs-brickOzs);
                        } else if vec_z == 2 {
                            newBrickZs = max(1,floor(brickOzs+MzTo-MzFrom));
                        }
                    }
                } else {
                    newBrickZs = brick.zs;
                    newBrickZ = brick.z;
                }
                
                brick.x = newBrickX;
                brick.y = newBrickY;
                brick.z = newBrickZ;
                brick.xs = newBrickXs;
                brick.ys = newBrickYs;
                brick.zs = newBrickZs;
                
                if(brickOxs != brick.xs || brickOys != brick.ys || brickOzs != brick.zs) {
                    GmnDestroyBody(global.set,brick.body);
                    brick.bound = GmnCreateBox(global.set,brick.xs,brick.ys,brick.zs,brick.xs/2,brick.ys/2,brick.zs/2);
                    brick.body = GmnCreateBody(global.set,brick.bound);
                }
            }
        }
    }
} else {
    var b;
    if page = page_world && brick_control == brick_transform {
        var MxFrom,MyFrom,MxTo,MyTo,newBrickX,newBrickY,newBrickZ2,MyDiffX1,MyDiffY1,MyDiffX2,MyDiffY2,zAxis;
        var b,br;
        b = ds_list_find_value(brick_selection,0);
        minX = b.x;
        minY = b.y;
        minZ = b.z;
        maxXS = b.x+b.xs;
        maxYS = b.y+b.ys;
        maxZS = b.z+b.zs;
        for(br = 1; br < ds_list_size(brick_selection); br += 1) {
            b = ds_list_find_value(brick_selection,br);
            minX = min(minX,b.x);
            minY = min(minY,b.y);
            minZ = min(minZ,b.z);
            maxXS = max(maxX,b.x+b.xs);
            maxYS = max(maxY,b.y+b.ys);
            maxZS = max(maxZ,b.z+b.zs);
        }
        
        Convert_2d_z(window_drag_x,window_drag_y,minZ);
        MxFrom = x_3d;
        MyFrom = y_3d;
        get_z_at_Y(window_drag_x,window_drag_y,minY);
        MzFrom = z_3d;
        
        MxTo = 0;
        MyTo = 0;
        MzTo = 0;
        if draw_vector_drag_pos(minX+(maxXS-minX)/2,minY+(maxYS-minY)/2,minZ,0) {
            Convert_2d_z(mouse_x,mouse_y,minZ);
            MxTo = x_3d;
            xTranslate = true;
        } else {
            xTranslate = false;
        }
        if draw_vector_drag_pos(minX+(maxXS-minX)/2,minY+(maxYS-minY)/2,minZ,1) {
            Convert_2d_z(mouse_x,mouse_y,minZ);
            MyTo = y_3d;
            yTranslate = true;
        } else {
            yTranslate = false;
        }
        if draw_vector_drag_pos(minX+(maxXS-minX)/2,minY+(maxYS-minY)/2,minZ,2) {
            get_z_at_Y(mouse_x,mouse_y,minY);
            MzTo = z_3d;
            zTranslate = true;
        } else {
            zTranslate = false;
        }
        for(b = 0; b < ds_list_size(brick_selection); b += 1) {
            var brick;
            brick = ds_list_find_value(brick_selection,b);
            
            if brick_control = brick_transform {
                if mouse_check_button_pressed(mb_left) {
                    brickO_x[b] = brick.x;
                    brickO_y[b] = brick.y;
                    brickO_z[b] = brick.z;
                    
                    Convert_2d_z(mousex,mousey,brick.z);
                    MyDiffX1[b] = x_3d;
                    MyDiffY1[b] = y_3d;
                    Convert_2d_z(mousex,mousey,brick.z+1);
                    MyDiffX2[b] = x_3d;
                    MyDiffY2[b] = y_3d;
                    BzRatio[b] = abs(MyDiffY2-MyDiffY1);
                } else if !mouse_check_button(mb_left) {
                    brickO_x[b] = 0;
                    brickO_y[b] = 0;
                    brickO_z[b] = 0;
                    
                    BzRatio[b] = 0;
                }
                
                newBrickX = brick.x;
                newBrickY = brick.y;
                newBrickZ = brick.z;
                
                ////////////////////
                if(xTranslate) {
                    newBrickX = brickO_x[b]+floor(MxTo-MxFrom);
                }
                if(yTranslate) {
                    newBrickY = brickO_y[b]+floor(MyTo-MyFrom);
                }
                if(zTranslate) {
                    newBrickZ = brickO_z[b]+floor(MzTo-MzFrom);
                }
                ////////////////////
                
                brick.x = newBrickX;
                brick.y = newBrickY;
                brick.z = newBrickZ;
            }
        }
    }
}
