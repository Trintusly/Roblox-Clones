/// string_reverse(string)
var str,flip,i;
str = string(argument0);
flip = "";
for (i=string_length(str);i>= 1;i-=1) {
    flip += string_copy(str,i,1);
}
return flip;
