// playerAddItem(id player, id item)
with argument0 {
    tool[toolNum] = argument1;
    toolNum += 1;
    
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 11);
    buffer_write_uint8(global.BUFFER, 1);
    buffer_write_uint32(global.BUFFER, argument1.slotID);
    buffer_write_string(global.BUFFER, argument1.name);
    buffer_zlib_compress(global.BUFFER);
    socket_write_message(other.SOCKET, global.BUFFER);
}
