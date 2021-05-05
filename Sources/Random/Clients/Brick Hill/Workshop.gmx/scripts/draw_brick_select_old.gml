if(page == page_world) {
    if(brick_select != -1) {
        if instance_exists(brick_select) {
            var b;
            b = brick_select;
            
            ConvertPrepare(xfrom,yfrom,zfrom,xto,yto,zto,view_3d);
            
            draw_set_color($0088ff);
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
    
    if(brick_hover != -1 && brick_hover != brick_select && window_drag == "") {
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
