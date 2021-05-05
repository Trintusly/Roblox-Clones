// convert_3d(targetx,targety,targetz,CamXPos,from,CamZPos,view)
var pX, pY, pZ, mm;
pX = argument0 - obj_client.CamXPos;
pY = argument1 - obj_client.CamYPos;
pZ = argument2 - obj_client.CamZPos;
mm = pX*dX + pY*dY + pZ*dZ;
     
if mm > 0
begin
    pX /= mm;
    pY /= mm;
    pZ /= mm;
end;
else 
begin
    x_2d = 0;
    y_2d = -100;
    return 0;
end;

mm = (pX*vX + pY*vY + pZ*vZ) / sqr((room_width/room_height)*tan(FOV*pi/360));
x_2d = (mm+1)/2*room_width;
mm = (pX*uX + pY*uY + pZ*uZ) / sqr(tan(FOV*pi/360));
y_2d = (1-mm)/2*room_height;
return 1;
