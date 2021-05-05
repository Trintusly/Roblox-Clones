// brickScale(id brick, int x, int y, int z)
with argument0 {
    xScale = argument1;
    yScale = argument2;
    zScale = argument3;
    
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 9);
    buffer_write_uint32(global.BUFFER, brickID);
    buffer_write_string(global.BUFFER, "scale");
    buffer_write_float32(global.BUFFER,xScale);
    buffer_write_float32(global.BUFFER,yScale);
    buffer_write_float32(global.BUFFER,zScale);
    buffer_zlib_compress(global.BUFFER);
    with obj_client {socket_write_message(SOCKET, global.BUFFER);}
}
