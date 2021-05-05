// GMNewton 1.00
//
//Function:  Sets target rotation of kinematic joint.
//Notes:  I don't recall if this takes radians or degrees....  Experiment for now and will eventually take degrees for sure
//
//Arguments:
//   Argument0 - dJoint
//   Argument1 - xr
//   Argument2 - yr
//   Argument3 - zr
//call GmnCustomKinematicControllerSetTargetRotation(dJoint,xr,yr,zr);
//return: 
return external_call(global.__GmnCustomKinematicControllerSetTargetRotation__,argument0,argument1,argument2,argument3);
