// draw_checkbox(x,y,checked);
var checked,xx,yy;
xx = argument0;
yy = argument1;
checked = argument2;
draw_sprite(spr_check,checked,xx,yy);
inBox = (mouse_x >= xx && mouse_y >= yy && mouse_x <= xx+sprite_get_width(spr_check) && mouse_y <= yy+sprite_get_height(spr_check));
if mouse_check_button_released(mb_left) && inBox {
    return !checked;
} else {
    return checked;
}
