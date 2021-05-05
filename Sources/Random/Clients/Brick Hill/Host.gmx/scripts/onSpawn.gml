// onSpawn(client)
argument0.alive = true;
argument0.Health = argument0.maxHealth;
with obj_client {
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 8);
    buffer_write_float32(global.BUFFER, argument0.net_id);
    buffer_write_uint8(global.BUFFER, 0);
    socket_write_message(SOCKET, global.BUFFER);
}
playerSetCameraPosition(argument0, argument0.xPos, argument0.yPos, argument0.zPos);
playerSetCameraRotation(argument0, 0, 0, 0);
playerSetCameraType(argument0, "orbit");
playerSetCameraObject(argument0, argument0);
playerSetFOV(argument0, 60);

execute("onSpawn",argument0);
/*
argument0.alive = true;
with obj_client {
    buffer_clear(global.BUFFER);
    buffer_write_uint8(global.BUFFER, 8);
    buffer_write_float32(global.BUFFER, argument0.net_id);
    buffer_write_uint8(global.BUFFER, 0);
    socket_write_message(SOCKET, global.BUFFER);
}
playerSetCameraPosition(argument0, argument0.xPos, argument0.yPos, argument0.zPos);
playerSetCameraRotation(argument0, 0, 0, 0);
playerSetCameraType(argument0, "orbit");
playerSetCameraObject(argument0, argument0);
playerSetFOV(argument0, 60);
