// messageAll(string message)
with obj_client {
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 6);
    buffer_write_string(global.BUFFER, argument0);
    buffer_zlib_compress(global.BUFFER);
    socket_write_message(SOCKET, global.BUFFER);
}
print(argument0);
