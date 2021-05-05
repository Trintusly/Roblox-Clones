// point_in_circle(x1, y1, x2, y2, radius)
var x1,y1,x2,y2,rad;
x1 = argument0;
y1 = argument1;
x2 = argument2;
y2 = argument3;
rad = argument4;

if power(x2-x1,2)+power(y2-y1,2) <= power(rad,2) {
    return true;
} else {
    return false;
}
