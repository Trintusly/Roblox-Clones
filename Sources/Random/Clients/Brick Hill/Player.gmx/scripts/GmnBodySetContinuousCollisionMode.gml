// GMNewton 1.00
//
//Function:  Turns CCD on or off for body
//Notes:  ContinuousCollisionDetection prevents small, fast-moving bodies from passing through other bodies
//        CCD is slower than normal processing, and should be applied only when needed to maintain simulation speed
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - state (true/false)
//call GmnBodySetContinuousCollisionMode(dBody,state);
//return: 
return external_call(global.__GmnBodySetContinuousCollisionMode__,argument0,argument1);
