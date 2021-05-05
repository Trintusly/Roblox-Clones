// GMNewton 1.00
//
//Function: Sets the center of mass of a body
//Notes:  By default, this is set to (0,0,0) local body space
//        New COM is given in offset from local origin ob body
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - Xoffset
//   Argument2 - Yoffset
//   Argument3 - Zoffset
//call GmnBodySetCentreOfMass(dBody,Xoffset,Yoffset,Zoffset);
//return: 
return external_call(global.__GmnBodySetCentreOfMass__,argument0,argument1,argument2,argument3);
