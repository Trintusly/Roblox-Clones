// GMNewton 1.00
//
//Function:  Sets if jointed bodies react to each other
//Notes:  Sometimes when two bodies are jointed together it is necessary to disable collisions between them to achieve desired effect
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - state
//call GmnBodySetJointRecursiveCollision(dBody,state);
//return: 
return external_call(global.__GmnBodySetJointRecursiveCollision__,argument0,argument1);
