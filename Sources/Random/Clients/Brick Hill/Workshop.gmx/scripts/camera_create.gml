d3d_start();
d3d_set_perspective(true);
direction = 0;
zdirection = -20;
x = 0;
y = 0;
z = 10;
sw = 0;
sh = 0;

velocity = 0.8;
lock = false;
camfov = 70;

camcos = cos(degtorad(direction))*cos(degtorad(zdirection));
camsin = sin(degtorad(direction))*cos(degtorad(zdirection));
camtan = sin(degtorad(zdirection));

xfrom = x;
yfrom = y;
zfrom = z;
xto = x+camcos;
yto = y-camsin;
zto = z+camtan;
