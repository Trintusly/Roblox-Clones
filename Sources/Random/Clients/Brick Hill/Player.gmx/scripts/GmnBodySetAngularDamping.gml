// GMNewton 1.00
//
//Function:  Sets rotational damping of body
//Notes:  damping on each axis is clamped between 0 and 1
//        There is a non zero implicit attenuation value of 0.0001 assumed by the integrator
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - angularDampX
//   Argument2 - angularDampY
//   Argument3 - angularDampZ
//call GmnBodySetAngularDamping(dBody,angularDampX,angularDampY,angularDampZ);
//return: 
return external_call(global.__GmnBodySetAngularDamping__,argument0,argument1,argument2,argument3);
