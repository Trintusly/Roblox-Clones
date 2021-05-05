// camera_control();
if popup {
    return 0;
}
if lock {
    direction += (sw-window_mouse_get_x())/4;
    zdirection += (sh-window_mouse_get_y())/(64/9);
    window_mouse_set(sw,sh);
    zdirection=min(max(zdirection,-89),89);
}
if in_world() {
    if keyboard_check(vk_space) {
        velocity = 30*1.6/max(1,fps);
    } else if keyboard_check(vk_shift) {
        velocity = 30*0.4/max(1,fps);
    } else {
        velocity = 30*0.8/max(1,fps);
    }
    
    if keyboard_check(ord("W")) {
        x += cos(degtorad(direction))*cos(degtorad(zdirection))*velocity;
        y -= sin(degtorad(direction))*cos(degtorad(zdirection))*velocity;
        z += sin(degtorad(zdirection))*velocity;
    }
    if keyboard_check(ord("A")) {
        x += cos(degtorad(direction+90))*velocity;
        y -= sin(degtorad(direction+90))*velocity;
    }
    if keyboard_check(ord("S")) {
        x += cos(degtorad(direction+180))*cos(degtorad(zdirection))*velocity;
        y -= sin(degtorad(direction+180))*cos(degtorad(zdirection))*velocity;
        z += sin(degtorad(zdirection+180))*velocity;
    }
    if keyboard_check(ord("D")) {
        x += cos(degtorad(direction+270))*velocity;
        y -= sin(degtorad(direction+270))*velocity;
    }
    if keyboard_check(ord("E")) {
        z += velocity;
    }
    if keyboard_check(ord("Q")) {
        z -= velocity;
    }
    
    camcos = cos(degtorad(direction))*cos(degtorad(zdirection));
    camsin = sin(degtorad(direction))*cos(degtorad(zdirection));
    camtan = sin(degtorad(zdirection));
    
    if mouse_check_button_pressed(mb_right) {lock = true; sw = window_mouse_get_x(); sh = window_mouse_get_y();}
    if !mouse_check_button(mb_right) {lock = false;}
    
    xfrom = x;
    yfrom = y;
    zfrom = z;
    xto = x+camcos;
    yto = y-camsin;
    zto = z+camtan;
} else {
    lock = false;
}
