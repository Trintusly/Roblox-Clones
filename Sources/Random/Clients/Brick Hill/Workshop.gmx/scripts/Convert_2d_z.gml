// Convert_2d_z(targetx,targety,z)
var zz,targetx,targety;
targetx = argument0-view_xport[cv_view];
targety = argument1-view_yport[cv_view];
zz = argument2;
 
screenx=2*targetx/view_wview[cv_view]-1
screeny=1-2*targety/view_hview[cv_view]
mX=dX+uX*screeny+vX*screenx
mY=dY+uY*screeny+vY*screenx
mZ=dZ+uZ*screeny+vZ*screenx

if mZ!=0 {
    x_3d=cv_xfrom-(cv_zfrom-zz)*mX/mZ
    y_3d=cv_yfrom-(cv_zfrom-zz)*mY/mZ
} else {
    x_3d=cv_xfrom-(cv_zfrom-zz)*mX
    y_3d=cv_yfrom-(cv_zfrom-zz)*mY
}
