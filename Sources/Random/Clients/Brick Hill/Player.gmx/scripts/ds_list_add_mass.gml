//argument0 - list id
//Argument1 - #of elements to add
//Argument2-Argumentx - new elements

var i;

for(i=0;i<argument1;i+=1){
   ds_list_add(argument0,argument[2+i]);
}

return(1);
