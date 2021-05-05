// new_projectile(id,diameter,color,x,y,z,direction,zdirection,velocity);
var p,d,dir,zdir,xv,yv,zv,vel;
p = instance_create(0,0,obj_projectile);
p.projectileID = argument0;
d = argument1;
p.Diameter = d;
p.Color = argument2;
p.xPos = argument3;
p.yPos = argument4;
p.zPos = argument5;
p.xRot = 0;
p.yRot = 0;
p.zRot = 0;
p.Bound = GmnCreateSphere(global.set,d/2,d/2,d/2,0,0,0);
p.Object = GmnCreateBody(global.set,p.Bound);
GmnReleaseCollision(global.set,p.Bound);
GmnBodySetAutoMassMatrix(p.Object,2,false);
GmnBodySetPosition(p.Object,p.xPos,p.yPos,p.zPos);

dir = argument6;
zdir = argument7;
vel = argument8;

xv = cos(degtorad(dir))*cos(degtorad(zdir));
yv = sin(degtorad(dir))*cos(degtorad(zdir));
zv = sin(degtorad(zdir));
GmnBodySetVelocity(p.Object,xv*vel,yv*vel,zv*vel);
