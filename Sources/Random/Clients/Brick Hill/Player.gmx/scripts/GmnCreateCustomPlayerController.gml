// GMNewton 1.00
//
//Function:  Creates a player controller joint
//Notes:  Stair is the height a player can step up.  It is 0 - 1 and is percentage of player height
//        Padding is padding around player
//
//Arguments:
//   Argument0 - dBody
//   Argument1 - dStair
//   Argument2 - dPadding
//call GmnCreateCustomPlayerController(dBody,dStair,dPadding);
//return: 
return external_call(global.__GmnCreateCustomPlayerController__,argument0,argument1,argument2);
