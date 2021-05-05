// Convert_2d(targetx,targety)
// The script returns the 3d x and y coordinates at z=0
 
screenx=2*(argument0-view_xport[cv_view])/view_wview[cv_view]-1
screeny=1-2*(argument1-view_yport[cv_view])/view_hview[cv_view]
mX=dX+uX*screeny+vX*screenx
mY=dY+uY*screeny+vY*screenx
mZ=dZ+uZ*screeny+vZ*screenx

if mZ!=0 {
    x_3d=cv_xfrom-cv_zfrom*mX/mZ
    y_3d=cv_yfrom-cv_zfrom*mY/mZ
} else {
    x_3d=cv_xfrom-cv_zfrom*mX
    y_3d=cv_yfrom-cv_zfrom*mY
}
