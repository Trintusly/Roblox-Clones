// newProjectile(diameter, color, x, y, z, direction, zdirection, speed)
var p;
p = instance_create(0,0,obj_projectile);
p.projectileID = p.id;
p.Diameter = argument0;
p.Color = argument1;
p.xPos = argument2;
p.yPos = argument3;
p.zPos = argument4;
p.Direction = argument5;
p.zDirection = argument6;
p.Velocity = argument7;

if(p.Direction < 0) {p.Direction += 360;}
if(p.zDirection < 0) {p.zDirection += 360;}

buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 13);
buffer_write_uint8(global.BUFFER, 1);
buffer_write_uint32(global.BUFFER, p.projectileID);
buffer_write_uint32(global.BUFFER, p.Diameter);
buffer_write_uint32(global.BUFFER, p.Color);
buffer_write_float32(global.BUFFER, p.xPos);
buffer_write_float32(global.BUFFER, p.yPos);
buffer_write_float32(global.BUFFER, p.zPos);
buffer_write_uint32(global.BUFFER, p.Direction);
buffer_write_uint32(global.BUFFER, p.zDirection);
buffer_write_uint32(global.BUFFER, p.Velocity);
buffer_zlib_compress(global.BUFFER);
with obj_client {socket_write_message(SOCKET, global.BUFFER);}

return p;
