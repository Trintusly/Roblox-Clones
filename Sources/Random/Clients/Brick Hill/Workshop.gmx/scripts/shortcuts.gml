// shortcuts()
if keyboard_check(vk_control) {
    if keyboard_check(vk_shift) {
        if keyboard_check_pressed(ord("S")) save_as();
        if keyboard_check_pressed(ord("L")) import();
    } else {
        if keyboard_check_pressed(ord("C")) copy();
        if keyboard_check_pressed(ord("V")) paste();
        if keyboard_check_pressed(ord("O")) open();
        if keyboard_check_pressed(ord("S")) save();
        if keyboard_check_pressed(ord("N")) new();
        if keyboard_check_pressed(ord("Z")) undo();
        if keyboard_check_pressed(ord("Y")) redo();
    }
} else {
    if keyboard_check(vk_shift) {
        if keyboard_check_pressed(ord("R")) counter_rotate();
    } else {
        if keyboard_check_pressed(ord("R")) rotate();
        if keyboard_check_pressed(vk_delete) delete();
        if keyboard_check_pressed(vk_f1) show_info();
        if keyboard_check_pressed(vk_f5) play();
        if keyboard_check_pressed(vk_f6) export();
        if keyboard_check_pressed(vk_f9) external_edit();
        
        if image_index mod 4 == 0 || keyboard_check_pressed(vk_anykey) {
            if keyboard_check(vk_numpad8) {
                with obj_brick {
                    if ds_list_find_index(obj_control.brick_selection,id) != -1 {
                        x += round(cos(degtorad(obj_control.direction)));
                        y -= round(sin(degtorad(obj_control.direction)));
                    }
                }
            }
            if keyboard_check(vk_numpad2) {
                with obj_brick {
                    if ds_list_find_index(obj_control.brick_selection,id) != -1 {
                        x -= round(cos(degtorad(obj_control.direction)));
                        y += round(sin(degtorad(obj_control.direction)));
                    }
                }
            }
            if keyboard_check(vk_numpad4) {
                with obj_brick {
                    if ds_list_find_index(obj_control.brick_selection,id) != -1 {
                        x += round(cos(degtorad(obj_control.direction+90)));
                        y -= round(sin(degtorad(obj_control.direction+90)));
                    }
                }
            }
            if keyboard_check(vk_numpad6) {
                with obj_brick {
                    if ds_list_find_index(obj_control.brick_selection,id) != -1 {
                        x += round(cos(degtorad(obj_control.direction-90)));
                        y -= round(sin(degtorad(obj_control.direction-90)));
                    }
                }
            }
            if keyboard_check(vk_up) {
                with obj_brick {
                    if ds_list_find_index(obj_control.brick_selection,id) != -1 {
                        z += 1;
                    }
                }
            }
            if keyboard_check(vk_down) {
                with obj_brick {
                    if ds_list_find_index(obj_control.brick_selection,id) != -1 {
                        z -= 1;
                    }
                }
            }
        }
    }
}

if keyboard_string == "bronk" {
keyboard_string = "";
paste_brick("0 -0.50 4 1 1 1 1.00 0.77 0 1
+NAME my head - Copy
+SHAPE cylinder
0 1 2 1 1 2 1.00 0.77 0 1
+NAME my left arm - Copy
0 -1 0 1 1 2 0 0.15 0.26 1
+NAME my right leg - Copy
0 0 0 1 1 2 0 0.15 0.26 1
+NAME my left leg - Copy
0 -1 2 1 2 2 0 0.34 0.66 1
+NAME my torso - Copy
0 -2 2 1 1 2 1.00 0.77 0 1
+NAME my right arm - Copy");
}

/*if keyboard_check(vk_control) && keyboard_check_pressed(ord("L")) {
    file = get_open_filename("brick file|*.brk", "");
    load_file(file);
}

if keyboard_check(vk_control) && keyboard_check(vk_shift) && keyboard_check_pressed(ord("S")) {
    file = get_save_filename("brick file|*.brk", "");
    save_file(file);
} else if keyboard_check(vk_control) && keyboard_check_pressed(ord("S")) {
    save_file(project_path);
}

if keyboard_check_pressed(vk_f1) {
    publish(string_to_real(get_string("Game ID","")));
}

if keyboard_check_pressed(vk_f2) {
    var user;
    user = login(get_string("Username",""),get_string("Password",""));
    if user > 0 {
        show_message("Successfully logged in as user "+string(user));
    } else {
        show_message("Login failed!");
    }
}

if keyboard_check(vk_control) && keyboard_check_pressed(ord("Z")) {
    undo();
}
if keyboard_check(vk_control) && keyboard_check_pressed(ord("Y")) {
    redo();
}
