// GMNewton 1.00
//
//Function: Destroys a basic joint
//Notes:  For custom joints, use GmnCustomDestroyJoint
//        Joints are automatically destroyed when one of the connected bodies is
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - dJoint
//call GmnDestroyJoint(dWorld,dJoint);
//return: 
return external_call(global.__GmnDestroyJoint__,argument0,argument1);
