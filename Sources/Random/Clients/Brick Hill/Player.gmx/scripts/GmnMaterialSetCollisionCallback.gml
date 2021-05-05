// GMNewton 1.00
//
//Function:  Sets material type interaction to store collision information
//Notes: Must enable this to catch collision events
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - mat0
//   Argument2 - mat1
//call GmnMaterialSetCollisionCallback(dWorld,mat0,mat1);
//return: 
return external_call(global.__GmnMaterialSetCollisionCallback__,argument0,argument1,argument2);
