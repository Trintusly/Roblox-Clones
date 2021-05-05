//Appends a list to another list
//
//Argument0 - Main list
//Argument1 - List to add
var i;

for(i=0;i<ds_list_size(argument1);i+=1){
   ds_list_add(argument0,ds_list_find_value(argument1,i));
}
return(ds_list_size(argument0));//Return new size of list