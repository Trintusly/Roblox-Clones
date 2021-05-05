// brickSetLightRange(id brick, int range)
with argument0 {
    LightRange = argument1;
    
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 9);
    buffer_write_uint32(global.BUFFER, brickID);
    buffer_write_string(global.BUFFER, "lightrange");
    buffer_write_uint32(global.BUFFER, LightRange);
    buffer_zlib_compress(global.BUFFER);
    with obj_client {socket_write_message(SOCKET, global.BUFFER);}
}
