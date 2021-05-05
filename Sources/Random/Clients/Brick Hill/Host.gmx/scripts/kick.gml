// kick(id player, string message)
with argument0 {
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 7);
    buffer_write_string(global.BUFFER, "kick");
    buffer_write_string(global.BUFFER, argument1);
    socket_write_message(SOCKET, global.BUFFER);
}
