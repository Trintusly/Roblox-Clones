//Convert_3d(targetx,targety,targetz)

var pX,pY,pZ,mm;

pX=argument0-cv_xfrom
pY=argument1-cv_yfrom
pZ=argument2-cv_zfrom
mm=pX*dX+pY*dY+pZ*dZ

if (mm>0) {
    pX/=mm
    pY/=mm
    pZ/=mm
} else {
    pX/=0.000000001
    pY/=0.000000001
    pZ/=0.000000001
    /*x_2d=0
    y_2d=-100
    return 0*/
}

mm=(pX*vX+pY*vY+pZ*vZ)/sqr((view_wview[cv_view]/view_hview[cv_view])*tan(camfov*pi/360))
x_2d=(mm+1)/2*view_wview[cv_view]+view_xport[cv_view];
mm=(pX*uX+pY*uY+pZ*uZ)/sqr(tan(camfov*pi/360))
y_2d=(1-mm)/2*view_hview[cv_view]+view_yport[cv_view];

return x_2d
