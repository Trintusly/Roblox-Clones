// newBrick(int x, int y, int z, int xsize, int ysize, int zsize, int color, int alpha)
var brick;
brick = instance_create(0,0,obj_brick);
brick.alive = true;
brick.xPos = argument0;
brick.yPos = argument1;
brick.zPos = argument2;
brick.xScale = argument3;
brick.yScale = argument4;
brick.zScale = argument5;
brick.Color = argument6;
brick.Alpha = argument7;
brick.Name = string(obj_server.brickCount);
brick.Shape = "";
brick.Rotation = 0;
brick.NorthSticker = "";
brick.EastSticker = "";
brick.SouthSticker = "";
brick.WestSticker = "";
brick.Model = "";
brick.LightRange = 0;
brick.LightColor = 0;
brick.Collision = true;
brick.isVisible = true;
brick.Script = "";
obj_server.brick[obj_server.brickCount] = brick;
obj_server.brickCount += 1;
brick.brickID = brick.id;
brick.EXECUTED = false;

/*buffer_clear(global.BUFFER);
buffer_write_uint8(global.BUFFER, 2);
sendBrick(brick);
with obj_client {
    socket_write_message(SOCKET, global.BUFFER);
}*/

return brick;
