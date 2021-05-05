// bottomPrintAll(string message, int seconds)
with obj_client {
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 7);
    buffer_write_string(global.BUFFER, "bottomPrint");
    buffer_write_string(global.BUFFER, argument0);
    buffer_write_uint32(global.BUFFER, argument1);
    socket_write_message(SOCKET, global.BUFFER);
}
