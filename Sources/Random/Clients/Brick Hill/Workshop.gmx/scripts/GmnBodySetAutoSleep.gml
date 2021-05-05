// GMNewton 1.00
//
//Function:  Sets if Newton may put a body to sleep after it is unactive for a time
//Notes:  Sleeping is a low-processing state that an unmoving body is placed in if allowed.
//        Bodies will automatically wake up and resume simulation if an outside force is applied
//        Or contact is made with another body
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - state (true/false)
//call GmnBodySetAutoSleep(dBody,state);
//return: 
return external_call(global.__GmnBodySetAutoSleep__,argument0,argument1);
