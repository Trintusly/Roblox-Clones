// newTeam(name, color)
var t;
t = instance_create(0,0,obj_team);
t.teamID = t.id;
t.name = argument0;
t.Color = argument1;

if instance_number(obj_client) > 0 {
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 10);
    buffer_write_uint32(global.BUFFER, t.teamID);
    buffer_write_string(global.BUFFER, t.name);
    buffer_write_uint32(global.BUFFER, t.Color);
    buffer_zlib_compress(global.BUFFER);
    with obj_client {socket_write_message(SOCKET, global.BUFFER);}
}

return t;
