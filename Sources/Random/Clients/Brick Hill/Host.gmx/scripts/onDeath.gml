// onDeath(client)
execute("onDeath",argument0);
/*argument0.alive = false;

buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 8);
buffer_write_float32(global.BUFFER, argument0.net_id);
buffer_write_uint8(global.BUFFER, 1);
with obj_client {socket_write_message(SOCKET, global.BUFFER);}

centerPrint(argument0, "You will respawn in 4 seconds...", 1);
schedule(1000, "centerPrint("+string(argument0)+",'You will respawn in 3 seconds...',1)");
schedule(2000, "centerPrint("+string(argument0)+",'You will respawn in 2 seconds...',1)");
schedule(3000, "centerPrint("+string(argument0)+",'You will respawn in 1 seconds...',1)");

schedule(4000, "playerRespawn("+string(argument0)+")");
