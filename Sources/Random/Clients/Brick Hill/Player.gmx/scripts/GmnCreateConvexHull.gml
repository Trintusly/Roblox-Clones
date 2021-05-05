// GMNewton 1.00
//
//Function:  Creates a convex hull collision shape from the points in the model buffer
//Notes:  Offets define position relative to origin
//        tolerance is a value between 0 and 1 telling Newton how much leeway it has in optimizing the hull.
//          0 yields the best representation, while 1 yields the fastest but least acurate representation
//        GMNewton has a model buffer that is used to transfer models to it point by point or convex hull generation
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - offset_x
//   Argument2 - offset_y
//   Argument3 - offset_z
//   Argument4 - tolerance
//call GmnCreateConvexHull(dWorld,offset_x,offset_y,offset_z,tolerance);
//return: 
return external_call(global.__GmnCreateConvexHull__,argument0,argument1,argument2,argument3,argument4);
