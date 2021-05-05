// GMNewton 1.00
//
//Function:  Retrieves the tourque to be applied next update for a given axis
//Notes:  axis is as follows:  x-0, y-1, z-2
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - axis
//call GmnBodyGetTorque(dBody,axis);
//return: 
return external_call(global.__GmnBodyGetTorque__,argument0,argument1);
