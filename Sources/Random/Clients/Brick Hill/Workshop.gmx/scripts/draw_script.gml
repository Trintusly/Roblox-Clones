// draw_script(x,y,text,sel);
var str,temp_str,i;
temp_str = "";
xx = argument0;
yy = argument1;
str = argument2;
sel = argument3;

if(!sel) {
    draw_set_color(script_text);
    draw_set_font(fnt_code);
    for(i=1;i<=string_length(str);i+=1) {
        if(string_char_at(str,i-2) == chr(10)) {
            xx = argument0;
            yy = yy+string_height(" ");
        }
        if(string_copy(str,i,3) == "<O>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_operation);
            draw_set_font(fnt_code_O);
            str = string_replace(str,"<O>","");
            temp_str = "";
            i -= 1;
        } else if(string_copy(str,i,3) == "<F>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_function);
            draw_set_font(fnt_code);
            str = string_replace(str,"<F>","");
            temp_str = "";
            i -= 1;
        } else if(string_copy(str,i,3) == "<P>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_constant);
            draw_set_font(fnt_code);
            str = string_replace(str,"<P>","");
            temp_str = "";
            i -= 1;
        } else if(string_copy(str,i,3) == "<D>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_digit);
            draw_set_font(fnt_code);
            str = string_replace(str,"<D>","");
            temp_str = "";
            i -= 1;
        } else if(string_copy(str,i,3) == "<V>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_text);
            draw_set_font(fnt_code);
            str = string_replace(str,"<V>","");
            temp_str = "";
            i -= 1;
        } else if(string_copy(str,i,3) == "<C>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_comment);
            draw_set_font(fnt_code_C);
            str = string_replace(str,"<C>","");
            temp_str = "";
            i -= 1;
        } else if(string_copy(str,i,3) == "<S>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_string);
            draw_set_font(fnt_code);
            str = string_replace(str,"<S>","");
            temp_str = "";
            i -= 1;
        } else if(string_copy(str,i,3) == "</>") {
            temp_str = string_replace_all(temp_str,"<\","<");
            draw_text(xx,yy,temp_str);
            xx += string_width(temp_str);
            draw_set_color(script_text);
            draw_set_font(fnt_code);
            str = string_replace(str,"</>","");
            temp_str = "";
            i -= 1;
        } else {
            temp_str += string_char_at(str,i);
        }
    }
    temp_str = string_replace_all(temp_str,"<\","<");
    draw_text(xx,yy,temp_str);
} else {
    draw_set_color(c_white);
    draw_set_font(fnt_code);
    str = string_replace_all(str,"<O>","");
    str = string_replace_all(str,"<F>","");
    str = string_replace_all(str,"<D>","");
    str = string_replace_all(str,"<V>","");
    str = string_replace_all(str,"<C>","");
    str = string_replace_all(str,"<S>","");
    str = string_replace_all(str,"</>","");
    draw_text(xx,yy,str);
}

draw_set_color($000000);
draw_set_font(fnt_code);
