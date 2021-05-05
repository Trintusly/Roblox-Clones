// brickTranslate(id brick, int x, int y, int z)
with argument0 {
    xPos = argument1;
    yPos = argument2;
    zPos = argument3;
    
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 9);
    buffer_write_uint32(global.BUFFER, brickID);
    buffer_write_string(global.BUFFER, "pos");
    buffer_write_float32(global.BUFFER,xPos);
    buffer_write_float32(global.BUFFER,yPos);
    buffer_write_float32(global.BUFFER,zPos);
    buffer_zlib_compress(global.BUFFER);
    with obj_client {socket_write_message(SOCKET, global.BUFFER);}
}
