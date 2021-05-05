// draw_box(x1,y1,x2,y2,outline);
var x1,y1,x2,y2,out;
x1 = argument0;
y1 = argument1;
x2 = argument2;
y2 = argument3;
out = argument4;

/*draw_sprite_ext(spr_button_in,0,x1,y1,1,1,0,draw_get_color(),draw_get_alpha());
draw_sprite_ext(spr_button_in,1,x2-sprite_get_width(spr_button_in),y1,1,1,0,draw_get_color(),draw_get_alpha());
draw_sprite_ext(spr_button_in,2,x2-sprite_get_width(spr_button_in),y2-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),draw_get_alpha());
draw_sprite_ext(spr_button_in,3,x1,y2-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),draw_get_alpha());
draw_rectangle(x1+sprite_get_width(spr_button_in),y1+1,x2-sprite_get_width(spr_button_in),y2-2,0);
draw_rectangle(x1+1,y1+sprite_get_height(spr_button_in),x2-2,y2-sprite_get_height(spr_button_in),0);*/
draw_sprite_ext(spr_button_in,0,x1,y1,1,1,0,draw_get_color(),draw_get_alpha());
draw_sprite_ext(spr_button_in,1,x2-sprite_get_width(spr_button_in),y1,1,1,0,draw_get_color(),draw_get_alpha());
draw_sprite_ext(spr_button_in,2,x2-sprite_get_width(spr_button_in),y2-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),draw_get_alpha());
draw_sprite_ext(spr_button_in,3,x1,y2-sprite_get_height(spr_button_in),1,1,0,draw_get_color(),draw_get_alpha());
draw_rectangle(x1+sprite_get_width(spr_button_in),y1,x2-sprite_get_width(spr_button_in),y2-1,0);
draw_rectangle(x1,y1+sprite_get_height(spr_button_in),x2-1,y2-sprite_get_height(spr_button_in),0);
if out {
    draw_set_color(main_boutline);
    draw_sprite(spr_button,0,x1,y1);
    draw_sprite(spr_button,1,x2-sprite_get_width(spr_button),y1);
    draw_sprite(spr_button,2,x2-sprite_get_width(spr_button),y2-sprite_get_height(spr_button));
    draw_sprite(spr_button,3,x1,y2-sprite_get_height(spr_button));
    draw_line(x1+sprite_get_width(spr_button),y1,x2-sprite_get_width(spr_button),y1);
    draw_line(x2-1,y1+sprite_get_height(spr_button),x2-1,y2-sprite_get_height(spr_button));
    draw_line(x1+sprite_get_width(spr_button),y2-1,x2-sprite_get_width(spr_button),y2-1);
    draw_line(x1,y1+sprite_get_height(spr_button),x1,y2-sprite_get_height(spr_button));
}

next_x = x2;
next_y = y2;
