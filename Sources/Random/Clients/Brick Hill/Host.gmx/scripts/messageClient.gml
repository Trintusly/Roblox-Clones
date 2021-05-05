// messageClient(id player, string message)
buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 6);
buffer_write_string(global.BUFFER, argument1);
socket_write_message(argument0.SOCKET, global.BUFFER);
