//string_limit(str,wid)
var str,wid,nstr,a;
str=argument0
wid=argument1
nstr=""
for (a=1 a<=string_length(str) a+=1) {
    if (string_width(nstr+"... ")>wid) {
        nstr+="..."
        break
    } else {
        nstr+=string_char_at(str,a)
        if (string_char_at(str,a+1)="#") {
            nstr+="#"
            a+=1
        }
    }
}
return nstr;
