//Argument0 - path to model.
//Argument1 - scale.  Defaults to 1.
//
//returns model id
//Loades a model to dll from mod file.

var filetext,data,file,modelid,start,count,lines,i,point_count;

if(argument1=0){
   argument1=1;
}
point_count=0;

data=ds_list_create();


if(!file_exists(argument0)) return(-1);//return -1 if file not found

file=file_text_open_read(argument0);
GmnModelBufferClear()//Clear the model buffer
show_debug_message("start load model:"+argument0)
file_text_readln(file);
lines=file_text_read_real(file);
file_text_readln(file);
file_text_readln(file);//navigate to start of model data

for(i=0;i<lines-2;i+=1){
   filetext=file_text_read_string(file);
   if(string_count(" ",filetext)>=3){
      start=string_pos_ext(" " , filetext , 1)+1;
      count=string_pos_ext(" " , filetext , 4)-start
      filetext=string_copy(filetext,start,count);
      ds_list_clear(data);
      string_to_list_ext(filetext," ",data);
      scale_list(data,argument1);
      point_count+=1;
      GmnModelBufferAddFromList(data);
      ds_list_clear(data)
   }else{
      show_debug_message("not enough data in line : "+filetext);
   }
   if(i<lines-3){
      file_text_readln(file);
   }
}
ds_list_destroy(data);
file_text_close(file);
return(1);

