// ray_find(x1,y1,z1,x2,y2,z2)
var MxRay1,MyRay1,MzRay1,MxRay2,MyRay2,MzRay2;
MxRay1 = argument0;
MyRay1 = argument1;
MzRay1 = argument2;
MxRay2 = argument3;
MyRay2 = argument4;
MzRay2 = argument5;

convert_3d(MxRay1,MyRay1,MzRay1);
if x_2d < room_width && x_2d > 0 && y_2d < room_height && y_2d > 0 {
    MxRay = MxRay1;
    MyRay = MyRay1;
    MzRay = MzRay1;
    return true;
}
convert_3d(MxRay2,MyRay2,MzRay2);
if x_2d < room_width && x_2d > 0 && y_2d < room_height && y_2d > 0 {
    MxRay = MxRay2;
    MyRay = MyRay2;
    MzRay = MzRay2;
    return true;
}
MxRay = -1;
MyRay = -1;
MzRay = -1;
return false;
