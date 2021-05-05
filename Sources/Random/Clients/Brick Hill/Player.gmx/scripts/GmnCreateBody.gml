// GMNewton 1.00
//
//Function:  Creates a body in the newton world
//Notes:  The concept of bodies is quite simple.  If you understand GM, understanding bodies should be easy.
//        Bodies in Newton are as objects are in GM.
//        Collisions are as sprites or masks used for collision
//        Bodies must be created in a "world"
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - dCollision
//call GmnCreateBody(dWorld,dCollision);
//return: 
return external_call(global.__GmnCreateBody__,argument0,argument1);
