//  GMNewton
//
//argument0 - TreeCollision
//argument1 - path to model.
//argument2 - scale.  Defaults to 1.
//
//returns model id
//Loades a model to dll from mod file.

var filetext,data,file,start,count,lines,i,facesadded,collision,triangles;

if(argument2=0){
   argument2=1;
}

triangles=ds_list_create();
facesadded=0;

data=ds_list_create();

if(!file_exists(argument1)) return(-1);//return -1 if file not found

file=file_text_open_read(argument1);
show_debug_message("start load model:"+argument1)
file_text_readln(file);
lines=file_text_read_real(file);
file_text_readln(file);
file_text_readln(file);//navigate to start of model data
global.debug=0;
for(i=0;i<lines-2;i+=1){
   filetext=file_text_read_string(file);
   if(string_count(" ",filetext)>=3){
      start=string_pos_ext(" " , filetext , 1)+1;
      count=string_pos_ext(" " , filetext , 4)-start
      filetext=string_copy(filetext,start,count);
      ds_list_clear(data);
      string_to_list_ext(filetext," ",data);
      scale_list(data,argument2);
      ds_list_add_list(triangles,data)
      ds_list_clear(data)
   }else{
      show_debug_message("not enough data in line : "+filetext+"  id:"+string(modelid));
   }
   if(i<lines-3){
      file_text_readln(file);
   }
}
ds_list_destroy(data);
file_text_close(file);

for(i=0;i<ds_list_size(triangles);i+=9){
   facesadded=ds_list_size(triangles)/3;
   GmnTreeCollisionAddFace(argument0, ds_list_find_value(triangles,i), ds_list_find_value(triangles,i+1), ds_list_find_value(triangles,i+2),
   ds_list_find_value(triangles,i+3), ds_list_find_value(triangles,i+4), ds_list_find_value(triangles,i+5),
   ds_list_find_value(triangles,i+6), ds_list_find_value(triangles,i+7), ds_list_find_value(triangles,i+8),
   1);
}
ds_list_destroy(triangles);

return(facesadded);
