// string_hex(string) - Returns true if string is hex
var str;
str = argument0;
str = string_replace_all(str,"0","");
str = string_replace_all(str,"1","");
str = string_replace_all(str,"2","");
str = string_replace_all(str,"3","");
str = string_replace_all(str,"4","");
str = string_replace_all(str,"5","");
str = string_replace_all(str,"6","");
str = string_replace_all(str,"7","");
str = string_replace_all(str,"8","");
str = string_replace_all(str,"9","");
str = string_replace_all(str,"A","");
str = string_replace_all(str,"B","");
str = string_replace_all(str,"C","");
str = string_replace_all(str,"D","");
str = string_replace_all(str,"E","");
str = string_replace_all(str,"F","");
if str == "" {
    return true;
} else {
    return false;
}
