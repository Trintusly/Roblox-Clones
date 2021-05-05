// brickRotate(id brick, int z)
if argument1 mod 90 == 0 {
    with argument0 {
        Rotation = argument1;
        
        buffer_clear(global.BUFFER);
        buffer_write_uint8(global.BUFFER, 9);
        buffer_write_uint32(global.BUFFER, brickID);
        buffer_write_string(global.BUFFER, "rot");
        buffer_write_uint32(global.BUFFER,Rotation);
        buffer_zlib_compress(global.BUFFER);
        with obj_client {socket_write_message(SOCKET, global.BUFFER);}
    }
}
