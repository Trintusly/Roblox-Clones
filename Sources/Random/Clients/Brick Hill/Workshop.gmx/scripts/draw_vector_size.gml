// draw_vector_size(brick,axis);
var brick,axis,axis_str,xv,yv,xw,yw,brickOx,brickOy,brickOz,x1,y1,x2,y2;
brick = string_to_real(argument0);
axis = string_to_real(argument1); //x=0,y=1,z=2;
axis_str = string_copy("xyz",axis+1,1);
xv = view_xport[view_3d];
yv = view_yport[view_3d];
xw = view_xport[view_3d]+view_wport[view_3d];
yw = view_yport[view_3d]+view_hport[view_3d];

brickXs = brick.xs;
brickYs = brick.ys;
/*if(brick.rotation mod 180 != 0) {
    var brickXs1;
    brickXs1 = brickXs;
    brickXs = brickYs;
    brickYs = brickXs1;
}*/

brickOx = brick.x+brick.xs/2;
brickOy = brick.y+brick.ys/2;
brickOz = brick.z+brick.zs/2;

x1 = Convert_3d(brickOx-(brickXs/2+1)*(axis==0),brickOy-(brickYs/2+1)*(axis==1),brickOz-(brick.zs/2+1)*(axis==2));
y1 = y_2d;
x2 = Convert_3d(brickOx+(brickXs/2+1)*(axis==0),brickOy+(brickYs/2+1)*(axis==1),brickOz+(brick.zs/2+1)*(axis==2));
y2 = y_2d;

//var in_view;
//in_view = false;
//if in_point(xv,yv,xw,yw,x1+8,y1-8) && in_point(xv,yv,xw,yw,x2+8,y2-8) {
    draw_set_color(c_black);
    draw_circle(x1,y1,10,0);
    draw_circle(x2,y2,10,0);
    if window_hover == "vector_"+string(axis_str)+"_size" || window_drag == "vector_"+string(axis_str)+"_size" {
        draw_set_color(c_white);
    } else {
        switch axis {
            case 0:
                draw_set_color($93411c);
                break;
            case 1:
                draw_set_color($00b3ee);
                break;
            case 2:
                draw_set_color($0101c1);
                break;
        }
    }
    draw_circle(x1,y1,8,0);
    draw_circle(x2,y2,8,0);
    //draw_line_width(x1,y1,x2,y2,2);
    
    //in_view = true;
//}
if ((point_in_circle(mousex, mousey, x1, y1, 12) || point_in_circle(mousex, mousey, x2, y2, 12))) {
    if !popup
        window_hover = "vector_"+string(axis_str)+"_size";
} else {
    if window_hover == "vector_"+string(axis_str)+"_size" {
        window_hover = "";
    }
}

if point_in_circle(mousex, mousey, x1, y1, 10) && mouse_check_button_pressed(mb_left) {
    if !popup {
        brick_drag_xs = brick.xs;
        brick_drag_ys = brick.ys;
        brick_drag_zs = brick.zs;
        brick_drag_x = brick.x;
        brick_drag_y = brick.y;
        brick_drag_z = brick.z;
        window_drag = "vector_"+string(axis_str)+"_size_0";
    }
}
if point_in_circle(mousex, mousey, x2, y2, 10) && mouse_check_button_pressed(mb_left) {
    if !popup {
        brick_drag_xs = brick.xs;
        brick_drag_ys = brick.ys;
        brick_drag_zs = brick.zs;
        brick_drag_x = brick.x;
        brick_drag_y = brick.y;
        brick_drag_z = brick.z;
        window_drag = "vector_"+string(axis_str)+"_size_1";
    }
}

if mouse_check_button_released(mb_left) && string_pos("vector_"+string(axis_str)+"_size",window_drag) > 0 {
    //history_add("brick size",string(brick)+" "+string(brick_drag_xs)+" "+string(brick_drag_ys)+" "+string(brick_drag_zs)+" "+string(brick_drag_x)+" "+string(brick_drag_y)+" "+string(brick_drag_z));
    window_drag = "";
    window_set_cursor(cr_default);
}

if string_pos("vector_"+string(axis_str)+"_size",window_drag) > 0 {
    window_hover = "vector_"+string(axis_str)+"_size";
    mouse_set_world();
    if window_drag == "vector_"+string(axis_str)+"_size_0" {return 1;}
    else if window_drag == "vector_"+string(axis_str)+"_size_1" {return 2;}
} else {
    return 0;
}
