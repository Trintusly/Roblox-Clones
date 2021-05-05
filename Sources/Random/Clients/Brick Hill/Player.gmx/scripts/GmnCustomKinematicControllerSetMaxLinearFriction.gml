// GMNewton 1.00
//
//Function:  Sets the amount of force required to overcome position constraint of joint
//Notes:  "alpha" is strength of control, or amount of outside force required to overcome the control
//
//Arguments:
//   Argument0 - dJoint
//   Argument1 - alpha
//call GmnCustomKinematicControllerSetMaxLinearFriction(dJoint,alpha);
//return: 
return external_call(global.__GmnCustomKinematicControllerSetMaxLinearFriction__,argument0,argument1);
