// GMNewton 1.00
//
//Function: Sets global gravity
//Notes:  Gravity is given for each axis to construct a vector.
//        Magnitude of vector is gravity strength
//        ( i.e. basic gravity on z-axis only:  GmnSetGravity(0,0,-9.8) )
//
//Arguments:
//   Argument0 - xForce
//   Argument1 - yForce
//   Argument2 - zForce
//call GmnSetGravity(xForce,yForce,zForce);
//return: 
return external_call(global.__GmnSetGravity__,argument0,argument1,argument2);
