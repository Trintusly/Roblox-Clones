// getKeyString()
var chars, key;

chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";

key = keyboard_key

if keyboard_check_pressed(key) {
    switch (key) {
        case vk_space:
            return "space"
        case vk_enter:
            return "enter"
        case vk_shift:
            return "shift"
        case vk_control:
            return "control"
        case vk_backspace:
            return "backspace"
        case 0: {
            break
        }
        default: {
            var i, letter;
            for(i = 1; i <= string_length(chars); i += 1) {
                letter = string_char_at(chars, i);
                if key == ord(letter) {
                    return string_lower(letter)
                }
            }
        }
    }
}

return "none"
