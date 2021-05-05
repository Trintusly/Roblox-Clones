//Argument0 - string
//Argument1 - seperating character
//
//returns list id

var i, list, strpos, text, cnt;
text=argument0;
list=ds_list_create()

//show_message(string(string_pos(argument1,text)))

ds_list_add(list,string_copy(text,1,string_pos(argument1,text)-1));
text=string_copy(text,string_pos(argument1,argument0)+1,string_length(text)-string_pos(argument1,text))

cnt=string_count(argument1,text)
//show_message(string(cnt))
for(i=0;i<cnt;i+=1){
   ds_list_add(list,string_copy(text,1,string_pos(argument1,text)-1));
   text=string_copy(text,string_pos(argument1,text)+1,string_length(text))
}
ds_list_add(list,string_copy(text,1,string_length(text)));

return(list);


