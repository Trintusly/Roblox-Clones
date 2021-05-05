// GMNewton 1.00
//
//Function:  Creates an up-vector constraint.  This limits rotation to around pin
//Notes:  xUp, yUp, and zUp construct a 3d vector representing pin that body may pivot about
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - xUp
//   Argument2 - yUp
//   Argument3 - zUp
//   Argument4 - dBody
//call GmnConstraintCreateUpVector(dWorld,xUp,yUp,zUp,dBody);
//return: 
return external_call(global.__GmnConstraintCreateUpVector__,argument0,argument1,argument2,argument3,argument4);
