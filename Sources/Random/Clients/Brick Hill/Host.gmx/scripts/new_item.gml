// new_item(name)
var i;
i = instance_create(0,0,obj_item);
i.slotID = i.id;
i.name = argument0;
i.Script = "";
i.Model = "";

if instance_number(obj_client) > 0 {
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 11);
    buffer_write_uint8(global.BUFFER, 1);
    buffer_write_uint32(global.BUFFER, i.slotID);
    buffer_write_string(global.BUFFER, i.name);
    buffer_write_string(global.BUFFER, i.Model);
    buffer_zlib_compress(global.BUFFER);
    with obj_client {socket_write_message(SOCKET, global.BUFFER);}
}

with obj_client {
    tool[toolNum] = i;
    toolNum += 1;
}

return i;
