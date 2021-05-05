// GMNewton 1.00
//
//Function:  Creates a dry rolling friction joint
//Notes:  Simulates friction so rolling spheres come to halt eventually.
//        Because of the nature of mathematical approximation of a spherical object, only one point of contact generates friction
//          This joint simulates the slight flattening at bottom of a rolling sphere that adds friction
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - radius
//   Argument2 - friction
//call GmnCustomConstraintCreateDryRollingFriction(dBody,radius,friction);
//return: 
return external_call(global.__GmnCustomConstraintCreateDryRollingFriction__,argument0,argument1,argument2);
