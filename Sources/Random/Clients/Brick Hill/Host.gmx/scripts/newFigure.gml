// newFigure(name)
var f;
f = instance_create(0,0,obj_figure);
f.Name = string(argument0);

buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 12);
buffer_write_uint32(global.BUFFER, f.figureID);
buffer_write_string(global.BUFFER, "ABCDEFGHIJKLMNOPQRSTUVW");
buffer_write_string(global.BUFFER, f.Name);
buffer_write_float32(global.BUFFER, 0);
buffer_write_float32(global.BUFFER, 0);
buffer_write_float32(global.BUFFER, 0);
buffer_write_uint32(global.BUFFER, 0);
buffer_write_uint32(global.BUFFER, 0);
buffer_write_uint32(global.BUFFER, 0);
buffer_write_float32(global.BUFFER, 1);
buffer_write_float32(global.BUFFER, 1);
buffer_write_float32(global.BUFFER, 1);
buffer_write_uint32(global.BUFFER, f.partColorHead);
buffer_write_uint32(global.BUFFER, f.partColorTorso);
buffer_write_uint32(global.BUFFER, f.partColorLArm);
buffer_write_uint32(global.BUFFER, f.partColorRArm);
buffer_write_uint32(global.BUFFER, f.partColorLLeg);
buffer_write_uint32(global.BUFFER, f.partColorRLeg);
buffer_write_string(global.BUFFER, "0");
buffer_write_string(global.BUFFER, "0");
buffer_write_string(global.BUFFER, "0");
buffer_write_string(global.BUFFER, "0");
buffer_write_string(global.BUFFER, "0");
buffer_write_string(global.BUFFER, "0");
buffer_write_string(global.BUFFER, "0");
buffer_zlib_compress(global.BUFFER);
with obj_client {socket_write_message(SOCKET, global.BUFFER);}

return f;
