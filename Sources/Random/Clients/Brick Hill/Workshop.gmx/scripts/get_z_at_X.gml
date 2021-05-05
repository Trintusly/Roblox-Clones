// get_z_at_X(targetx,targety,x)
// The script returns the 3d x and y coordinates at z=0
x_3d = argument2;

screenx=2*(argument0-view_xport[cv_view])/view_wview[cv_view]-1
screeny=1-2*(argument1-view_yport[cv_view])/view_hview[cv_view]
mX=dX+uX*screeny+vX*screenx
mY=dY+uY*screeny+vY*screenx
mZ=dZ+uZ*screeny+vZ*screenx

if mZ!=0 {
    z_3d=cv_zfrom-(cv_xfrom-x_3d)/(mX/mZ)
} else {
    z_3d=cv_zfrom-(cv_xfrom-x_3d)/mX
}
