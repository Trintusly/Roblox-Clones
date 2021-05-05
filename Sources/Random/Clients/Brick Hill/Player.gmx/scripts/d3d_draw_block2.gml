// d3d_draw_block2(x1,y1,z1,x2,y2,z2,texid,hrepeat,vrepeat)
var x1,y1,z1,x2,y2,z2,texid,hrepeat,vrepeat;
x1 = argument0;
y1 = argument1;
z1 = argument2;
x2 = argument3;
y2 = argument4;
z2 = argument5;
texid = argument6;
hrepeat = argument7;
vrepeat = argument8;

d3d_draw_floor(x1,y2,z2,x2,y1,z2,texid,hrepeat,vrepeat);
d3d_draw_floor(x1,y1,z1,x2,y2,z1,texid,hrepeat,vrepeat);
d3d_draw_wall(x1,y1,z1,x2,y1,z2,texid,hrepeat,vrepeat);
d3d_draw_wall(x2,y1,z1,x2,y2,z2,texid,hrepeat,vrepeat);
d3d_draw_wall(x2,y2,z1,x1,y2,z2,texid,hrepeat,vrepeat);
d3d_draw_wall(x1,y2,z1,x1,y1,z2,texid,hrepeat,vrepeat);
