// draw_chat(x,y,text)
var str,i,next_x,next_col,draw_string,str_c;
next_x = argument0;
next_y = argument1;
str = string(argument2);

//draw_set_font(fnt_bold);
draw_set_alpha(1);
draw_set_color(c_white);
for(i = 1; i <= string_length(str); i += 1) {
    draw_string = true;;
    if string_copy(str, i, 7) == "<color:" && string_char_at(str, i+13) == ">" {
        if string_hex(string_copy(str, i+7, 6)) { //If the next characters are hex
            draw_set_color(hex_to_dec(string_copy(str, i+7, 6)));
            str = string_delete(str, i, 14);
        }
    } else if string_copy(str, i, 2) == "\c" { //If the current string is \c
        if string_digits(string_char_at(str, i+2)) == string_char_at(str, i+2) { //If the next character is a digit
            if i == 1 || string_char_at(str, i-1) != "\" { //If the \c isn't \\c
                switch string_digits(string_char_at(str, i+2)) {
                    case "0":
                        draw_set_color($ffffff);
                        break;
                    case "1":
                        draw_set_color($aaaaaa);
                        break;
                    case "2":
                        draw_set_color($555555);
                        break;
                    case "3":
                        draw_set_color($000000);
                        break;
                    case "4":
                        draw_set_color($ff0000);
                        break;
                    case "5":
                        draw_set_color($00ff00);
                        break;
                    case "6":
                        draw_set_color($0000ff);
                        break;
                    case "7":
                        draw_set_color($ffff00);
                        break;
                    case "8":
                        draw_set_color($00ffff);
                        break;
                    case "9":
                        draw_set_color($ff00ff);
                        break;
                }
                str = string_delete(str, i, 3);
            } else {
                draw_string = false;
            }
        }
    }
    if draw_string {
        str_c = string_char_at(str, i);
        next_col = draw_get_color();
        draw_set_color(0);
        draw_text(next_x-1,next_y-1,str_c);
        draw_text(next_x+1,next_y-1,str_c);
        draw_text(next_x-1,next_y+1,str_c);
        draw_text(next_x+1,next_y+1,str_c);
        
        draw_set_color(next_col);
        draw_text(next_x, next_y, str_c);
        next_x += string_width(str_c);
    }
}
