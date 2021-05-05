// GMNewton 1.00
//
//Function:  Destroys a newton body
//Notes:  Call this to remove a body from the simulation
//        It is importaint to remember this when destroying objects
//         so that the body does not continue to be simulated
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - dBody
//call GmnDestroyBody(dWorld,dBody);
//return: 
return external_call(global.__GmnDestroyBody__,argument0,argument1);
