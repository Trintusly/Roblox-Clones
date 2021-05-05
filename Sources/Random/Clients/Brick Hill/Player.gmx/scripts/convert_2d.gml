// convert_2d(x,y,z,xfrom,yfrom,zfrom)
// The script returns the 3d x and y coordinates at z = 0
screenx = 2*argument0/room_width-1;
screeny = 1-2*argument1/room_height;
mX = dX + uX*screeny + vX*screenx;
mY = dY + uY*screeny + vY*screenx;
mZ = dZ + uZ*screeny + vZ*screenx;

if mZ != 0
begin
    x_3d = argument3 - (argument5-argument2) * mX / mZ;
    y_3d = argument4 - (argument5-argument2) * mY / mZ;
end;
else
begin
    x_3d = argument3 - (argument5-argument2) * mX;
    y_3d = argument4 - (argument5-argument2) * mY;
end;
