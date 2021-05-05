// GMNewton 1.00
//
//Function:  Set friction model used
//Notes:   This command speficies the accuracy of friction used by the exact solver. This command has no effect when using the linear solver.
//        0 is the exact model (default).
//        1 is the adaptive model.
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - model
//call GmnSetFrictionModel(dWorld,model);
//return: 
return external_call(global.__GmnSetFrictionModel__,argument0,argument1);
