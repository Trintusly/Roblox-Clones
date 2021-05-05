// convert_2d_z(targetx,targety,z)
var zz,targetx,targety;
targetx = argument0;
targety = argument1;
zz = argument2;
 
screenx=2*targetx/room_width-1
screeny=1-2*targety/room_height
mX=dX+uX*screeny+vX*screenx
mY=dY+uY*screeny+vY*screenx
mZ=dZ+uZ*screeny+vZ*screenx

if mZ!=0 {
    x_3d=obj_client.CamXPos-(obj_client.CamZPos-zz)*mX/mZ
    y_3d=obj_client.CamYPos-(obj_client.CamZPos-zz)*mY/mZ
} else {
    x_3d=obj_client.CamXPos-(obj_client.CamZPos-zz)*mX
    y_3d=obj_client.CamYPos-(obj_client.CamZPos-zz)*mY
}
