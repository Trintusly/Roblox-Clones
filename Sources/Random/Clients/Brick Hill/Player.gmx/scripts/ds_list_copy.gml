//copies a list to a new one
//argument0 - list
//returns new list id
var i,list;
list=ds_list_create();
for(i=0;i<ds_list_size(argument0);i+=1){
   ds_list_add(list,ds_list_find_value(argument0,i));
}
return(list);