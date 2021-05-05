// GMNewton 1.00
//
//Function:  Set the current platform hardware architecture.
//Notes:  <taken from NGD Wiki>
//This function allows the application to configure the Newton to take advantage for specific hardware architecture in the same platform.
//0 - force the hardware lower common denominator for the running platform.
//1 - will try to use common floating point enhancement like spacial instruction set on the specific architecture. This mode made lead to result that differ from mode 1 and 2 as the accumulation round off errors maybe different.
//2 - the engine will try to use the best possible hardware setting found in the current platform this is the default configuration. This mode made lead to result that differ from mode 1 and 2 as the accumulation round off errors maybe different.
//the only hardware mode guarantee to work is mode 0. all other are only hints to the engine, for example setting mode 1 will take not effect on CPUs without specially floating point instructions set.
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - mode
//call GmnSetPlatformArchitecture(dWorld,mode);
//return: 
return external_call(global.__GmnSetPlatformArchitecture__,argument0,argument1);
