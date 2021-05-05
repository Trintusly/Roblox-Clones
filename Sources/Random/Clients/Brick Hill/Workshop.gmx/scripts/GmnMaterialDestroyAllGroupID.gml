// GMNewton 1.00
//
//Function:  Destroys all materials in world
//Notes:
//        This function removes all groups ID from the Newton world
//        It is useful when you wish to reset the newton world completely to create a new simulation.
//        Only call after there are no more bodies in world
//
//Arguments:
//   Argument0 - dWorld
//call GmnMaterialDestroyAllGroupID(dWorld);
//return: 
return external_call(global.__GmnMaterialDestroyAllGroupID__,argument0);
