// send_command(command, arguments)
buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 3);
buffer_write_string(global.BUFFER, argument0);
buffer_write_string(global.BUFFER, argument1);
buffer_zlib_compress(global.BUFFER);
socket_write_message(SOCKET, global.BUFFER);
