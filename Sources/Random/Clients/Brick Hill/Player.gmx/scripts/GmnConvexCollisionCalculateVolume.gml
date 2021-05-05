// GMNewton 1.00
//
//Function:  Calculates the approximate volume of a convex collision
//Notes:  Useful to set the mass of an object based on density and volume
//        (Not to be used on collision trees, as they are not necessarily closed shapes)
//
//Arguments:
//   Argument0 - dCollision
//call GmnConvexCollisionCalculateVolume(dCollision);
//return: 
return external_call(global.__GmnConvexCollisionCalculateVolume__,argument0);
