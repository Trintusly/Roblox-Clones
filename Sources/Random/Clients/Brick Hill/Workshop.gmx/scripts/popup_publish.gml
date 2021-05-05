// popup_paint()
var w,h,xx,yy,nextY;
w = 448;
h = 251;
xx = round(popup_x-w/2);
yy = round(popup_y-h/2);

if mouse_check_button_pressed(mb_left) {
    if mouse_x > xx && mouse_x < xx+w && mouse_y > yy && mouse_y < yy+34 {
        popup_drag_last_x = mouse_x;
        popup_drag_last_y = mouse_y;
        popup_drag = true;
    } else if mouse_y > yy+h {
        if window_hover == ""
            popup = false;
    }
}
if popup_drag {
    popup_drag_x = mouse_x;
    popup_drag_y = mouse_y;
    
    popup_x -= popup_drag_last_x-popup_drag_x;
    popup_y -= popup_drag_last_y-popup_drag_y;
    
    popup_drag_last_x = mouse_x;
    popup_drag_last_y = mouse_y;
    draw_set_alpha(0.1);
    var bl;
    for(bl = 0; bl < 4; bl += 1) {
        draw_roundrect(xx-bl,yy-bl,xx+w+bl,yy+h+bl,0);
    }
} else {
    if xx < 0 {
        popup_x = floor(xx/2+w/2);
    } else if xx+w > room_width {
        popup_x = floor((xx+room_width-w)/2+w/2);
    }
    
    if yy < 0 {
        popup_y = floor(yy/2+h/2);
    } else if yy+h > room_height {
        popup_y = floor((yy+room_height-h)/2+h/2);
    }
}
if mouse_check_button_released(mb_left) {
    popup_drag = false;
}
draw_set_alpha(1);
draw_set_color(col_main);
draw_box(xx,yy,xx+w,yy+h,0);
draw_set_color(c_white);
draw_set_font(fnt_bold);
draw_text(xx+10,yy+2,"Publish");
draw_set_color(main_outline);
draw_line(xx,yy+34,xx+w-1,yy+34);

next_x = xx+16;
next_y = yy+34+14;

draw_set_font(fnt_regular);
draw_set_color(c_white);
draw_text(next_x,next_y,"Username");
next_y += 20;
next_x -= 4;

var old_name,old_pass;
old_name = account_username;
old_pass = account_password;

account_username = draw_input("popup_publish_name",account_username,"Username",next_x,next_y,130,28,0);

next_y += 14;
next_x -= 126;
draw_set_font(fnt_regular);
draw_set_color(c_white);
draw_text(next_x,next_y,"Password");
next_y += 20;
next_x -= 4;

account_password = draw_input("popup_publish_pass",account_password,"Password",next_x,next_y,130,28,0);
draw_set_color(main_boutline);
draw_set_alpha(1);
draw_rectangle(next_x-126,next_y-24,next_x-4,next_y-4,0);
draw_set_color(c_white);
draw_text(next_x-124,next_y-26,string_limit(string_repeat("* ",string_length(account_password)),124));

next_y += 8;
next_x -= 130;
if publish_result == "error" {
    draw_set_font(fnt_small);
    draw_set_color($0d00de);
    draw_text(next_x,next_y,"Wrong Password");
}

next_y += 32;
draw_set_color(button_yellow);if draw_button2("popup_publish_login","Publish",-1,next_x,next_y,84,32,1) {
    if gameCount > 0 {
        publish(real(string_split(my_game[drop_val[dropdown_publish]]," ",0)));
        popup = false;
    }
}

if (old_name != account_username || old_pass != account_password) && (account_password != "" && account_username != "") {
    var attempt;
    attempt = login(account_username,account_password);
    if attempt > 0 {
        publish_result = "";
        var gameList,g;
        gameList = games(attempt);
        for(g = 0; g < string_count(chr(10),gameList); g += 1) {
            my_game[g] = string_split(gameList,chr(10),g);
        }
        gameCount = g;
    } else {
        publish_result = "error";
    }
}

draw_set_color(c_white);
next_x = xx+183;
next_y = yy+34+14;
if background_exists(bkg_world) {
    draw_background_ext(bkg_world,next_x,next_y,245/background_get_width(bkg_world),136/background_get_height(bkg_world),0,c_white,1);
}
next_y += 136;
if gameCount > 0 {
var g,gameList,gid;
gameList = "";
for(g = 0; g < gameCount; g += 1) {
    gid = string_split(my_game[g]," ",0);
    gameList += string_replace(my_game[g],gid+" ","")+chr(10);
}
draw_dropdown(dropdown_publish,"popup_dropdown_publish",gameList,next_x,next_y,245);
}
