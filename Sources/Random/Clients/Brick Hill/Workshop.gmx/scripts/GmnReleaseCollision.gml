// GMNewton 1.00
//
//Function:  Releases a collision shape returning control to Newton
//Notes:  Collision objects are reference counted objects. The application should call NewtonReleaseCollision in order to release references to the object. Neglecting to release references to collision primitives is a common cause of memory leaks.
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - dCollision
//call GmnReleaseCollision(dWorld,dCollision);
//return: 
return external_call(global.__GmnReleaseCollision__,argument0,argument1);
