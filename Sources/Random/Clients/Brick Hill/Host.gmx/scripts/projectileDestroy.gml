// projectileDestroy(projectile id);
var p;
p = argument0;
buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 13);
buffer_write_uint8(global.BUFFER, 0);
buffer_write_uint32(global.BUFFER, p.projectileID);
buffer_zlib_compress(global.BUFFER);
with obj_client {socket_write_message(SOCKET, global.BUFFER);}

with argument0 {
    instance_destroy();
}
