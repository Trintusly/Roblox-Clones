// messageTeam(id team, string message)
with obj_client {
    if(team == argument0) {
        buffer_clear(global.BUFFER);
        buffer_write_uint8(global.BUFFER, 6);
        buffer_write_string(global.BUFFER, argument1);
        socket_write_message(SOCKET, global.BUFFER);
    }
}
