// popup_splash()
var w,h,xx,yy,nextY;
w = 456;
h = 251;
xx = round(popup_x-w/2);
yy = round(popup_y-h/2);

draw_set_color(0);
draw_set_alpha(0.4);
draw_rectangle(0,0,room_width,room_height,0);

draw_set_alpha(1);
draw_set_color(col_main);
draw_box(xx,yy,xx+w,yy+h,0);

if background_exists(splash_image) {
    draw_background(splash_image,xx+4,yy+4);
}

draw_set_color(main_faded);
draw_box(xx+4,yy+158+8,xx+w-4,yy+158+36,0);

draw_set_color(c_white);
draw_set_font(fnt_regular);
draw_text(xx+16,yy+158+8,splash_popup);

xx = xx+round((w-112*2-8)/2)
draw_set_color(button_blue);if draw_button2("popup_new_project","New Project",-1,xx,yy+h-44,112,32,1) {new(); popup = false;}
draw_set_color(button_yellow);if draw_button2("popup_open_project","Open Project",-1,next_x+8,yy+h-44,112,32,1) {open(); popup = false;}
