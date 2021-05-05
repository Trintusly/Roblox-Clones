// ray_cast();
var pointx,pointy,pointz,dist;
MxRay = xfrom+(MxRay-xfrom)*100;
MyRay = yfrom+(MyRay-yfrom)*100;
MzRay = zfrom+(MzRay-zfrom)*100;
dist = GmnWorldRayCastDist(global.set,xfrom,yfrom,zfrom,MxRay,MyRay,MzRay);
pointx = xfrom+(MxRay-xfrom)*dist;
pointy = yfrom+(MyRay-yfrom)*dist;
pointz = zfrom+(MzRay-zfrom)*dist;

ray_x = pointx+0.02*(MxRay-xfrom)/max(1,abs(MxRay-xfrom));
ray_y = pointy+0.02*(MyRay-yfrom)/max(1,abs(MyRay-yfrom));
ray_z = pointz+0.02*(MzRay-zfrom)/max(1,abs(MzRay-zfrom));
