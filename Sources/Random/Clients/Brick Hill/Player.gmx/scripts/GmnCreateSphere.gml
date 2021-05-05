// GMNewton 1.00
//
//Function:  Creates a spherical collision shape
//Notes:  Define the radius of box on x, y, and z axi
//        Offset moves collision shape from origin by given amount
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - radiusX
//   Argument2 - radiusY
//   Argument3 - radiusZ
//   Argument4 - offset_x
//   Argument5 - offset_y
//   Argument6 - offset_z
//call GmnCreateSphere(dWorld,radiusX,radiusY,radiusZ,offset_x,offset_y,offset_z);
//return: 
return external_call(global.__GmnCreateSphere__,argument0,argument1,argument2,argument3,argument4,argument5,argument6);
