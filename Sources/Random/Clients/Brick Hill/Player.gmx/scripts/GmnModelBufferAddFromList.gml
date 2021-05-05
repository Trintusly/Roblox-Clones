// GMNewton 1.00
//
//Function:
//Notes:
//
//Arguments:
//   Argument0 - list
//call GmnModelBufferAddFromList(list);
//return: number of points added
var pointcount;
pointcount=floor(ds_list_size(argument0)/3);
for(i=0;i<pointcount;i+=1){
   v_x=ds_list_find_value(argument0,i*3);
   v_y=ds_list_find_value(argument0,i*3+1);
   v_z=ds_list_find_value(argument0,i*3+2);
   //show_message(string(pointcount)+"##"+string(v_x)+"#"+string(v_y)+"#"+string(v_z));
   external_call(global.__GmnModelBufferAdd__,v_x,v_y,v_z);
}

return(pointcount); 
