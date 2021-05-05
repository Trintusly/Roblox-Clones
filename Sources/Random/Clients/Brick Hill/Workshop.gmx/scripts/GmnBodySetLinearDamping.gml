// GMNewton 1.00
//
//Function:  Sets linear damping of body
//Notes:  The dampening viscous friction force is added to the external force applied to the body every frame before going to the solver-integrator.
//        linearDamp is clamped between 0 and 1, default being .1
//        There is a non zero implicit attenuation value of 0.0001 assumed by the integrator
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - linearDamp
//call GmnBodySetLinearDamping(dBody,linearDamp);
//return: 
return external_call(global.__GmnBodySetLinearDamping__,argument0,argument1);
