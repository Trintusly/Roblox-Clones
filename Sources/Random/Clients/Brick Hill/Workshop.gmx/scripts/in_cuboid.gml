// in_cuboid(x1,y1,z1,x2,y2,z2,x3,y3,z3)
var x1,y1,z1,x2,y2,z2,x3,y3,z3;
x1 = argument0;
y1 = argument1;
z1 = argument2;
x2 = argument3;
y2 = argument4;
z2 = argument5;
x3 = argument6;
y3 = argument7;
z3 = argument8;
if x3 >= x1 {
    if x3 <= x2 {
        if y3 >= y1 {
            if y3 <= y2 {
                if z3 >= z1 {
                    if z3 <= z2 {
                        return true;
                    }
                }
            }
        }
    }
}
return false;
