// GMNewton 1.00
//
//Function:  Creates a slider joint
//Notes:  Allows body to slide along pin without rotating
//        (Similar to motion of a drawer in a desk)
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
//call GmnCreateCustomSlider(xOrig,yOrig,zOrig,xPin,yPin,zPin,dChildBody,dParentBody);
//return: 
return external_call(global.__GmnCreateCustomSlider__,argument0,argument1,argument2,argument3,argument4,argument5,argument6,argument7);
