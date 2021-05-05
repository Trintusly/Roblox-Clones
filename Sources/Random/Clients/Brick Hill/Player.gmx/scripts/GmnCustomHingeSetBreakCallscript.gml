// GMNewton 1.00
//
//Function:  Sets the script called when joint brakes
//Notes:  gmi must be inited for this to work
//        breaking is the removal of limits
//        severing is the removal of joint
//
//Arguments:
//   Argument0 - dHinge
//   Argument1 - script
//call GmnCustomHingeSetBreakCallscript(dHinge,script);
//return: 
return external_call(global.__GmnCustomHingeSetBreakCallscript__,argument0,argument1);
