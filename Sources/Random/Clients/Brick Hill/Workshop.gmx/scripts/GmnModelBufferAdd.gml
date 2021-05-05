// GMNewton 1.00
//
//Function:  Adds a point to the model buffer
//Notes:  GMNewton has a model buffer that is used to transfer models to it point by point or convex hull generation
//
//Arguments:
//   Argument0 - x
//   Argument1 - y
//   Argument2 - z
//call GmnModelBufferAdd(x,y,z);
//return: 
return external_call(global.__GmnModelBufferAdd__,argument0,argument1,argument2);
