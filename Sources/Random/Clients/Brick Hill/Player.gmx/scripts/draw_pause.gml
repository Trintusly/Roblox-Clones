// draw_pause()
draw_set_color(0);
draw_set_alpha(0.6);
draw_rectangle(0,0,room_width,room_height,0);

SETTINGS_Models = draw_checkbox(10,10,SETTINGS_Models);
SETTINGS_Animations = draw_checkbox(10,38,SETTINGS_Animations);
