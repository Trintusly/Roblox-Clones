//Argument0 - list
//Argument1 - scale
var i;

for(i=0;i<ds_list_size(argument0);i+=1){
   ds_list_replace(argument0,i,ds_list_find_value(argument0,i)*argument1);
}