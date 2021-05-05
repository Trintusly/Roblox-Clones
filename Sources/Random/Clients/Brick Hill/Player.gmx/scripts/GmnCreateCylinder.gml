// GMNewton 1.00
//
//Function:  Creates a cylinder collision shape
//Notes:  "radius" defines the radius of the cylinder, and "height" the height.
//        This was really a useful note eh?
//        Offsets shift the shape from the origin
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - radius
//   Argument2 - height
//   Argument3 - offset_x
//   Argument4 - offset_y
//   Argument5 - offset_z
//call GmnCreateCylinder(dWorld,radius,height,offset_x,offset_y,offset_z);
//return: 
return external_call(global.__GmnCreateCylinder__,argument0,argument1,argument2,argument3,argument4,argument5);
