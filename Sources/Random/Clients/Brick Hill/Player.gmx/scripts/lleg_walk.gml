// lleg_walk(frame)
var f;
f = argument0*8 mod 360;

return -((sin(degtorad(f))-1)*30+30);
