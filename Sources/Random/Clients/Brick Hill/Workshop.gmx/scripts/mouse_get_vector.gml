//same arguments as d3d_projection_ext() except the last two

var mm,dX,dY,dZ,uX,uY,uZ,vX,vY,vZ,mX,mY,mZ, width, height, tFOV;
dX = argument3-argument0;
dY = argument4-argument1;
dZ = argument5-argument2;
mm = sqrt(dX*dX+dY*dY+dZ*dZ);

dX /= mm;
dY /= mm;
dZ /= mm;
uX = argument6;
uY = argument7;
uZ = argument8;
mm = uX*dX+uY*dY+uZ*dZ;
uX -= mm*dX;
uY -= mm*dY;
uZ -= mm*dZ
mm = sqrt(uX*uX+uY*uY+uZ*uZ);
uX /= mm;
uY /= mm;
uZ /= mm;
// v = u x d
vX = uY*dZ-dY*uZ;
vY = uZ*dX-dZ*uX;
vZ = uX*dY-dX*uY;
tFOV = tan(argument9*pi/360);
uX *= tFOV;
uY *= tFOV;
uZ *= tFOV;
vX *= tFOV*argument10;
vY *= tFOV*argument10;
vZ *= tFOV*argument10;
width = window_get_width();
height = window_get_height();
mX = dX+uX*(1-2*mouse_y/height)+vX*(2*mouse_x/width-1);
mY = dY+uY*(1-2*mouse_y/height)+vY*(2*mouse_x/width-1);
mZ = dZ+uZ*(1-2*mouse_y/height)+vZ*(2*mouse_x/width-1);
mm = sqrt(mX*mX+mY*mY+mZ*mZ);
global.mouse_dx = mX/mm;
global.mouse_dy = mY/mm;
global.mouse_dz = mZ/mm;
