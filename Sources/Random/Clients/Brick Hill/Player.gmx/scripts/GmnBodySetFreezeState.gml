// GMNewton 1.00
//
//Function:  Puts a body to sleep or wakes it up
//Notes:  Sleeping bodies are not simulated, but are wakened when acted on by outside force
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - state
//call GmnBodySetFreezeState(dBody,state);
//return: 
return external_call(global.__GmnBodySetFreezeState__,argument0,argument1);
