// player_physics()
var height;
height = 5*zScale;

GmnUpdate(global.set,1/(fps+1));

//Gravity
if alive {
    zSpeed += 0.05; //round(40/max(1,fps))/20;
} else {
    zSpeed = 0;
}

if is_col(xPos,yPos,zPos-zSpeed,zPos,2*xScale,2*yScale) {zSpeed = 0;}

if textbox_focus == -1 && CamType != "free" && alive {
    if keyboard_check(vk_space) && zSpeed = 0 && JumpState == 0 {
        zSpeed = -1*(maxJumpHeight/5); 
        JumpState = 1;
    }
}

if zSpeed == 0 {
    if JumpState == 2 {
        JumpState = 0;
    } 
    if JumpState == 1 {
        JumpState = 2;
    }
}

zPos -= zSpeed;

if is_col(xPos,yPos,zPos+height,zPos+height-zSpeed,2*xScale,2*yScale) {
    zSpeed = 0;
}
