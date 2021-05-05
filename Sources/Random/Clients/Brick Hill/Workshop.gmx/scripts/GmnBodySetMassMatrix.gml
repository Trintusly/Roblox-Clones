// GMNewton 1.00
//
//Function:  Sets up the mass and moment of inertia
//Notes:  Mass defines the resistance to motion
//        Ixx, Iyy, and Izz are the resistance to rotation on the given axis
//        The function GmnBodySetAutoMassMatrix can calculate this automatically
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - mass
//   Argument2 - Ixx
//   Argument3 - Iyy
//   Argument4 - Izz
//call GmnBodySetMassMatrix(dBody,mass,Ixx,Iyy,Izz);
//return: 
return external_call(global.__GmnBodySetMassMatrix__,argument0,argument1,argument2,argument3,argument4);
