// ray_center(distance)
var dist,length;
length = argument0;
xTo = xfrom+cos(degtorad(direction))*cos(degtorad(zdirection))*length;
yTo = yfrom-sin(degtorad(direction))*cos(degtorad(zdirection))*length;
zTo = zfrom+sin(degtorad(zdirection))*length;

dist = GmnWorldRayCastDist(global.set,xfrom,yfrom,zfrom,xTo,yTo,zTo)*length;
if dist < 0 {dist = 20;}
xTo = xfrom+cos(degtorad(direction))*cos(degtorad(zdirection))*dist;
yTo = yfrom-sin(degtorad(direction))*cos(degtorad(zdirection))*dist;
zTo = zfrom+sin(degtorad(zdirection))*dist;
