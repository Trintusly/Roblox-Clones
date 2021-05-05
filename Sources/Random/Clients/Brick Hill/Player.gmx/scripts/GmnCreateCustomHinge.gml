// GMNewton 1.00
//
//Function:  Creates a custom hinge joint
//Notes:  position and pin.  pin is a vector around which hinge rotation is allowed
//
//Arguments:
//   Argument0 - xOrig
//   Argument1 - yOrig
//   Argument2 - zOrig
//   Argument3 - xPin
//   Argument4 - yPin
//   Argument5 - zPin
//   Argument6 - dChildBody
//   Argument7 - dParentBody
//call GmnCreateCustomHinge(xOrig,yOrig,zOrig,xPin,yPin,zPin,dChildBody,dParentBody);
//return: 
return external_call(global.__GmnCreateCustomHinge__,argument0,argument1,argument2,argument3,argument4,argument5,argument6,argument7);
