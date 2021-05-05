//GM Interface
//This is a script used by the dll to auto-update the position and rotation
//of a rigid body.  Although it is not intended to be called or modified by
//the user, advanced users may find it useful to do so.
//
//Argument0 - body id
//Argument1 - x
//Argument2 - y
//Argument3 - z
//Argument4 - xrot
//Argument5 - yrot
//Argument6 - zrot

if(instance_exists(argument0)){
   argument0.x=argument1;
   argument0.y=argument2;
   argument0.z=argument3;
   argument0.xrot=radtodeg(argument4);
   argument0.yrot=radtodeg(argument5);
   argument0.zrot=radtodeg(argument6);
   return(1);
}else{
   return(0);
}