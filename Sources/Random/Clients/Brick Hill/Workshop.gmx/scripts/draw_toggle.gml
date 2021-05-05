// draw_toggle(name,string,icon,x,y,xs,ys,outline,toggled)
var str,icon,xx,yy,xs,ys,ret,ol,name,tog,col;
name = argument0;
str = argument1;
icon = argument2;
xx = argument3;
yy = argument4;
xs = argument5;
ys = argument6;
ol = argument7;
tog = argument8;
ret = false;
col = draw_get_color();

if icon < 0 {
    xs = max(xs,string_width(str)+4);
    ys = max(ys,string_height(str)+4);
} else {
    xs = max(xs,sprite_get_width(spr_icons)+2);
    ys = max(ys,sprite_get_height(spr_icons)+2);
}


/*draw_sprite_ext(spr_button_in,0,xx,yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,1,xx+xs-sprite_get_width(spr_button),yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,2,xx+xs-sprite_get_width(spr_button),yy+ys-sprite_get_height(spr_button),1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,3,xx,yy+ys-sprite_get_height(spr_button),1,1,0,draw_get_color(),1);
draw_rectangle(xx+sprite_get_width(spr_button),yy+1,xx+xs-1-sprite_get_width(spr_button),yy+ys-2,0);
draw_rectangle(xx+1,yy+sprite_get_height(spr_button),xx+xs-2,yy+ys-sprite_get_height(spr_button)-1,0);*/
draw_sprite_ext(spr_button_in,0,xx+1,yy+1,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,1,xx+xs-sprite_get_width(spr_button_in)-1,yy+1,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,2,xx+xs-sprite_get_width(spr_button_in)-1,yy+ys-sprite_get_height(spr_button_in)-1,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,3,xx+1,yy+ys-sprite_get_height(spr_button_in)-1,1,1,0,draw_get_color(),1);
draw_rectangle(xx+sprite_get_width(spr_button_in),yy+1,xx+xs-sprite_get_width(spr_button_in)-1,yy+ys-2,0);
draw_rectangle(xx+1,yy+sprite_get_height(spr_button_in),xx+xs-2,yy+ys-sprite_get_height(spr_button_in)-1,0);

draw_set_color(0);
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
    draw_set_alpha(0.2);
} else {
    draw_set_alpha(0);
}
if window_drag == name {
    if mouse_check_button(mb_left) {
        draw_set_alpha(0.5);
    }
}
if tog {
    draw_set_alpha(0.5);
}
if mouse_check_button_released(mb_left) && window_hover == name && window_drag == name {
    ret = true;
    window_set_cursor(cr_default);
}
draw_rectangle(xx+1,yy+1,xx+xs-2,yy+ys-2,0);


//end of the dreaded click
draw_set_color(col);
draw_set_alpha(1);
if (ol) {
    draw_set_color(main_boutline);
    draw_sprite(spr_button,0,xx,yy);
    draw_sprite(spr_button,1,xx+xs-sprite_get_width(spr_button),yy);
    draw_sprite(spr_button,2,xx+xs-sprite_get_width(spr_button),yy+ys-sprite_get_height(spr_button));
    draw_sprite(spr_button,3,xx,yy+ys-sprite_get_height(spr_button));
    draw_line(xx+sprite_get_width(spr_button),yy,xx+xs-sprite_get_width(spr_button),yy);
    draw_line(xx+xs-1,yy+sprite_get_height(spr_button),xx+xs-1,yy+ys-sprite_get_height(spr_button));
    draw_line(xx+sprite_get_width(spr_button),yy+ys-1,xx+xs-sprite_get_width(spr_button),yy+ys-1);
    draw_line(xx,yy+sprite_get_height(spr_button),xx,yy+ys-sprite_get_height(spr_button));
}

/*draw_set_alpha(1);
draw_set_font(fnt_regular);
draw_sprite_ext(spr_button_in,0,xx,yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,1,xx+xs-sprite_get_width(spr_button),yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,2,xx+xs-sprite_get_width(spr_button),yy+ys-sprite_get_height(spr_button),1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,3,xx,yy+ys-sprite_get_height(spr_button),1,1,0,draw_get_color(),1);
draw_rectangle(xx+sprite_get_width(spr_button),yy+1,xx+xs-sprite_get_width(spr_button),yy+ys-2,0);
draw_rectangle(xx+1,yy+sprite_get_height(spr_button),xx+xs-2,yy+ys-sprite_get_height(spr_button),0);
if (ol) {//draw_rectangle(xx,yy,xx+xs,yy+ys,1);
    //draw_set_color(main_off);
    draw_set_color(main_boutline);
    draw_sprite(spr_button,0,xx,yy);
    draw_sprite(spr_button,1,xx+xs-sprite_get_width(spr_button),yy);
    draw_sprite(spr_button,2,xx+xs-sprite_get_width(spr_button),yy+ys-sprite_get_height(spr_button));
    draw_sprite(spr_button,3,xx,yy+ys-sprite_get_height(spr_button));
    draw_line(xx+sprite_get_width(spr_button),yy,xx+xs-sprite_get_width(spr_button),yy);
    draw_line(xx+xs-1,yy+sprite_get_height(spr_button),xx+xs-1,yy+ys-sprite_get_height(spr_button));
    draw_line(xx+sprite_get_width(spr_button),yy+ys-1,xx+xs-sprite_get_width(spr_button),yy+ys-1);
    draw_line(xx,yy+sprite_get_height(spr_button),xx,yy+ys-sprite_get_height(spr_button));
}

// the whole clicky ting
if in_box(xx,yy,xx+xs,yy+ys) {
    window_hover = name;
    if window_drag == "" {
        window_set_cursor(cr_handpoint);
    }
} else {
    if window_hover == name {
        window_hover = "";
        window_set_cursor(cr_default);
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
if tog {
    draw_set_alpha(0.5);
}
if mouse_check_button_released(mb_left) && window_hover == name && window_drag == name {
    ret = true;
    window_set_cursor(cr_default);
}
//end of the dreaded click

draw_rectangle(xx,yy,xx+xs,yy+ys,0);*/
draw_set_alpha(1);
draw_set_color(c_black);
if icon >= 0 {
    //draw_sprite(spr_icons,icon,xx+(xs-18)/2,yy+(ys-18)/2);
    draw_sprite(spr_icons,icon,xx+(xs-sprite_get_width(spr_icons))/2,yy+(ys-sprite_get_height(spr_icons))/2);
} else {
    draw_text(xx+(xs-string_width(str))/2,yy+(ys-string_height(str))/2,str);
}

next_x = xx+xs;
next_y = yy+ys;

return ret;
