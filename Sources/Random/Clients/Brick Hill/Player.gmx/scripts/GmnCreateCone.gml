// GMNewton 1.00
//
//Function:  Creates a cone collision shape
//Notes:  'radius' defines base, and 'height' the height
//        Offset moves collision shape from origin
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - radius
//   Argument2 - height
//   Argument3 - offset_x
//   Argument4 - offset_y
//   Argument5 - offset_z
//call GmnCreateCone(dWorld,radius,height,offset_x,offset_y,offset_z);
//return: 
return external_call(global.__GmnCreateCone__,argument0,argument1,argument2,argument3,argument4,argument5);
