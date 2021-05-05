// messageExclude(id player, string message)
show_message("MESSAGEEXCLUDE()");
with obj_client {
    if(id != argument0) {
        buffer_clear(global.BUFFER);
        buffer_write_uint8(global.BUFFER, 6);
        buffer_write_string(global.BUFFER, argument0);
        socket_write_message(SOCKET, global.BUFFER);
    }
}
