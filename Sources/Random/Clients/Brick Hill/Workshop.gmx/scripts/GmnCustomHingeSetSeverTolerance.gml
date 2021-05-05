// GMNewton 1.00
//
//Function:  Sets the force at which joint severs
//Notes:
//        breaking is the removal of limits
//        severing is the removal of joint
//
//Arguments:
//   Argument0 - dHinge
//   Argument1 - forceTolerance
//   Argument2 - torqueTolerance
//call GmnCustomHingeSetSeverTolerance(dHinge,forceTolerance,torqueTolerance);
//return: 
return external_call(global.__GmnCustomHingeSetSeverTolerance__,argument0,argument1,argument2);
