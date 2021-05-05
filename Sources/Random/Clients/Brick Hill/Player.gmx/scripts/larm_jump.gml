// larm_jump(frame)
var f;
f = argument0*5 mod 90;

if f >= 85 {
    frame = argument0-1;
}
return sin(degtorad(f))*180;
