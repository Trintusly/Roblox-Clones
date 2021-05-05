// player_movement()
if !alive || CamType == "free" {return 0;}

var xp, yp, walk, height, oZRot, Speed;
height = 5*zScale;
xPosP = x;
yPosP = y;
oZRot = zRot;
Speed = (40/max(1,fps))*(maxSpeed/15);

walk = 0;

if is_col(xPos,yPos,zPos,zPos+2,2*xScale,2*yScale) && !is_col(xPos,yPos,zPos+height,zPos+height+2,2*xScale,2*yScale) {zPos += 0.2*(60/max(fps,1));}

if keyboard_check(ord("W")) {
    xVel = cos(degtorad(CamZRot));
    xPos += xVel*(Speed) //Speed
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {xPos -= xVel*(Speed);}
    yVel = -sin(degtorad(CamZRot));
    yPos += yVel*(Speed)
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {yPos -= yVel*(Speed);}
    walk = 1;
}

if keyboard_check(ord("A")) {
    xVel = cos(degtorad(CamZRot+90));
    xPos += xVel*(Speed)
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {xPos -= xVel*(Speed);}
    yVel = -sin(degtorad(CamZRot+90));
    yPos += yVel*(Speed)
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {yPos -= yVel*(Speed);}
    walk = 1;
}
if keyboard_check(ord("S")) {
    xVel = cos(degtorad(CamZRot+180));
    xPos += xVel*(Speed)
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {xPos -= xVel*(Speed);}
    yVel = -sin(degtorad(CamZRot+180));
    yPos += yVel*(Speed)
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {yPos -= yVel*(Speed);}
    walk = 1;
}
if keyboard_check(ord("D")) {
    xVel = cos(degtorad(CamZRot-90));
    xPos += xVel*(Speed)
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {xPos -= xVel*(Speed);}
    yVel = -sin(degtorad(CamZRot-90));
    yPos += yVel*(Speed)
    if is_col(xPos,yPos,zPos+2,zPos+height,2*xScale,2*yScale) {yPos -= yVel*(Speed);}
    walk = 1;
}

if keyboard_check(ord("D")) {NpCamZRot = CamZRot-90;}
if keyboard_check(ord("A")) {NpCamZRot = CamZRot+89.9;}
if keyboard_check(ord("W")) {NpCamZRot = CamZRot;}
if keyboard_check(ord("S")) {NpCamZRot = CamZRot+179.9;}
if keyboard_check(ord("A")) && keyboard_check(ord("S")) {NpCamZRot = CamZRot+135;}
if keyboard_check(ord("D")) && keyboard_check(ord("S")) {NpCamZRot = CamZRot+225;}
if keyboard_check(ord("D")) && keyboard_check(ord("W")) {NpCamZRot = CamZRot+315;}
if keyboard_check(ord("A")) && keyboard_check(ord("W")) {NpCamZRot = CamZRot+45;}
NpCamZRot = NpCamZRot mod 360;

var result;
dir = abs(NpCamZRot-pCamZRot)
if dir < 180 {
    result = ((NpCamZRot+pCamZRot)/2);}
else if dir != 180 {
    result = ((NpCamZRot+pCamZRot)/2)+180;}
else {
    result = pCamZRot;}
pCamZRot = result mod 360;

if CamDist == 0 {pCamZRot = CamZRot; NpCamZRot = pCamZRot;}
zRot = pCamZRot-90;
zRot = zRot-floor(zRot/360)*360;
