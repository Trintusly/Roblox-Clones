// GMNewton 1.00
//
//Function:  Sets velocity of player controller for next step.
//Notes:
//
//Arguments:
//   Argument0 - dJoint
//   Argument1 - dVelocity - forward velocity
//   Argument2 - dStrafeVelocity - sideways velocity
//   Argument3 - dHeadinAngle - direction in degrees
//call GmnCustomPlayerControllerSetVelocity(dJoint,dVelocity,dStrafeVelocity,dHeadinAngle);
//return: 
return external_call(global.__GmnCustomPlayerControllerSetVelocity__,argument0,argument1,argument2,argument3);
