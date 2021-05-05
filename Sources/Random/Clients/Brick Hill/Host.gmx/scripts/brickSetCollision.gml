// brickSetCollision(id brick, boolean collide)
with argument0 {
    Collision = argument1;
    
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 9);
    buffer_write_uint32(global.BUFFER, brickID);
    buffer_write_string(global.BUFFER, "collide");
    buffer_write_string(global.BUFFER, Collision);
    buffer_zlib_compress(global.BUFFER);
    with obj_client {socket_write_message(SOCKET, global.BUFFER);}
}
