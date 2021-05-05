// GMNewton 1.00
//
//Function:  Sets the if bodies connected by joint can collide with eachother
//Notes:  Use GmnCustomJointSetCollisionState for custom joints
//
//Arguments:
//   Argument0 - dJoint
//   Argument1 - state
//call GmnJointSetCollisionState(dJoint,state);
//return: 
return external_call(global.__GmnJointSetCollisionState__,argument0,argument1);
