/// string_split_last(string,substr,slice)
var str,split,splits,slot,current,slice,i;
str = string(argument0);
split = string(argument1);
slot = 0;
str_split = "";
slice = string_to_real(argument2);
splits[slice] = "";
for (i=string_length(str); i>=1; i-=1) {
    current = string_copy(str,i,string_length(split));
    if (current = split) {
        splits[slot] = str_split;
        slot += 1;
        str_split = "";
        //i -= string_length(split)-1;
    } else {
        str_split += string_copy(str,i,1);
        splits[slot] = str_split;
    }
}
return string_reverse(splits[slice]);
