// GMNewton 1.00
//
//Function:  Creates a basic hinge
//Notes:  Reccomended to use the CustomHinge instead as it supports more options such as breaking
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - xOrig
//   Argument2 - yOrig
//   Argument3 - zOrig
//   Argument4 - xPin
//   Argument5 - yPin
//   Argument6 - zPin
//   Argument7 - dChildBody
//   Argument8 - dParentBody
//call GmnConstraintCreateHinge(dWorld,xOrig,yOrig,zOrig,xPin,yPin,zPin,dChildBody,dParentBody);
//return: 
return external_call(global.__GmnConstraintCreateHinge__,argument0,argument1,argument2,argument3,argument4,argument5,argument6,argument7,argument8);
