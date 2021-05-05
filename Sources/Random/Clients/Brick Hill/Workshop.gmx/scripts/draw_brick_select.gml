if(page == page_world) {
    if brick_select == -1 {
        ds_list_destroy(brick_selection);
        brick_selection = ds_list_create();
    }
    
    if ds_list_size(brick_selection) > 0 {
        /*var b,br;
        b = ds_list_find_value(brick_selection,0);
        minX = b.x;
        minY = b.y;
        minZ = b.z;
        maxX = b.x+b.xs;
        maxY = b.y+b.ys;
        maxZ = b.z+b.zs;
        for(br = 1; br < ds_list_size(brick_selection); br += 1) {
            b = ds_list_find_value(brick_selection,br);
            minX = min(minX,b.x);
            minY = min(minY,b.y);
            minZ = min(minZ,b.z);
            maxX = max(maxX,b.x+b.xs);
            maxY = max(maxY,b.y+b.ys);
            maxZ = max(maxZ,b.z+b.zs);
        }*/
        //get_selection();
        
        ConvertPrepare(xfrom,yfrom,zfrom,xto,yto,zto,view_3d);
        
        draw_set_color($0088ff);
        //x_1 = Convert_3d(x,y,z);
        //y_1 = y_2d
        x_2 = Convert_3d(minX,minY,maxZ);
        y_2 = y_2d;
        //draw_line_width(x_1,y_1,x_2,y_2,4);
        
        x_1 = Convert_3d(maxX,minY,maxZ);
        y_1 = y_2d;
        draw_line_width(x_2,y_2,x_1,y_1,4);
        
        x_2 = Convert_3d(maxX,maxY,maxZ);
        y_2 = y_2d;
        draw_line_width(x_2,y_2,x_1,y_1,4);
        
        x_1 = Convert_3d(minX,maxY,maxZ);
        y_1 = y_2d;
        draw_line_width(x_2,y_2,x_1,y_1,4);
        
        x_2 = Convert_3d(minX,minY,maxZ);
        y_2 = y_2d;
        draw_line_width(x_1,y_1,x_2,y_2,4);
        
        
        
        
        x_2 = Convert_3d(minX,minY,minZ);
        y_2 = y_2d;
        
        x_1 = Convert_3d(maxX,minY,minZ);
        y_1 = y_2d;
        draw_line_width(x_2,y_2,x_1,y_1,4);
        
        x_2 = Convert_3d(maxX,maxY,minZ);
        y_2 = y_2d;
        draw_line_width(x_2,y_2,x_1,y_1,4);
        
        x_1 = Convert_3d(minX,maxY,minZ);
        y_1 = y_2d;
        draw_line_width(x_2,y_2,x_1,y_1,4);
        
        x_2 = Convert_3d(minX,minY,minZ);
        y_2 = y_2d;
        draw_line_width(x_1,y_1,x_2,y_2,4);
        
        
        x_1 = Convert_3d(minX,minY,minZ);
        y_1 = y_2d;
        x_2 = Convert_3d(minX,minY,maxZ);
        y_2 = y_2d;
        draw_line_width(x_1,y_1,x_2,y_2,4);
        
        x_1 = Convert_3d(maxX,minY,minZ);
        y_1 = y_2d;
        x_2 = Convert_3d(maxX,minY,maxZ);
        y_2 = y_2d;
        draw_line_width(x_1,y_1,x_2,y_2,4);
        
        x_1 = Convert_3d(minX,maxY,minZ);
        y_1 = y_2d;
        x_2 = Convert_3d(minX,maxY,maxZ);
        y_2 = y_2d;
        draw_line_width(x_1,y_1,x_2,y_2,4);
        
        x_1 = Convert_3d(maxX,maxY,minZ);
        y_1 = y_2d;
        x_2 = Convert_3d(maxX,maxY,maxZ);
        y_2 = y_2d;
        draw_line_width(x_1,y_1,x_2,y_2,4);
    }
    
    if(ds_list_find_index(brick_selection,brick_hover) == -1 && brick_hover != -1 && brick_hover != brick_select && window_drag == "") {
        if in_point(view_xport[view_3d],view_yport[view_3d],view_xport[view_3d]+view_wport[view_3d],view_yport[view_3d]+view_hport[view_3d],x_2d,y_2d) {
            if instance_exists(brick_hover) {
                var b;
                b = brick_hover;
                
                ConvertPrepare(xfrom,yfrom,zfrom,xto,yto,zto,view_3d);
                
                draw_set_color($ffff00);
                //x_1 = Convert_3d(x,y,z);
                //y_1 = y_2d
                x_2 = Convert_3d(b.x,b.y,b.z+b.zs);
                y_2 = y_2d;
                //draw_line_width(x_1,y_1,x_2,y_2,4);
                
                x_1 = Convert_3d(b.x+b.xs,b.y,b.z+b.zs);
                y_1 = y_2d;
                draw_line_width(x_2,y_2,x_1,y_1,4);
                
                x_2 = Convert_3d(b.x+b.xs,b.y+b.ys,b.z+b.zs);
                y_2 = y_2d;
                draw_line_width(x_2,y_2,x_1,y_1,4);
                
                x_1 = Convert_3d(b.x,b.y+b.ys,b.z+b.zs);
                y_1 = y_2d;
                draw_line_width(x_2,y_2,x_1,y_1,4);
                
                x_2 = Convert_3d(b.x,b.y,b.z+b.zs);
                y_2 = y_2d;
                draw_line_width(x_1,y_1,x_2,y_2,4);
                
                
                
                
                x_2 = Convert_3d(b.x,b.y,b.z);
                y_2 = y_2d;
                
                x_1 = Convert_3d(b.x+b.xs,b.y,b.z);
                y_1 = y_2d;
                draw_line_width(x_2,y_2,x_1,y_1,4);
                
                x_2 = Convert_3d(b.x+b.xs,b.y+b.ys,b.z);
                y_2 = y_2d;
                draw_line_width(x_2,y_2,x_1,y_1,4);
                
                x_1 = Convert_3d(b.x,b.y+b.ys,b.z);
                y_1 = y_2d;
                draw_line_width(x_2,y_2,x_1,y_1,4);
                
                x_2 = Convert_3d(b.x,b.y,b.z);
                y_2 = y_2d;
                draw_line_width(x_1,y_1,x_2,y_2,4);
                
                
                x_1 = Convert_3d(b.x,b.y,b.z);
                y_1 = y_2d;
                x_2 = Convert_3d(b.x,b.y,b.z+b.zs);
                y_2 = y_2d;
                draw_line_width(x_1,y_1,x_2,y_2,4);
                
                x_1 = Convert_3d(b.x+b.xs,b.y,b.z);
                y_1 = y_2d;
                x_2 = Convert_3d(b.x+b.xs,b.y,b.z+b.zs);
                y_2 = y_2d;
                draw_line_width(x_1,y_1,x_2,y_2,4);
                
                x_1 = Convert_3d(b.x,b.y+b.ys,b.z);
                y_1 = y_2d;
                x_2 = Convert_3d(b.x,b.y+b.ys,b.z+b.zs);
                y_2 = y_2d;
                draw_line_width(x_1,y_1,x_2,y_2,4);
                
                x_1 = Convert_3d(b.x+b.xs,b.y+b.ys,b.z);
                y_1 = y_2d;
                x_2 = Convert_3d(b.x+b.xs,b.y+b.ys,b.z+b.zs);
                y_2 = y_2d;
                draw_line_width(x_1,y_1,x_2,y_2,4);
            }
        }
    }
}
