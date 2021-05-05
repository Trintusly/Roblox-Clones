// draw_button_spr2(name,sprite,subimg,x,y,xs,ys,outline)
var spr,sub,xx,yy,xs,ys,ret,ol,name,col;
name = argument0;
spr = argument1;
sub = argument2;
xx = argument3;
yy = argument4;
xs = argument5;
ys = argument6;
ol = argument7;
ret = false;
col = draw_get_color();

xs = max(xs,sprite_get_width(spr)+2);
ys = max(ys,sprite_get_height(spr)+2);

draw_set_color(main_outline);
/*draw_sprite_ext(spr_button_in,0,xx,yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,1,xx+xs-sprite_get_width(spr_button),yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,2,xx+xs-sprite_get_width(spr_button),yy+ys-sprite_get_height(spr_button),1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,3,xx,yy+ys-sprite_get_height(spr_button),1,1,0,draw_get_color(),1);
draw_rectangle(xx+sprite_get_width(spr_button),yy+1,xx+xs-1-sprite_get_width(spr_button),yy+ys-2,0);
draw_rectangle(xx+1,yy+sprite_get_height(spr_button),xx+xs-2,yy+ys-sprite_get_height(spr_button)-1,0);*/
draw_sprite_ext(spr_button_in,0,xx,yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,1,xx+xs-sprite_get_width(spr_button_in),yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,2,xx+xs-sprite_get_width(spr_button_in),yy+ys-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,3,xx,yy+ys-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),1);
draw_rectangle(xx+sprite_get_width(spr_button_in),yy,xx+xs-sprite_get_width(spr_button_in),yy+ys-1,0);
draw_rectangle(xx,yy+sprite_get_height(spr_button_in),xx+xs-1,yy+ys-sprite_get_height(spr_button_in),0);

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

draw_set_color(0);
draw_set_alpha(1);
draw_set_font(fnt_regular);
//draw_sprite(spr,sub,xx+(xs-sprite_get_width(spr))/2,yy+(ys-sprite_get_height(spr))/2);
draw_sprite_ext(spr,sub,xx+(xs-sprite_get_width(spr))/2,yy+(ys-sprite_get_height(spr))/2,1,1,0,col,1);

next_x = xx+xs;
next_y = yy+ys;

return ret;
