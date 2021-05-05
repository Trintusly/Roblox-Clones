// camera_update()

if mouse_check_button_pressed(mb_right) {
    sw = window_mouse_get_x();
    sh = window_mouse_get_y();
}
if CamDist == 0 || CamType == "first" {
    sw = round(window_get_width()/2);
    sh = round(window_get_height()/2);
}

if CamType != "fixed" && (CamDist == 0 || mouse_check_button(mb_right)) {
    CamZRot += (sw-window_mouse_get_x())/4;
    CamXRot += (sh-window_mouse_get_y())/(64/9);
    window_mouse_set(sw,sh);
    CamXRot=min(max(CamXRot,-89),89);
}

if CamType == "orbit" || CamType == "first" {
    //ORBIT
    var CamCos, CamSin, CamTan;
    CamCos = cos(degtorad(CamZRot))*cos(degtorad(CamXRot));
    CamSin = sin(degtorad(CamZRot))*cos(degtorad(CamXRot));
    CamTan = sin(degtorad(CamXRot));
    
    if CamObj == net_id {
        CamXTo = xPos;
        CamYTo = yPos;
        CamZTo = zPos+5*zScale;
    } else {
        with obj_figure {
            if other.CamObj == net_id {
                other.CamXTo = xPos;
                other.CamYTo = yPos;
                other.CamZTo = zPos+5;
            }
        }
    }
    
    if textbox_focus == -1 {
        if keyboard_check_pressed(ord("I")) || mouse_wheel_up() {CamDist = max(0, CamDist-4);}
        if keyboard_check_pressed(ord("O")) || mouse_wheel_down() {CamDist = min(100, CamDist+4);}
    }
    if CamType == "first" {CamDist = 0;}
    
    //var Dist;
    Dist = (GmnWorldRayCastDist(global.set,xPos,yPos,zPos+5*zScale,xPos-CamCos*(CamDist+2),yPos+CamSin*(CamDist+2),zPos+5*zScale-CamTan*(CamDist+2))*CamDist)+0.1;
    if Dist < 0 {Dist = -Dist}
    
    CamXPos = CamXTo-CamCos*Dist;
    CamYPos = CamYTo+CamSin*Dist;
    CamZPos = CamZTo-CamTan*Dist;
} else if CamType == "free" {
    var velocity;
    if keyboard_check(vk_space) {
        velocity = 30*1.6/max(1,fps);
    } else if keyboard_check(vk_shift) {
        velocity = 30*0.4/max(1,fps);
    } else {
        velocity = 30*0.8/max(1,fps);
    }
    
    if keyboard_check(ord("W")) {
        CamXPos += cos(degtorad(CamZRot))*cos(degtorad(CamXRot))*velocity;
        CamYPos -= sin(degtorad(CamZRot))*cos(degtorad(CamXRot))*velocity;
        CamZPos += sin(degtorad(CamXRot))*velocity;
    }
    if keyboard_check(ord("D")) {
        CamXPos += cos(degtorad(CamZRot+90))*velocity;
        CamYPos -= sin(degtorad(CamZRot+90))*velocity;
    }
    if keyboard_check(ord("S")) {
        CamXPos += cos(degtorad(CamZRot+180))*cos(degtorad(CamXRot))*velocity;
        CamYPos -= sin(degtorad(CamZRot+180))*cos(degtorad(CamXRot))*velocity;
        CamZPos += sin(degtorad(CamXRot+180))*velocity;
    }
    if keyboard_check(ord("A")) {
        CamXPos += cos(degtorad(CamZRot+270))*velocity;
        CamYPos -= sin(degtorad(CamZRot+270))*velocity;
    }
    if keyboard_check(ord("E")) {
        CamZPos += velocity;
    }
    if keyboard_check(ord("Q")) {
        CamZPos -= velocity;
    }
    
    var camcos,camsin,camtan;
    camcos = cos(degtorad(CamXRot))*cos(degtorad(CamZRot));
    camsin = sin(degtorad(CamXRot))*cos(degtorad(CamZRot));
    camtan = sin(degtorad(CamZRot));
    
    if mouse_check_button_pressed(mb_right) {lock = true; sw = window_mouse_get_x(); sh = window_mouse_get_y();}
    
    if !mouse_check_button(mb_right) {lock = false;}
    
    CamXTo = CamXPos-camcos;
    CamYTo = CamYPos+camsin;
    CamZTo = CamZPos-camtan;
}
