//Argument0 - list

var str, i;
str="";

for(i=0;i<ds_list_size(argument0);i+=1){
   str+=string(ds_list_find_value(argument0,i))+"#";
}

show_message(str)