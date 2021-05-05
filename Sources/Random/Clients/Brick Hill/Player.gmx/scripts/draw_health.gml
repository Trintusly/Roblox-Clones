// draw_health();
var ratio, height;

height = 100;

ratio = obj_client.Health/obj_client.maxHealth;

draw_set_color(c_red);
draw_rectangle(room_width-20,room_height-10-height,room_width-10,room_height-10,0);

draw_set_color(c_green);
draw_rectangle(room_width-20,room_height-10-height*ratio,room_width-10,room_height-10,0);

draw_set_color(0);
draw_rectangle(room_width-20,room_height-10-height,room_width-10,room_height-10,1);
