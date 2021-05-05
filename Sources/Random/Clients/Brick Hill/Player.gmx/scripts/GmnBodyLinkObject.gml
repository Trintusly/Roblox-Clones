// GMNewton 1.00
//
//Function:  Links a GM object and a Newton body together
//Notes:  This makes it possible to do two things:
//          1) Generate correct collision responses in Game Maker
//          2) Allow GMNewton to automatically update transformation of object
//        Setting the body to auto-update is optional
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - objid
//   Argument2 - autoupdate
//call GmnBodyLinkObject(dBody,objid,autoupdate);
//return: 
return external_call(global.__GmnBodyLinkObject__,argument0,argument1,argument2);
