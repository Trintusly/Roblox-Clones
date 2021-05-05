// draw_dropdown(id,name,list,x,y,xs)
var drop_id,list,xx,yy,xs,ys;
drop_id = argument0;
name = argument1;
list = argument2;
xx = argument3;
yy = argument4;
xs = argument5;

if drop_open[drop_id] {
    ys = 28*string_count(chr(10),list)+10;
} else {
    ys = 28;
}

draw_set_color(main_outline);
draw_box(xx,yy,xx+xs+1,yy+ys,0);
draw_rectangle(xx,yy,xx+xs,yy+6,0);

draw_set_color(0);
// the whole clicky ting
if in_box(xx,yy,xx+xs,yy+ys) {
    if(!popup || (popup && string_pos("popup_",name) == 1))
        window_hover = name;
} else {
    if window_hover == name {
        window_hover = "";
        window_set_cursor(cr_default);
    }
}
if window_hover == name {
    if drop_open[drop_id] {
        for(i = 0; i < string_count(chr(10),list); i += 1) {
            if mouse_y > yy+28*i && mouse_y < yy+28*(i+1) {
                draw_set_alpha(1);
                if mouse_check_button(mb_left) {
                    draw_set_color(main_border);
                } else {
                    draw_set_color(main_faded);
                }
                draw_box(xx+5,yy+28*i+2,xx+xs-5,yy+28*(i+1)+2,0);
                drop_val = i;
                break;
            }
        }
    }
    if window_drag == "" {
        window_set_cursor(cr_handpoint);
    }
}
if window_hover == name && window_drag == "" {
    draw_set_alpha(0.2);
} else {
    draw_set_alpha(0);
}
if window_drag == name {
    if mouse_check_button(mb_left) {
        draw_set_alpha(0.5);
    }
}
if mouse_check_button_released(mb_left) {
    if window_hover == name && window_drag == name {
        drop_open[drop_id] = !drop_open[drop_id];
        ret = true;
        window_set_cursor(cr_default);
    } else {
        drop_open[drop_id] = 0;
    }
}

if drop_open[drop_id] {
    draw_set_alpha(1);
    draw_set_color(c_white);
    var i;
    for(i = 0; i < string_count(chr(10),list); i += 1) {
        draw_text(xx+8,yy+28*i+5,string_split(list,chr(10),i));
    }
} else {
    draw_roundrect(xx,yy,xx+xs,yy+28,0);
    draw_set_alpha(1);
    draw_set_color(c_white);
    draw_text(xx+8,yy,string_split(list,chr(10),drop_val[drop_id]));
}
//end of the dreaded click

//drop_open[drop_id]
//drop_val[drop_id]

//return the number of the selected item
