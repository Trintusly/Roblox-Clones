// draw_input(name,string,prompt,x,y,xs,ys,outline)
var str,prompt,xx,yy,xs,ys,ret,ol,name,new_string;
name = argument0;
str = string(argument1);
prompt = string(argument2);
xx = argument3;
yy = argument4;
xs = argument5;
ys = argument6;
ol = argument7;

draw_set_color(0);
draw_set_alpha(1);
draw_set_font(fnt_regular);

draw_sprite_ext(spr_button_in,0,xx,yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,1,xx+xs-sprite_get_width(spr_button_in),yy,1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,2,xx+xs-sprite_get_width(spr_button_in),yy+ys-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),1);
draw_sprite_ext(spr_button_in,3,xx,yy+ys-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),1);
draw_rectangle(xx+sprite_get_width(spr_button_in),yy,xx+xs-sprite_get_width(spr_button_in),yy+ys-1,0);
draw_rectangle(xx,yy+sprite_get_height(spr_button_in),xx+xs-1,yy+ys-sprite_get_height(spr_button_in),0);

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
/*if (ol) {//draw_rectangle(xx,yy,xx+xs,yy+ys,1);
    draw_set_color(main_off);
    draw_sprite(spr_button_in,0,xx,yy);
    draw_sprite(spr_button_in,1,xx+xs-sprite_get_width(spr_button),yy);
    draw_sprite(spr_button_in,2,xx+xs-sprite_get_width(spr_button),yy+ys-sprite_get_height(spr_button));
    draw_sprite(spr_button_in,3,xx,yy+ys-sprite_get_height(spr_button));
    draw_rectangle(xx+6,yy,xx+xs-6,yy+ys-1,0);
    draw_rectangle(xx,yy+6,xx+xs-1,yy+ys-6,0);
    
    draw_set_color(main_boutline);
    draw_sprite(spr_button,0,xx,yy);
    draw_sprite(spr_button,1,xx+xs-sprite_get_width(spr_button),yy);
    draw_sprite(spr_button,2,xx+xs-sprite_get_width(spr_button),yy+ys-sprite_get_height(spr_button));
    draw_sprite(spr_button,3,xx,yy+ys-sprite_get_height(spr_button));
    draw_rectangle(xx+6,yy,xx+xs-6,yy+1,0);
    draw_rectangle(xx+xs-2,yy+6,xx+xs-1,yy+ys-6,0);
    draw_rectangle(xx+6,yy+ys-2,xx+xs-6,yy+ys-1,0);
    draw_rectangle(xx,yy+6,xx+1,yy+ys-6,0);
}*/

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
        window_set_cursor(cr_beam);
    }
}
if window_hover == name && window_drag == "" {
    //draw_set_alpha(0.2);
} else {
    //draw_set_alpha(0);
}
if window_drag == name {
    if mouse_check_button(mb_left) {
        //draw_set_alpha(0.5);
    }
}
new_string = str;
if mouse_check_button_pressed(mb_left) && window_hover == name && window_drag == name {
    new_string = get_string(prompt,str);
    window_set_cursor(cr_default);
}
//end of the dreaded click

//draw_rectangle(xx,yy,xx+xs,yy+ys,0);
draw_set_color(main_boutline);
draw_box(xx,yy,xx+xs,yy+ys,0);
draw_set_alpha(1);
draw_set_color(c_white);
draw_text(xx+6,yy+2,string_limit(new_string,xs-6));

next_x = xx+xs;
next_y = yy+ys;

return new_string;
