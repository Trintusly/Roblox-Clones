// gmi
//
//Function:
//Notes:  This sets the script that the dll uses to automatically update a body
//
//Arguments:
//   Argument0 - script [script args:(body,x,y,z,xrot,yrot,zrot)]
//call GmnBodySetForce(script);
//return: 
return external_call(global.__set_script_transform_body__,argument0);

