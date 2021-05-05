// in_point(x1,y1,x2,y2,x3,y3)
var x1,y1,x2,y2;
x1 = argument0;
y1 = argument1;
x2 = argument2;
y2 = argument3;
x3 = argument4;
y3 = argument5;
if x3 >= x1 && x3 <= x2 {
    if y3 >= y1 && y3 <= y2 {
        return true;
    }
}
return false;
