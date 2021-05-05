// draw_vector_drag(x,y,z,axis);
var x1,y1,x2,y2,brickOx,brickOy,brickOz,line_dir,xv,yv,xw,yw,brick,axis;

axis = string_to_real(argument3); //x=0,y=1,z=2;

axis_str = string_copy("xyz",axis+1,1);
xv = view_xport[view_3d];
yv = view_yport[view_3d];
xw = view_xport[view_3d]+view_wport[view_3d];
yw = view_yport[view_3d]+view_hport[view_3d];

brickOx = argument0;
brickOy = argument1;
brickOz = argument2;

lineOx = Convert_3d(brickOx,brickOy,brickOz);
lineOy = y_2d;

x1 = Convert_3d(brickOx-(axis == 0),brickOy-(axis == 1),brickOz-(axis == 2));
y1 = y_2d;
x2 = Convert_3d(brickOx+(axis == 0),brickOy+(axis == 1),brickOz+(axis == 2));
y2 = y_2d;

line_dir = point_direction(x1,y1,x2,y2);

/**/
var xTo,yTo,zTo,length;

xTo = xfrom+cos(degtorad(direction))*cos(degtorad(zdirection))*6;
yTo = yfrom-sin(degtorad(direction))*cos(degtorad(zdirection))*6;
zTo = zfrom+sin(degtorad(zdirection))*6;

difX = lineOx-Convert_3d(xTo,yTo,zTo);
difY = lineOy-y_2d;

x1 = difX+Convert_3d(xTo-(axis == 0),yTo-(axis == 1),zTo-(axis == 2));
y1 = difY+y_2d;
x2 = difX+Convert_3d(xTo+(axis == 0),yTo+(axis == 1),zTo+(axis == 2));
y2 = difY+y_2d;

lengthR = sqrt(power(x1-x2,2)+power(y1-y2,2));
/**/

x1 = lineOx-lengthdir_x(lengthR,line_dir);
y1 = lineOy-lengthdir_y(lengthR,line_dir);
x2 = lineOx+lengthdir_x(lengthR,line_dir);
y2 = lineOy+lengthdir_y(lengthR,line_dir);


//var in_view;
//in_view = false;
//if in_point(xv,yv,xw,yw,x1,y1) && in_point(xv,yv,xw,yw,x2,y2) {
    draw_set_color(c_black);
    draw_arrow(x1-lengthdir_x(6,line_dir),y1-lengthdir_y(6,line_dir),x2+lengthdir_x(6,line_dir),y2+lengthdir_y(6,line_dir),24);
    draw_arrow(x2+lengthdir_x(6,line_dir),y2+lengthdir_y(6,line_dir),x1-lengthdir_x(6,line_dir),y1-lengthdir_y(6,line_dir),24);
    if window_hover == "vector_"+string(axis_str)+"_drag" || window_drag == "vector_"+string(axis_str)+"_drag" {
        draw_set_color(c_white);
    } else {
        switch axis {
            case 0:
                draw_set_color($93411c); //blue red yellow
                break;
            case 1:
                draw_set_color($00b3ee);
                break;
            case 2:
                draw_set_color($0101c1);
                break;
        }
    }
    draw_arrow(x1,y1,x2,y2,16);
    draw_arrow(x2,y2,x1,y1,16);
    draw_line_width(x1,y1,x2,y2,2);
//    in_view = true;
//}
if (point_line_distance(x1,y1,x2,y2,mousex,mousey,true) <= 10) {
    if(!popup) {
        window_hover = "vector_"+string(axis_str)+"_drag";
        if mouse_check_button_pressed(mb_left) {
            window_drag = "vector_"+string(axis_str)+"_drag";
        }
    }
} else {
    if window_hover == "vector_"+string(axis_str)+"_drag" {
        window_hover = "";
    }
}
if mouse_check_button_released(mb_left) && window_drag == "vector_"+string(axis_str)+"_drag" {
    window_drag = "";
    window_set_cursor(cr_default);
}

if window_drag == "vector_"+string(axis_str)+"_drag" {
    window_hover = "vector_"+string(axis_str)+"_drag";
    mouse_set_world();
    return true;
} else {
    return false;
}
