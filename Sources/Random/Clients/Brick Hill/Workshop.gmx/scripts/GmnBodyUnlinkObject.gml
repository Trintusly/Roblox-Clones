// GMNewton 1.00
//
//Function:  Unlinks a GM object and the Newton body it is linked to
//Notes:  Until re-enabled, the object will not be automatically updated
//        and objects will not be identified in collisions for event generation
//
//Arguments:
//   Argument0 - dBody
//call GmnBodyUnlinkObject(dBody);
//return: 
return external_call(global.__GmnBodyUnlinkObject__,argument0);
