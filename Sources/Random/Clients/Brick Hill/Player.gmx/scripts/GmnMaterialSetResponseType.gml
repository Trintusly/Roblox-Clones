// GMNewton 1.00
//
//Function:  Sets response type between two materials
//Notes:  0 - normal
//        2 - ignore
//        Actually, just disregard this function.  It's not much use
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - mat0
//   Argument2 - mat1
//   Argument3 - action
//call GmnMaterialSetResponseType(dWorld,mat0,mat1,action);
//return: 
return external_call(global.__GmnMaterialSetResponseType__,argument0,argument1,argument2,argument3);
