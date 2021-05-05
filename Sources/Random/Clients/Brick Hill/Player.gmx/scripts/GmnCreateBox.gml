// GMNewton 1.00
//
//Function:  Creates a box collision shape
//Notes:  dx, dy, and dz define the length of box on x, y, and z axi
//        Offset moves collision shape from origin by given amount
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - dx
//   Argument2 - dy
//   Argument3 - dz
//   Argument4 - offset_x
//   Argument5 - offset_y
//   Argument6 - offset_z
//call GmnCreateBox(dWorld,dx,dy,dz,offset_x,offset_y,offset_z);
//return: 
return external_call(global.__GmnCreateBox__,argument0,argument1,argument2,argument3,argument4,argument5,argument6);
