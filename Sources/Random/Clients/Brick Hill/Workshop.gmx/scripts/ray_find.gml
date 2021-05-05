// ray_find(x1,y1,z1,x2,y2,z2)
var MxRay1,MyRay1,MzRay1,MxRay2,MyRay2,MzRay2;
MxRay1 = argument0;
MyRay1 = argument1;
MzRay1 = argument2;
MxRay2 = argument3;
MyRay2 = argument4;
MzRay2 = argument5;

Convert_3d(MxRay1,MyRay1,MzRay1);
if in_point(view_xport[view_3d],view_yport[view_3d],view_xport[view_3d]+view_wport[view_3d],view_yport[view_3d]+view_hport[view_3d],x_2d,y_2d) {
    MxRay = MxRay1;
    MyRay = MyRay1;
    MzRay = MzRay1;
    return true;
}
Convert_3d(MxRay2,MyRay2,MzRay2);
if in_point(view_xport[view_3d],view_yport[view_3d],view_xport[view_3d]+view_wport[view_3d],view_yport[view_3d]+view_hport[view_3d],x_2d,y_2d) {
    MxRay = MxRay2;
    MyRay = MyRay2;
    MzRay = MzRay2;
    return true;
}
MxRay = -1;
MyRay = -1;
MzRay = -1;
return false;
