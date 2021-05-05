// send_auth()
buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 1);
buffer_write_string(global.BUFFER, token);
buffer_write_string(global.BUFFER, version);
buffer_zlib_compress(global.BUFFER);
socket_write_message(SOCKET, global.BUFFER);
