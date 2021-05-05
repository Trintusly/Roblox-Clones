// draw_tab(name,string,x,y,xs,ys,padding)
var str,icon,xx,yy,xs,ys,ret,pad,name;
name = argument0;
str = argument1;
xx = argument2;
yy = argument3;
pad = argument6;
xs = argument4;
ys = argument5;//max(argument5,string_height(str)+pad);

ret = false;

draw_set_alpha(1);
draw_set_font(fnt_regular);

// the whole clicky ting
if in_box(xx,yy,xx+xs,yy+ys) {
    if(!popup || (popup && string_pos("popup",name) == 1))
        window_hover = name;
} else {
    if window_hover == name {
        window_hover = "";
        window_set_cursor(cr_default);
    }
}
if window_hover == name {
    if window_drag == "" {
        window_set_cursor(cr_handpoint);
    }
}
if window_hover == name && window_drag == "" {
    draw_set_color(main_hover);
} else {
    draw_set_alpha(0);
}
if window_drag == name {
    if mouse_check_button(mb_left) {
        draw_set_alpha(1);
        draw_set_color(main_border);
    }
}
if window_hover == name {
    if mouse_check_button_released(mb_left) && window_drag == name {
        ret = true;
        window_set_cursor(cr_default);
    } else if mouse_check_button_released(mb_right) {
        ret = -1;
    }
}
//end of the dreaded click

//draw_rectangle(xx,yy,xx+xs,yy+ys,0);
draw_box(xx,yy,xx+xs,yy+ys,0);

draw_set_color(c_white);
draw_set_alpha(1);
draw_text(xx+pad,yy+(ys-string_height(str))/2,string_limit(str,xs-pad*2-string_width("...")));

next_x = xx+xs;
next_y = yy+ys;

return ret;
