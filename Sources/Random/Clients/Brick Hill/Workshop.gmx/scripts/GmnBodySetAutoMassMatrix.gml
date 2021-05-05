// GMNewton 1.00
//
//Function:  Automaticaly calculates moment of inertia values(resistance to rotation) for a convex hull
//Notes:  Only for use on convex collision, not collision trees
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - mass
//   Argument2 - doCom
//call GmnBodySetAutoMassMatrix(dBody,mass,doCom);
//return: 
return external_call(global.__GmnBodySetAutoMassMatrix__,argument0,argument1,argument2);
