// GMNewton 1.00
//
//Function:  Set the script to be called when joint is severed
//Notes:  must have initiated gmi for this to work
//        breaking is the removal of limits
//        severing is the removal of joint
//
//Arguments:
//   Argument0 - dHinge
//   Argument1 - script
//call GmnCustomHingeSetSeverCallscript(dHinge,script);
//return: 
return external_call(global.__GmnCustomHingeSetSeverCallscript__,argument0,argument1);
