// script_encode(string);
var str,temp_str,temp_index,char,i,end_str;
str = argument0;
end_str = str;

temp_str = "";
temp_index = 0;

in_string = false;
string_type = "'";

/*str = string_replace_all(str,"<C>","<\C>");
str = string_replace_all(str,"<O>","<\O>");
str = string_replace_all(str,"<F>","<\F>");
str = string_replace_all(str,"<P>","<\P>");
str = string_replace_all(str,"<D>","<\D>");
str = string_replace_all(str,"<V>","<\V>");
str = string_replace_all(str,"<S>","<\S>");
str = string_replace_all(str,"</>","<\/>");*/
str = string_replace_all(str,"<","<\");
if(keyboard_check_pressed(vk_f1)) {show_message(end_str+chr(10)+str);}
for(i=1;i<=string_length(str);i+=1) {
    char = string_char_at(str,i);
    
    if(string_char_at(str,i) == "/" && string_char_at(str,i+1) == "/") {
        //str = string_insert("<C>",str,i);
        str = string_copy(str,1,i-1)+"<C>"+string_copy(str,i,string_length(str)+1-i);
        temp_str = "";
        break;
    }
    
    if(string_lettersdigits(string_replace(char,"_","")) == string_replace(char,"_","")) { //it's a-Z0-9_
        if(temp_str == "") {
            if(ds_list_find_index(script_safechars,string_char_at(str,i-1)) != -1 || i <= 1) {
                temp_index = i;
                temp_str += char;
            }
        } else {
            temp_str += char;
        }
    } else {
        if(!in_string && (char == "{" || char == "}")) {
            str = string_insert("</>",str,i+1);
            str = string_insert("<O>",str,i);
            i += 6;
        }
        if(temp_str != "" && !in_string) {
            if ds_list_find_index(script_operators,temp_str) != -1 {
                str = string_insert("</>",str,i);
                str = string_insert("<O>",str,temp_index); //operator
                i += 3;
            } else if ds_list_find_index(script_functions,temp_str) != -1 {
                str = string_insert("</>",str,i);
                str = string_insert("<F>",str,temp_index); //function
                i += 3;
            } else if ds_list_find_index(script_constants,temp_str) != -1 {
                str = string_insert("</>",str,i);
                str = string_insert("<P>",str,temp_index); //constant
                i += 3;
            } else {
                if(string_digits(temp_str) == temp_str) {
                    str = string_insert("</>",str,i);
                    str = string_insert("<D>",str,temp_index); //digit
                    i += 3;
                } else {
                    str = string_insert("</>",str,i);
                    str = string_insert("<V>",str,temp_index); //variable
                    i += 3;
                }
            }
        }
        temp_str = "";
        if(char == "'" || char == '"') {
            //string
            if(!in_string) {
                string_type = char;
                in_string = true;
                str = string_insert("<S>",str,i);
                i += 3;
            } else {
                if char == string_type {
                    in_string = false;
                    str = string_insert("</>",str,i+1);
                    i += 3;
                }
            }
        }
    }
}

if(temp_str != "" && !in_string) {
    if ds_list_find_index(script_operators,temp_str) != -1 {
        str = string_insert("</>",str,i);
        str = string_insert("<O>",str,temp_index); //operator
        i += 3;
    } else if ds_list_find_index(script_functions,temp_str) != -1 {
        str = string_insert("</>",str,i);
        str = string_insert("<F>",str,temp_index); //function
        i += 3;
    } else if ds_list_find_index(script_constants,temp_str) != -1 {
        str = string_insert("</>",str,i);
        str = string_insert("<P>",str,temp_index); //constant
        i += 3;
    } else {
        if(string_digits(temp_str) == temp_str) {
            str = string_insert("</>",str,i);
            str = string_insert("<D>",str,temp_index); //digit
            i += 3;
        } else {
            str = string_insert("</>",str,i);
            str = string_insert("<V>",str,temp_index); //variable
            i += 3;
        }
    }
}

return str+" ";
