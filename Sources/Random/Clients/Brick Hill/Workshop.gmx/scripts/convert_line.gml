//convert_line(x,y,z,mx,my,mz,newlen)
var xx,yy,zz,mx,my,mz,newlen,angxy,angz;
xx=argument0
yy=argument1
zz=argument2
mx=argument3
my=argument4
mz=argument5
newlen=argument6

angxy=point_direction(mx,my,xx,yy)
angz=point_zdirection(mx,my,mz,xx,yy,zz)

_nx=mx+lengthdir_x(newlen,angxy)*lengthdir_x(1,angz)
_ny=my+lengthdir_y(newlen,angxy)*lengthdir_x(1,angz)
_nz=mz+lengthdir_z(newlen,angz)
