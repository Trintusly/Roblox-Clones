// brickSetLightColor(id brick, int color)
with argument0 {
    LightColor = argument1;
    
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 9);
    buffer_write_uint32(global.BUFFER, brickID);
    buffer_write_string(global.BUFFER, "lightcol");
    buffer_write_uint32(global.BUFFER, LightColor);
    buffer_zlib_compress(global.BUFFER);
    with obj_client {socket_write_message(SOCKET, global.BUFFER);}
}
