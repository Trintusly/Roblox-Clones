/// string_split(string,substr,slice)
msg = argument0;
splitBy = argument1;
slot = 0;
str2 = "";

for (i = 1; i < (string_length(msg)+1); i+=1) {
    currStr = string_copy(msg, i, 1);
    if (currStr == splitBy) {
        splits[slot] = str2;
        slot+=1;
        str2 = "";
    } else {
        str2 = str2 + currStr;
        splits[slot] = str2;
    }
}
return splits[argument2];
