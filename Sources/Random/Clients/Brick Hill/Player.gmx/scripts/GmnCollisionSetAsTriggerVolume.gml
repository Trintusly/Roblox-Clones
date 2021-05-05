// GMNewton 1.00
//
//Function:  Turns the collision into a trigger volume or vice versa
//Notes:  Trigger volumes are different from normal collisions in that they don't generate contacts. They are useful to trigger events if a body hits the trigger volume.
//        Only convex collision primitives can be used as trigger volumes.
//
//Arguments:
//   Argument0 - dCollision
//   Argument1 - trigger
//call GmnCollisionSetAsTriggerVolume(dCollision,trigger);
//return: 
return external_call(global.__GmnCollisionSetAsTriggerVolume__,argument0,argument1);
