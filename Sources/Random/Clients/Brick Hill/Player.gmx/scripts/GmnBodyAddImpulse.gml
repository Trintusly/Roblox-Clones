// GMNewton 1.00
//
//Function:  Adds an impulse to body at given position and magnitude
//Notes:  Applied in global space, with impulse representing change in velocity
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - xOrig
//   Argument2 - yOrig
//   Argument3 - zOrig
//   Argument4 - xImpulse
//   Argument5 - yImpulse
//   Argument6 - zImpulse
//call GmnBodyAddImpulse(dBody,xOrig,yOrig,zOrig,xImpulse,yImpulse,zImpulse);
//return: 
return external_call(global.__GmnBodyAddImpulse__,argument0,argument1,argument2,argument3,argument4,argument5,argument6);
