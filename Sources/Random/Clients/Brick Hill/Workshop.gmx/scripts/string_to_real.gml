// string_to_real(str): checks if a string can be safely converted with real().
// An acceptable real number takes the following form:
// [whitespaces] [sign] [digits] [. [digits]] [{e | E} [sign] [digits]] [whitespaces]
// At least one digit or a decimal point must be present in prior to the exponent part.
var i, c, len, state;

// Trim white spaces at the end (to make it easier to check the final state.)
len = string_length(string(argument0));
while (len > 1 && string_char_at(string(argument0), len) == ' ') len -= 1;

// Now check the string with a state machine.
state = 0;
for (i = 1; i <= len; i += 1) {
        c = string_char_at(string(argument0), i);
        if (c == ' ') {
                if (state == 0) continue; // Ignore white spaces at the beginning.
                else return false;
        }
        else if (c == '-' || c == '+') {
                // A sign is allowed at the beginning or after 'E'.
                if (state == 0 || state == 5) state += 1;
                else return 0;
        }
        else if (c >= '0' && c <= '9') {
                // A digit is allowed at serveral places...
                if (state <= 2) state = 2; // At the beginning, after a sign or another digit
                else if (state <= 4) state = 4; // After a decimal point
                else if (state <= 7) state = 7; // After an exponent
                else return 0; // Not allowed in other places
        }
        else if (c == '.') {
                // A decimal point is allowed at the beginning, after a sign or a digit.
                if (state <= 2) state = 3;
                else return 0;
        }
        else {
                // No other letters are allowed.
                return 0;
        }
}

// Finally, check that the string ends with at least one digit or a decimal point.
if (state >= 2) return real(string(argument0));
return 0;
