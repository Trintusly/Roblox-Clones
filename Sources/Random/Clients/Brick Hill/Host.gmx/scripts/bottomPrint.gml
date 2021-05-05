// bottomPrint(id player, string message, int seconds)
buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 7);
buffer_write_string(global.BUFFER, "bottomPrint");
buffer_write_string(global.BUFFER, argument1);
buffer_write_uint32(global.BUFFER, argument2);
socket_write_message(argument0.SOCKET, global.BUFFER);
