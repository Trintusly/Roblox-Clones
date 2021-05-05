// GMNewton 1.00
//
//Function:  Casts a ray and returns distance to nearest hit
//Notes:  ray is of finite distance, a line segment from (x1,y1,z1) to (x2,y2,z2)
//        Negative value returned if no hit
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - x1
//   Argument2 - y1
//   Argument3 - z1
//   Argument4 - x2
//   Argument5 - y2
//   Argument6 - z2
//call GmnWorldRayCastDist(dWorld,x1,y1,z1,x2,y2,z2);
//return: 
return external_call(global.__GmnWorldRayCastDist__,argument0,argument1,argument2,argument3,argument4,argument5,argument6);
